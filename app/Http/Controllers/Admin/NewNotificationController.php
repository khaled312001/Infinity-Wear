<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class NewNotificationController extends Controller
{
    /**
     * عرض صفحة الإشعارات الجديدة
     */
    public function index()
    {
        try {
            // التحقق من تسجيل الدخول
            $user = Auth::guard('admin')->user();
            if (!$user) {
                return redirect()->route('admin.login')->with('error', 'يجب تسجيل الدخول أولاً');
            }

            // الحصول على الإشعارات
            $notifications = $this->getNotifications();
            $stats = $this->getNotificationStats();

            return view('admin.notifications.new-index', compact('notifications', 'stats'));
        } catch (\Exception $e) {
            Log::error('Error in NewNotificationController@index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ في تحميل الصفحة');
        }
    }

    /**
     * الحصول على الإشعارات عبر AJAX
     */
    public function getNotificationsAjax(Request $request): JsonResponse
    {
        try {
            // التحقق من تسجيل الدخول
            $user = Auth::guard('admin')->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'يجب تسجيل الدخول أولاً',
                    'notifications' => [],
                    'stats' => $this->getEmptyStats()
                ], 401);
            }

            $type = $request->get('type', 'all');
            $notifications = $this->getNotifications($type);
            $stats = $this->getNotificationStats();

            Log::info('Notifications loaded successfully', [
                'user' => $user->email,
                'count' => $notifications->count(),
                'type' => $type
            ]);

            return response()->json([
                'success' => true,
                'notifications' => $notifications,
                'stats' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getNotificationsAjax: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تحميل الإشعارات',
                'notifications' => [],
                'stats' => $this->getEmptyStats()
            ], 500);
        }
    }

    /**
     * الحصول على إحصائيات الإشعارات
     */
    public function getStatsAjax(): JsonResponse
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'stats' => $this->getEmptyStats()
                ], 401);
            }

            $stats = $this->getNotificationStats();

            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('Error in getStatsAjax: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'stats' => $this->getEmptyStats()
            ], 500);
        }
    }

    /**
     * تحديد إشعار كمقروء
     */
    public function markAsRead(Request $request): JsonResponse
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'يجب تسجيل الدخول أولاً'
                ], 401);
            }

            $notificationId = $request->get('notification_id');
            if (!$notificationId) {
                return response()->json([
                    'success' => false,
                    'message' => 'معرف الإشعار مطلوب'
                ], 400);
            }

            $notification = Notification::find($notificationId);
            if (!$notification) {
                return response()->json([
                    'success' => false,
                    'message' => 'الإشعار غير موجود'
                ], 404);
            }

            $notification->update([
                'is_read' => true,
                'read_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم تحديد الإشعار كمقروء'
            ]);

        } catch (\Exception $e) {
            Log::error('Error in markAsRead: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تحديث الإشعار'
            ], 500);
        }
    }

    /**
     * تحديد جميع الإشعارات كمقروءة
     */
    public function markAllAsRead(): JsonResponse
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'يجب تسجيل الدخول أولاً'
                ], 401);
            }

            $count = Notification::where('is_read', false)
                ->where('is_archived', false)
                ->update([
                    'is_read' => true,
                    'read_at' => now()
                ]);

            return response()->json([
                'success' => true,
                'message' => "تم تحديد {$count} إشعار كمقروء",
                'count' => $count
            ]);

        } catch (\Exception $e) {
            Log::error('Error in markAllAsRead: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تحديث الإشعارات'
            ], 500);
        }
    }

    /**
     * إنشاء إشعار تجريبي
     */
    public function createTestNotification(): JsonResponse
    {
        try {
            $user = Auth::guard('admin')->user();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'يجب تسجيل الدخول أولاً'
                ], 401);
            }

            // إنشاء إشعار تجريبي
            $notification = Notification::create([
                'user_id' => $user->id,
                'type' => 'system',
                'title' => 'إشعار تجريبي',
                'message' => 'هذا إشعار تجريبي تم إنشاؤه في ' . now()->format('Y-m-d H:i:s'),
                'icon' => 'fas fa-bell',
                'color' => 'primary',
                'is_read' => false,
                'is_archived' => false
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم إنشاء إشعار تجريبي بنجاح',
                'notification' => $notification
            ]);

        } catch (\Exception $e) {
            Log::error('Error in createTestNotification: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في إنشاء الإشعار التجريبي'
            ], 500);
        }
    }

    /**
     * الحصول على الإشعارات
     */
    private function getNotifications($type = 'all')
    {
        $query = Notification::where('is_archived', false);

        if ($type !== 'all') {
            $query->where('type', $type);
        }

        return $query->latest()->limit(50)->get();
    }

    /**
     * الحصول على إحصائيات الإشعارات
     */
    private function getNotificationStats()
    {
        try {
            $totalUnread = Notification::where('is_read', false)
                ->where('is_archived', false)
                ->count();

            $orders = Notification::where('is_read', false)
                ->where('is_archived', false)
                ->where('type', 'order')
                ->count();

            $contacts = Notification::where('is_read', false)
                ->where('is_archived', false)
                ->where('type', 'contact')
                ->count();

            $whatsapp = Notification::where('is_read', false)
                ->where('is_archived', false)
                ->where('type', 'whatsapp')
                ->count();

            $importerOrders = Notification::where('is_read', false)
                ->where('is_archived', false)
                ->where('type', 'importer_order')
                ->count();

            return [
                'total_unread' => $totalUnread,
                'orders' => $orders,
                'contacts' => $contacts,
                'whatsapp' => $whatsapp,
                'importer_orders' => $importerOrders,
                'total' => Notification::where('is_archived', false)->count()
            ];
        } catch (\Exception $e) {
            Log::error('Error getting notification stats: ' . $e->getMessage());
            return $this->getEmptyStats();
        }
    }

    /**
     * الحصول على إحصائيات فارغة
     */
    private function getEmptyStats()
    {
        return [
            'total_unread' => 0,
            'orders' => 0,
            'contacts' => 0,
            'whatsapp' => 0,
            'importer_orders' => 0,
            'total' => 0
        ];
    }
}
