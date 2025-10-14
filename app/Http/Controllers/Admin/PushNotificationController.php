<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PushSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class PushNotificationController extends Controller
{
    /**
     * عرض صفحة إدارة Push Notifications
     */
    public function index()
    {
        $subscriptions = PushSubscription::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        $stats = PushSubscription::getStats();
        
        return view('admin.notifications.push-notifications', compact('subscriptions', 'stats'));
    }

    /**
     * الاشتراك في Push Notifications
     */
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'endpoint' => 'required|string',
            'keys' => 'required|array',
            'keys.p256dh' => 'required|string',
            'keys.auth' => 'required|string',
            'user_type' => 'required|string|in:admin,customer,importer',
            'device_type' => 'nullable|string|in:mobile,desktop,tablet'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'بيانات غير صحيحة',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $user = auth('admin')->user();
            $deviceType = $this->detectDeviceType($request);
            
            $subscriptionData = [
                'user_id' => $user ? $user->id : null,
                'user_type' => $request->user_type,
                'endpoint' => $request->endpoint,
                'p256dh_key' => $request->keys['p256dh'],
                'auth_key' => $request->keys['auth'],
                'user_agent' => $request->header('User-Agent'),
                'device_type' => $deviceType,
                'is_active' => true,
                'last_used_at' => now()
            ];

            $subscription = PushSubscription::createOrUpdate($subscriptionData);

            Log::info('Push subscription created/updated', [
                'user_id' => $user ? $user->id : null,
                'user_type' => $request->user_type,
                'device_type' => $deviceType,
                'endpoint' => $request->endpoint
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم الاشتراك في الإشعارات بنجاح',
                'subscription_id' => $subscription->id
            ]);

        } catch (\Exception $e) {
            Log::error('Push subscription error', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في الاشتراك'
            ], 500);
        }
    }

    /**
     * إلغاء الاشتراك في Push Notifications
     */
    public function unsubscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'endpoint' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'بيانات غير صحيحة'
            ], 400);
        }

        try {
            $subscription = PushSubscription::where('endpoint', $request->endpoint)->first();
            
            if ($subscription) {
                $subscription->deactivate();
                
                Log::info('Push subscription deactivated', [
                    'subscription_id' => $subscription->id,
                    'endpoint' => $request->endpoint
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'تم إلغاء الاشتراك بنجاح'
            ]);

        } catch (\Exception $e) {
            Log::error('Push unsubscription error', [
                'error' => $e->getMessage(),
                'endpoint' => $request->endpoint
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في إلغاء الاشتراك'
            ], 500);
        }
    }

    /**
     * إرسال Push Notification
     */
    public function sendNotification(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'body' => 'required|string|max:500',
            'icon' => 'nullable|string',
            'url' => 'nullable|string',
            'user_type' => 'nullable|string|in:admin,customer,importer',
            'user_id' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'بيانات غير صحيحة',
                'errors' => $validator->errors()
            ], 400);
        }

        try {
            $subscriptions = PushSubscription::getActiveSubscriptions(
                $request->user_type ?? 'admin',
                $request->user_id
            );

            if ($subscriptions->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'لا توجد اشتراكات نشطة'
                ], 404);
            }

            $payload = [
                'title' => $request->title,
                'body' => $request->body,
                'icon' => $request->icon ?? '/images/logo.png',
                'badge' => '/images/logo.png',
                'url' => $request->url ?? '/admin/notifications',
                'timestamp' => now()->toISOString()
            ];

            $sentCount = $this->sendToSubscriptions($subscriptions, $payload);

            return response()->json([
                'success' => true,
                'message' => "تم إرسال الإشعار إلى {$sentCount} جهاز",
                'sent_count' => $sentCount,
                'total_subscriptions' => $subscriptions->count()
            ]);

        } catch (\Exception $e) {
            Log::error('Push notification send error', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في إرسال الإشعار'
            ], 500);
        }
    }

    /**
     * إرسال الإشعار إلى قائمة من الاشتراكات
     */
    private function sendToSubscriptions($subscriptions, $payload)
    {
        $sentCount = 0;
        $vapidKeys = $this->getVapidKeys();

        $webPush = new WebPush([
            'VAPID' => [
                'subject' => config('app.url'),
                'publicKey' => $vapidKeys['public_key'],
                'privateKey' => $vapidKeys['private_key']
            ]
        ]);

        foreach ($subscriptions as $subscription) {
            try {
                $pushSubscription = Subscription::create([
                    'endpoint' => $subscription->endpoint,
                    'keys' => [
                        'p256dh' => $subscription->p256dh_key,
                        'auth' => $subscription->auth_key
                    ]
                ]);

                $webPush->queueNotification(
                    $pushSubscription,
                    json_encode($payload)
                );

                $subscription->updateLastUsed();
                $sentCount++;

            } catch (\Exception $e) {
                Log::warning('Failed to send push notification', [
                    'subscription_id' => $subscription->id,
                    'error' => $e->getMessage()
                ]);

                // إلغاء تفعيل الاشتراك إذا كان غير صالح
                if (str_contains($e->getMessage(), '410') || str_contains($e->getMessage(), '404')) {
                    $subscription->deactivate();
                }
            }
        }

        // إرسال جميع الإشعارات
        $webPush->flush();

        return $sentCount;
    }

    /**
     * اختبار إرسال Push Notification
     */
    public function testNotification(Request $request)
    {
        $user = auth('admin')->user();
        
        $payload = [
            'title' => 'اختبار الإشعارات',
            'body' => 'هذا اختبار لنظام الإشعارات - ' . now()->format('Y-m-d H:i:s'),
            'icon' => '/images/logo.png',
            'url' => '/admin/notifications',
            'timestamp' => now()->toISOString()
        ];

        try {
            $subscriptions = PushSubscription::getActiveSubscriptions('admin', $user->id);
            
            if ($subscriptions->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'لا توجد اشتراكات نشطة لهذا المستخدم'
                ], 404);
            }

            $sentCount = $this->sendToSubscriptions($subscriptions, $payload);

            return response()->json([
                'success' => true,
                'message' => "تم إرسال إشعار تجريبي إلى {$sentCount} جهاز",
                'sent_count' => $sentCount
            ]);

        } catch (\Exception $e) {
            Log::error('Test push notification error', [
                'error' => $e->getMessage(),
                'user_id' => $user->id
            ]);

            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في إرسال الإشعار التجريبي'
            ], 500);
        }
    }

    /**
     * حذف اشتراك
     */
    public function deleteSubscription($id)
    {
        try {
            $subscription = PushSubscription::findOrFail($id);
            $subscription->delete();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف الاشتراك بنجاح'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في حذف الاشتراك'
            ], 500);
        }
    }

    /**
     * تفعيل/إلغاء تفعيل اشتراك
     */
    public function toggleSubscription($id)
    {
        try {
            $subscription = PushSubscription::findOrFail($id);
            $subscription->is_active ? $subscription->deactivate() : $subscription->activate();

            return response()->json([
                'success' => true,
                'message' => $subscription->is_active ? 'تم تفعيل الاشتراك' : 'تم إلغاء تفعيل الاشتراك',
                'is_active' => $subscription->is_active
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تحديث الاشتراك'
            ], 500);
        }
    }

    /**
     * تنظيف الاشتراكات القديمة
     */
    public function cleanupOldSubscriptions()
    {
        try {
            $deletedCount = PushSubscription::cleanupOldSubscriptions();

            return response()->json([
                'success' => true,
                'message' => "تم حذف {$deletedCount} اشتراك قديم",
                'deleted_count' => $deletedCount
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تنظيف الاشتراكات'
            ], 500);
        }
    }

    /**
     * الحصول على إحصائيات محدثة
     */
    public function getStats()
    {
        $stats = PushSubscription::getStats();
        
        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * اكتشاف نوع الجهاز
     */
    private function detectDeviceType(Request $request)
    {
        $userAgent = $request->header('User-Agent', '');
        
        if (preg_match('/Mobile|Android|iPhone|iPad/', $userAgent)) {
            return 'mobile';
        } elseif (preg_match('/Tablet|iPad/', $userAgent)) {
            return 'tablet';
        } else {
            return 'desktop';
        }
    }

    /**
     * الحصول على مفاتيح VAPID
     */
    private function getVapidKeys()
    {
        return [
            'public_key' => config('push.vapid.public_key'),
            'private_key' => config('push.vapid.private_key')
        ];
    }
}
