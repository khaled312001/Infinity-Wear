<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\PushSubscription;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * عرض صفحة الإشعارات
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $userType = $user->user_type ?? 'admin';
        
        // الحصول على الإشعارات
        $notifications = Notification::where('user_id', $user->id)
            ->notArchived()
            ->latest()
            ->paginate(20);

        // الحصول على الإحصائيات
        $stats = $this->notificationService->getNotificationStats();

        return view('admin.notifications.index', compact('notifications', 'stats', 'userType'));
    }

    /**
     * الحصول على الإشعارات عبر AJAX
     */
    public function getNotifications(Request $request)
    {
        $user = Auth::user();
        $limit = $request->get('limit', 10);
        $type = $request->get('type');
        $unreadOnly = $request->get('unread_only', false);

        $query = Notification::where('user_id', $user->id)
            ->notArchived();

        if ($type) {
            $query->ofType($type);
        }

        if ($unreadOnly) {
            $query->unread();
        }

        $notifications = $query->latest()
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'notifications' => $notifications,
            'unread_count' => $this->notificationService->getUnreadCount()
        ]);
    }

    /**
     * تحديد إشعار كمقروء
     */
    public function markAsRead(Request $request, $id)
    {
        $user = Auth::user();
        $notification = Notification::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'الإشعار غير موجود'
            ], 404);
        }

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'تم تحديد الإشعار كمقروء'
        ]);
    }

    /**
     * تحديد جميع الإشعارات كمقروءة
     */
    public function markAllAsRead(Request $request)
    {
        $user = Auth::user();
        $count = $this->notificationService->markAllAsRead();

        return response()->json([
            'success' => true,
            'message' => "تم تحديد {$count} إشعار كمقروء",
            'count' => $count
        ]);
    }

    /**
     * أرشفة إشعار
     */
    public function archive(Request $request, $id)
    {
        $user = Auth::user();
        $notification = Notification::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'الإشعار غير موجود'
            ], 404);
        }

        $notification->archive();

        return response()->json([
            'success' => true,
            'message' => 'تم أرشفة الإشعار'
        ]);
    }

    /**
     * أرشفة جميع الإشعارات المقروءة
     */
    public function archiveRead(Request $request)
    {
        $user = Auth::user();
        $count = Notification::where('user_id', $user->id)
            ->where('is_read', true)
            ->where('is_archived', false)
            ->update([
                'is_archived' => true,
                'archived_at' => now()
            ]);

        return response()->json([
            'success' => true,
            'message' => "تم أرشفة {$count} إشعار",
            'count' => $count
        ]);
    }

    /**
     * حذف إشعار
     */
    public function delete(Request $request, $id)
    {
        $user = Auth::user();
        $notification = Notification::where('id', $id)
            ->where('user_id', $user->id)
            ->first();

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => 'الإشعار غير موجود'
            ], 404);
        }

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الإشعار'
        ]);
    }

    /**
     * الحصول على إحصائيات الإشعارات
     */
    public function getStats(Request $request)
    {
        $stats = $this->notificationService->getNotificationStats();

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * تسجيل اشتراك Push Notification
     */
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'endpoint' => 'required|url',
            'keys.p256dh' => 'required|string',
            'keys.auth' => 'required|string',
            'user_agent' => 'nullable|string',
            'device_type' => 'nullable|string|in:mobile,desktop,tablet'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'بيانات غير صحيحة',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        
        $subscription = PushSubscription::createOrUpdate([
            'user_id' => $user->id,
            'user_type' => $user->user_type ?? 'admin',
            'endpoint' => $request->endpoint,
            'p256dh_key' => $request->keys['p256dh'],
            'auth_key' => $request->keys['auth'],
            'user_agent' => $request->user_agent,
            'device_type' => $request->device_type ?? 'desktop',
            'is_active' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الاشتراك بنجاح',
            'subscription' => $subscription
        ]);
    }

    /**
     * إلغاء اشتراك Push Notification
     */
    public function unsubscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'endpoint' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'بيانات غير صحيحة',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();
        
        $subscription = PushSubscription::where('endpoint', $request->endpoint)
            ->where('user_id', $user->id)
            ->first();

        if ($subscription) {
            $subscription->deactivate();
            
            return response()->json([
                'success' => true,
                'message' => 'تم إلغاء الاشتراك بنجاح'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'الاشتراك غير موجود'
        ], 404);
    }

    /**
     * إرسال إشعار تجريبي
     */
    public function sendTestNotification(Request $request)
    {
        $user = Auth::user();
        
        $notification = $this->notificationService->sendAdvancedNotification(
            'system',
            'إشعار تجريبي',
            'هذا إشعار تجريبي لاختبار النظام',
            ['test' => true],
            [$user->id],
            $user->user_type ?? 'admin'
        );

        if ($notification) {
            return response()->json([
                'success' => true,
                'message' => 'تم إرسال الإشعار التجريبي بنجاح'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'فشل في إرسال الإشعار التجريبي'
        ], 500);
    }

    /**
     * تنظيف الإشعارات القديمة
     */
    public function cleanup(Request $request)
    {
        $this->notificationService->cleanupOldNotifications();

        return response()->json([
            'success' => true,
            'message' => 'تم تنظيف الإشعارات القديمة'
        ]);
    }
}
