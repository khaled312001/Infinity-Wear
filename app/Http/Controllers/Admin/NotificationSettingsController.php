<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class NotificationSettingsController extends Controller
{
    /**
     * عرض صفحة إعدادات الإشعارات
     */
    public function index()
    {
        $settings = NotificationSetting::getSettings();
        return view('admin.notifications.settings', compact('settings'));
    }

    /**
     * تحديث إعدادات الإشعارات
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_notifications_enabled' => 'boolean',
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|integer|min:1|max:65535',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string|max:255',
            'smtp_encryption' => 'nullable|in:tls,ssl,null',
            'from_email' => 'nullable|email|max:255',
            'from_name' => 'nullable|string|max:255',
            'admin_email' => 'nullable|email|max:255',
            'notify_new_orders' => 'boolean',
            'notify_contact_messages' => 'boolean',
            'notify_whatsapp_messages' => 'boolean',
            'notify_importer_orders' => 'boolean',
            'notify_system_updates' => 'boolean',
            'email_verification_enabled' => 'boolean',
            'email_rate_limit' => 'nullable|integer|min:1|max:1000',
            'email_queue_enabled' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $data = $request->only([
                'email_notifications_enabled',
                'smtp_host',
                'smtp_port',
                'smtp_username',
                'smtp_password',
                'smtp_encryption',
                'from_email',
                'from_name',
                'admin_email',
                'notify_new_orders',
                'notify_contact_messages',
                'notify_whatsapp_messages',
                'notify_importer_orders',
                'notify_system_updates',
                'email_verification_enabled',
                'email_rate_limit',
                'email_queue_enabled',
            ]);

            // تحويل القيم المنطقية
            $data['email_notifications_enabled'] = $request->has('email_notifications_enabled');
            $data['notify_new_orders'] = $request->has('notify_new_orders');
            $data['notify_contact_messages'] = $request->has('notify_contact_messages');
            $data['notify_whatsapp_messages'] = $request->has('notify_whatsapp_messages');
            $data['notify_importer_orders'] = $request->has('notify_importer_orders');
            $data['notify_system_updates'] = $request->has('notify_system_updates');
            $data['email_verification_enabled'] = $request->has('email_verification_enabled');
            $data['email_queue_enabled'] = $request->has('email_queue_enabled');

            NotificationSetting::updateSettings($data);

            Log::info('Notification settings updated', [
                'user' => auth('admin')->user() ? auth('admin')->user()->email : 'unknown',
                'settings' => array_keys($data)
            ]);

            return redirect()->route('admin.notifications.settings')
                ->with('success', 'تم تحديث إعدادات الإشعارات بنجاح');

        } catch (\Exception $e) {
            Log::error('Error updating notification settings: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'حدث خطأ في تحديث الإعدادات: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * اختبار إعدادات البريد الإلكتروني
     */
    public function testEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'test_email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'يرجى إدخال بريد إلكتروني صحيح'
            ], 400);
        }

        try {
            $settings = NotificationSetting::getSettings();
            
            if (!$settings->isEmailNotificationsEnabled()) {
                return response()->json([
                    'success' => false,
                    'message' => 'إعدادات البريد الإلكتروني غير مكتملة'
                ], 400);
            }

            // إرسال بريد تجريبي
            Mail::raw('هذا بريد تجريبي من نظام إشعارات Infinity Wear', function ($message) use ($request, $settings) {
                $message->to($request->test_email)
                        ->subject('اختبار إعدادات البريد الإلكتروني - Infinity Wear')
                        ->from($settings->from_email, $settings->from_name);
            });

            Log::info('Test email sent successfully', [
                'to' => $request->test_email,
                'user' => auth('admin')->user() ? auth('admin')->user()->email : 'unknown'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم إرسال البريد التجريبي بنجاح'
            ]);

        } catch (\Exception $e) {
            Log::error('Error sending test email: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'فشل في إرسال البريد التجريبي: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * إعادة تعيين الإعدادات للقيم الافتراضية
     */
    public function reset()
    {
        try {
            $defaultSettings = [
                'email_notifications_enabled' => true,
                'smtp_port' => 587,
                'smtp_encryption' => 'tls',
                'from_name' => 'Infinity Wear',
                'notify_new_orders' => true,
                'notify_contact_messages' => true,
                'notify_whatsapp_messages' => true,
                'notify_importer_orders' => true,
                'notify_system_updates' => true,
                'email_verification_enabled' => true,
                'email_rate_limit' => 60,
                'email_queue_enabled' => true,
                'smtp_host' => null,
                'smtp_username' => null,
                'smtp_password' => null,
                'from_email' => null,
                'admin_email' => null,
            ];

            NotificationSetting::updateSettings($defaultSettings);

            Log::info('Notification settings reset to defaults', [
                'user' => auth('admin')->user() ? auth('admin')->user()->email : 'unknown'
            ]);

            return redirect()->route('admin.notifications.settings')
                ->with('success', 'تم إعادة تعيين الإعدادات للقيم الافتراضية');

        } catch (\Exception $e) {
            Log::error('Error resetting notification settings: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'حدث خطأ في إعادة تعيين الإعدادات: ' . $e->getMessage());
        }
    }
}
