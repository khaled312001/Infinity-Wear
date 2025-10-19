<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use App\Mail\TestMail;
use App\Services\NotificationService;

class MailTestController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * اختبار إعدادات البريد الإلكتروني
     */
    public function testMailSettings()
    {
        try {
            // تحديث إعدادات البريد الإلكتروني
            $this->updateMailConfig();
            
            // اختبار الاتصال
            $result = $this->testConnection();
            
            return response()->json([
                'success' => true,
                'message' => 'تم اختبار إعدادات البريد الإلكتروني بنجاح',
                'data' => $result
            ]);
            
        } catch (\Exception $e) {
            Log::error('Mail test failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'فشل في اختبار البريد الإلكتروني',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * إرسال إيميل تجريبي
     */
    public function sendTestEmail(Request $request)
    {
        $request->validate([
            'to' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:1000'
        ]);

        try {
            // تحديث إعدادات البريد الإلكتروني
            $this->updateMailConfig();
            
            $to = $request->to;
            $subject = $request->subject ?? 'اختبار البريد الإلكتروني - Infinity Wear';
            $message = $request->message ?? 'هذا إيميل تجريبي للتأكد من عمل نظام البريد الإلكتروني بشكل صحيح.';
            
            // إرسال الإيميل
            Mail::to($to)->send(new TestMail($subject, $message));
            
            Log::info('Test email sent successfully', [
                'to' => $to,
                'subject' => $subject
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'تم إرسال الإيميل التجريبي بنجاح',
                'data' => [
                    'to' => $to,
                    'subject' => $subject,
                    'sent_at' => now()->toISOString()
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to send test email: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'فشل في إرسال الإيميل التجريبي',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * اختبار إشعارات النظام
     */
    public function testNotificationEmail(Request $request)
    {
        $request->validate([
            'to' => 'required|email',
            'type' => 'required|in:order,contact,whatsapp,importer_order,system,task,marketing,sales'
        ]);

        try {
            // تحديث إعدادات البريد الإلكتروني
            $this->updateMailConfig();
            
            $to = $request->to;
            $type = $request->type;
            
            // إنشاء بيانات تجريبية حسب النوع
            $testData = $this->getTestData($type);
            
            // إرسال إشعار تجريبي
            $this->notificationService->sendEmailNotification(
                $type,
                $testData,
                $to
            );
            
            Log::info('Test notification email sent successfully', [
                'to' => $to,
                'type' => $type
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'تم إرسال إشعار تجريبي بنجاح',
                'data' => [
                    'to' => $to,
                    'type' => $type,
                    'sent_at' => now()->toISOString()
                ]
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to send test notification email: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'فشل في إرسال الإشعار التجريبي',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * اختبار شامل للنظام
     */
    public function runFullTest(Request $request)
    {
        $request->validate([
            'to' => 'required|email'
        ]);

        $to = $request->to;
        $results = [];
        
        try {
            // 1. اختبار الاتصال
            $results['connection'] = $this->testConnection();
            
            // 2. اختبار إيميل بسيط
            $results['simple_email'] = $this->testSimpleEmail($to);
            
            // 3. اختبار إشعارات النظام
            $results['notifications'] = $this->testAllNotifications($to);
            
            // 4. اختبار Push Notifications
            $results['push_notifications'] = $this->testPushNotifications();
            
            return response()->json([
                'success' => true,
                'message' => 'تم إجراء الاختبار الشامل بنجاح',
                'data' => $results
            ]);
            
        } catch (\Exception $e) {
            Log::error('Full test failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'فشل في الاختبار الشامل',
                'error' => $e->getMessage(),
                'partial_results' => $results
            ], 500);
        }
    }

    /**
     * تحديث إعدادات البريد الإلكتروني
     */
    private function updateMailConfig()
    {
        Config::set([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.host' => 'smtp.hostinger.com',
            'mail.mailers.smtp.port' => 465,
            'mail.mailers.smtp.username' => 'info@infinitywearsa.com',
            'mail.mailers.smtp.password' => 'Info2025#*',
            'mail.mailers.smtp.encryption' => 'ssl',
            'mail.from.address' => 'info@infinitywearsa.com',
            'mail.from.name' => 'Infinity Wear',
        ]);
    }

    /**
     * اختبار الاتصال
     */
    private function testConnection()
    {
        try {
            $transport = new \Swift_SmtpTransport(
                'smtp.hostinger.com',
                465,
                'ssl'
            );
            
            $transport->setUsername('info@infinitywearsa.com');
            $transport->setPassword('Info2025#*');
            
            $mailer = new \Swift_Mailer($transport);
            $mailer->getTransport()->start();
            
            return [
                'status' => 'success',
                'message' => 'تم الاتصال بالخادم بنجاح',
                'server' => 'smtp.hostinger.com:465 (SSL)'
            ];
            
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'فشل في الاتصال بالخادم',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * اختبار إيميل بسيط
     */
    private function testSimpleEmail($to)
    {
        try {
            Mail::to($to)->send(new TestMail(
                'اختبار البريد الإلكتروني - Infinity Wear',
                'هذا إيميل تجريبي للتأكد من عمل نظام البريد الإلكتروني بشكل صحيح.'
            ));
            
            return [
                'status' => 'success',
                'message' => 'تم إرسال الإيميل البسيط بنجاح'
            ];
            
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'فشل في إرسال الإيميل البسيط',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * اختبار جميع أنواع الإشعارات
     */
    private function testAllNotifications($to)
    {
        $types = ['order', 'contact', 'whatsapp', 'importer_order', 'system', 'task', 'marketing', 'sales'];
        $results = [];
        
        foreach ($types as $type) {
            try {
                $testData = $this->getTestData($type);
                $this->notificationService->sendEmailNotification($type, $testData, $to);
                
                $results[$type] = [
                    'status' => 'success',
                    'message' => "تم إرسال إشعار {$type} بنجاح"
                ];
                
            } catch (\Exception $e) {
                $results[$type] = [
                    'status' => 'error',
                    'message' => "فشل في إرسال إشعار {$type}",
                    'error' => $e->getMessage()
                ];
            }
        }
        
        return $results;
    }

    /**
     * اختبار Push Notifications
     */
    private function testPushNotifications()
    {
        try {
            // اختبار إرسال إشعار متقدم
            $result = $this->notificationService->sendAdvancedNotification(
                'system',
                'اختبار Push Notifications',
                'هذا اختبار لنظام الإشعارات المتقدم',
                ['test' => true],
                null,
                'admin'
            );
            
            return [
                'status' => 'success',
                'message' => 'تم اختبار Push Notifications بنجاح',
                'result' => $result ? 'sent' : 'not_sent'
            ];
            
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'فشل في اختبار Push Notifications',
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * الحصول على بيانات تجريبية حسب النوع
     */
    private function getTestData($type)
    {
        switch ($type) {
            case 'order':
                return (object) [
                    'id' => 999,
                    'customer_name' => 'عميل تجريبي',
                    'total' => 1500,
                    'order_number' => 'TEST-001'
                ];
                
            case 'contact':
                return (object) [
                    'id' => 999,
                    'name' => 'مستخدم تجريبي',
                    'email' => 'test@example.com',
                    'subject' => 'رسالة تجريبية',
                    'message' => 'هذه رسالة تجريبية لاختبار النظام'
                ];
                
            case 'whatsapp':
                return (object) [
                    'id' => 999,
                    'sender_name' => 'مستخدم واتساب تجريبي',
                    'from_number' => '+966501234567',
                    'message_content' => 'رسالة واتساب تجريبية'
                ];
                
            case 'importer_order':
                return (object) [
                    'id' => 999,
                    'importer' => (object) ['company_name' => 'شركة تجريبية'],
                    'importer_id' => 999
                ];
                
            case 'system':
                return [
                    'title' => 'اختبار النظام',
                    'message' => 'هذا اختبار لنظام الإشعارات',
                    'data' => ['test' => true]
                ];
                
            case 'task':
                return (object) [
                    'id' => 999,
                    'title' => 'مهمة تجريبية',
                    'priority' => 'high',
                    'due_date' => now()->addDays(7)
                ];
                
            case 'marketing':
                return (object) [
                    'id' => 999,
                    'company_name' => 'شركة تسويقية تجريبية',
                    'representative_name' => 'مندوب تجريبي',
                    'status' => 'pending',
                    'agreement_status' => 'agreed',
                    'target_quantity' => 100
                ];
                
            case 'sales':
                return (object) [
                    'id' => 999,
                    'company_name' => 'شركة مبيعات تجريبية',
                    'representative_name' => 'مندوب مبيعات تجريبي',
                    'status' => 'pending',
                    'agreement_status' => 'agreed',
                    'target_quantity' => 200
                ];
                
            default:
                return (object) ['id' => 999, 'test' => true];
        }
    }
}
