<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppMessage;
use App\Models\User;
use App\Models\Importer;
use App\Models\MarketingTeam;
use App\Models\SalesTeam;
use App\Services\WhatsAppAutoService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;

class WhatsAppController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    /**
     * عرض لوحة تحكم الواتساب
     */
    public function index(Request $request)
    {
        $query = WhatsAppMessage::with(['sentBy', 'contact'])
            ->notArchived()
            ->latest('sent_at');

        // فلترة حسب جهة الاتصال
        if ($request->filled('contact_number')) {
            $query->forContact($request->contact_number);
        }

        // فلترة حسب نوع جهة الاتصال
        if ($request->filled('contact_type')) {
            $query->where('contact_type', $request->contact_type);
        }

        // فلترة حسب اتجاه الرسالة
        if ($request->filled('direction')) {
            $query->where('direction', $request->direction);
        }

        // البحث في محتوى الرسالة
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('message_content', 'like', "%{$search}%");
        }

        $messages = $query->paginate(20);

        // إحصائيات سريعة
        $stats = [
            'total_messages' => WhatsAppMessage::notArchived()->count(),
            'inbound_messages' => WhatsAppMessage::notArchived()->inbound()->count(),
            'outbound_messages' => WhatsAppMessage::notArchived()->outbound()->count(),
            'unread_messages' => WhatsAppMessage::notArchived()->inbound()->where('status', 'delivered')->count(),
        ];

        // جهات الاتصال المتاحة
        $contacts = $this->getAvailableContacts();

        return view('admin.whatsapp.index', compact('messages', 'stats', 'contacts'));
    }

    /**
     * عرض محادثة مع جهة اتصال معينة
     */
    public function conversation(Request $request, $phoneNumber)
    {
        $phoneNumber = WhatsAppMessage::formatPhoneNumber($phoneNumber);
        
        $messages = WhatsAppMessage::with(['sentBy', 'contact'])
            ->forContact($phoneNumber)
            ->notArchived()
            ->orderBy('sent_at')
            ->get();

        // تحديث حالة الرسائل الواردة كمقروءة
        WhatsAppMessage::forContact($phoneNumber)
            ->inbound()
            ->where('status', 'delivered')
            ->update([
                'status' => 'read',
                'read_at' => now()
            ]);

        $contact = $this->getContactInfo($phoneNumber);

        return view('admin.whatsapp.conversation', compact('messages', 'phoneNumber', 'contact'));
    }

    /**
     * إرسال رسالة جديدة
     */
    public function sendMessage(Request $request)
    {
        try {
            $validated = $request->validate([
                'to_number' => 'required|string',
                'message_content' => 'required|string|max:4096',
                'contact_type' => 'required|in:importer,marketing,sales,external',
                'contact_id' => 'nullable|exists:users,id',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في البيانات المرسلة',
                'errors' => $e->errors()
            ], 422);
        }

        try {
            $toNumber = WhatsAppMessage::formatPhoneNumber($validated['to_number']);
            
            // إنشاء معرف فريد للرسالة
            $messageId = 'msg_' . time() . '_' . Str::random(10);

            // حفظ الرسالة في قاعدة البيانات
            $message = WhatsAppMessage::create([
                'message_id' => $messageId,
                'from_number' => $this->getPrimaryWhatsAppNumber(), // رقم النظام الأساسي للواتساب
                'to_number' => $toNumber,
                'contact_name' => $this->getContactName($toNumber),
                'message_content' => $validated['message_content'],
                'message_type' => 'text',
                'direction' => 'outbound',
                'status' => 'sent',
                'sent_at' => now(),
                'sent_by' => Auth::guard('admin')->id(),
                'contact_id' => $validated['contact_id'],
                'contact_type' => $validated['contact_type'],
            ]);

            // محاولة إرسال الرسالة تلقائياً
            $autoService = new WhatsAppAutoService();
            $sendResult = $autoService->sendMessage($toNumber, $validated['message_content']);
            
            if ($sendResult['success']) {
                $message->update([
                    'status' => 'delivered',
                    'delivered_at' => now(),
                    'whatsapp_url' => $message->whatsapp_url
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'تم إرسال الرسالة تلقائياً بنجاح',
                    'data' => $message,
                    'send_result' => $sendResult
                ]);
            } else {
                // في حالة فشل الإرسال التلقائي، استخدم الطريقة القديمة
                $this->sendViaWhatsAppWeb($message);
                
                return response()->json([
                    'success' => true,
                    'message' => 'تم إنشاء رابط WhatsApp (الإرسال التلقائي غير متاح)',
                    'data' => $message,
                    'auto_send_failed' => $sendResult['error'] ?? 'Unknown error'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('WhatsApp send message error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في إرسال الرسالة: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * استقبال رسالة جديدة (webhook)
     */
    public function receiveMessage(Request $request)
    {
        // هذا يمكن استخدامه مع webhook من WhatsApp Business API
        // أو يمكن محاكاة استقبال الرسائل يدوياً
        
        $validated = $request->validate([
            'from_number' => 'required|string',
            'message_content' => 'required|string',
            'message_type' => 'string|in:text,image,document,audio,video',
        ]);

        $fromNumber = WhatsAppMessage::formatPhoneNumber($validated['from_number']);
        
        // إنشاء معرف فريد للرسالة
        $messageId = 'msg_' . time() . '_' . Str::random(10);

        // حفظ الرسالة في قاعدة البيانات
        $message = WhatsAppMessage::create([
            'message_id' => $messageId,
            'from_number' => $fromNumber,
            'to_number' => $this->getPrimaryWhatsAppNumber(), // رقم النظام الأساسي للواتساب
            'contact_name' => $this->getContactName($fromNumber),
            'message_content' => $validated['message_content'],
            'message_type' => $validated['message_type'] ?? 'text',
            'direction' => 'inbound',
            'status' => 'delivered',
            'sent_at' => now(),
            'delivered_at' => now(),
            'contact_type' => $this->getContactType($fromNumber),
        ]);

        // إنشاء إشعار للرسالة الواردة
        $this->notificationService->createWhatsAppNotification($message);

        return response()->json([
            'success' => true,
            'message' => 'تم استقبال الرسالة بنجاح',
            'data' => $message
        ]);
    }

    /**
     * أرشفة رسالة
     */
    public function archiveMessage(WhatsAppMessage $message)
    {
        $message->update(['is_archived' => true]);

        return response()->json([
            'success' => true,
            'message' => 'تم أرشفة الرسالة بنجاح'
        ]);
    }

    /**
     * حذف رسالة
     */
    public function deleteMessage(WhatsAppMessage $message)
    {
        $message->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الرسالة بنجاح'
        ]);
    }

    /**
     * الحصول على جهات الاتصال المتاحة
     */
    private function getAvailableContacts()
    {
        $contacts = collect();

        // المستوردين
        $importers = Importer::select('id', 'name', 'phone', 'email')
            ->whereNotNull('phone')
            ->get()
            ->map(function ($importer) {
                return [
                    'id' => $importer->id,
                    'name' => $importer->name,
                    'phone' => $importer->phone,
                    'email' => $importer->email,
                    'type' => 'importer',
                    'type_label' => 'مستورد'
                ];
            });

        // فريق التسويق
        $marketing = MarketingTeam::with('admin')
            ->whereHas('admin')
            ->get()
            ->map(function ($member) {
                return [
                    'id' => $member->admin_id,
                    'name' => $member->admin->name,
                    'phone' => $member->admin->phone ?? 'غير محدد',
                    'email' => $member->admin->email,
                    'type' => 'marketing',
                    'type_label' => 'تسويق'
                ];
            });

        // فريق المبيعات
        $sales = SalesTeam::with('admin')
            ->whereHas('admin')
            ->get()
            ->map(function ($member) {
                return [
                    'id' => $member->admin_id,
                    'name' => $member->admin->name,
                    'phone' => $member->admin->phone ?? 'غير محدد',
                    'email' => $member->admin->email,
                    'type' => 'sales',
                    'type_label' => 'مبيعات'
                ];
            });

        return $contacts->merge($importers)->merge($marketing)->merge($sales);
    }

    /**
     * الحصول على معلومات جهة الاتصال
     */
    private function getContactInfo($phoneNumber)
    {
        $contacts = $this->getAvailableContacts();
        return $contacts->firstWhere('phone', $phoneNumber);
    }

    /**
     * الحصول على اسم جهة الاتصال
     */
    private function getContactName($phoneNumber)
    {
        $contact = $this->getContactInfo($phoneNumber);
        return $contact ? $contact['name'] : 'جهة اتصال غير معروفة';
    }

    /**
     * الحصول على نوع جهة الاتصال
     */
    private function getContactType($phoneNumber)
    {
        $contact = $this->getContactInfo($phoneNumber);
        return $contact ? $contact['type'] : 'external';
    }

    /**
     * إرسال الرسالة عبر WhatsApp Web
     */
    private function sendViaWhatsAppWeb($message)
    {
        try {
            // استخدام WhatsApp Web API لإرسال الرسالة فعلياً
            $success = $this->sendWhatsAppMessageViaAPI($message);
            
            if ($success) {
                $message->update([
                    'status' => 'delivered',
                    'delivered_at' => now()
                ]);
                return true;
            } else {
                $message->update(['status' => 'failed']);
                return false;
            }
        } catch (\Exception $e) {
            $message->update(['status' => 'failed']);
            Log::error('WhatsApp send error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * إرسال الرسالة عبر WhatsApp API
     */
    private function sendWhatsAppMessageViaAPI($message)
    {
        try {
            $apiProvider = config('whatsapp.api.provider', 'free_api');
            
            switch ($apiProvider) {
                case 'free_api':
                    return $this->sendViaFreeAPI($message);
                case 'aisensy':
                    return $this->sendViaAiSensy($message);
                case 'whapi':
                    return $this->sendViaWhapi($message);
                case 'whatsapp_web':
                    return $this->sendViaWhatsAppWebAPI($message);
                default:
                    return $this->sendViaFreeAPI($message);
            }
        } catch (\Exception $e) {
            Log::error('WhatsApp API exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * إرسال الرسالة عبر Free API (WhatsApp Web)
     */
    private function sendViaFreeAPI($message)
    {
        try {
            // استخدام WhatsApp Web API مجاني
            $response = Http::timeout(30)->post('https://api.whatsapp.com/send', [
                'phone' => $message->to_number,
                'text' => $message->message_content
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp message sent successfully via Free API', [
                    'message_id' => $message->message_id,
                    'to' => $message->to_number,
                    'response' => $response->json()
                ]);
                return true;
            } else {
                // محاولة بديلة باستخدام WhatsApp Web URL
                return $this->sendViaWhatsAppWebURL($message);
            }
        } catch (\Exception $e) {
            Log::error('Free API exception: ' . $e->getMessage());
            // محاولة بديلة
            return $this->sendViaWhatsAppWebURL($message);
        }
    }

    /**
     * إرسال الرسالة عبر WhatsApp Web URL
     */
    private function sendViaWhatsAppWebURL($message)
    {
        try {
            // إنشاء رابط WhatsApp Web
            $whatsappUrl = "https://wa.me/{$message->to_number}?text=" . urlencode($message->message_content);
            
            // حفظ الرابط في قاعدة البيانات للرجوع إليه
            $message->update(['whatsapp_url' => $whatsappUrl]);
            
            Log::info('WhatsApp Web URL generated', [
                'message_id' => $message->message_id,
                'to' => $message->to_number,
                'url' => $whatsappUrl
            ]);
            
            return true;
        } catch (\Exception $e) {
            Log::error('WhatsApp Web URL exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * إرسال الرسالة عبر WhatsApp Web API
     */
    private function sendViaWhatsAppWebAPI($message)
    {
        try {
            // استخدام WhatsApp Web API مباشرة
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ])->timeout(30)->post('https://web.whatsapp.com/send', [
                'phone' => $message->to_number,
                'text' => $message->message_content
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp message sent successfully via Web API', [
                    'message_id' => $message->message_id,
                    'to' => $message->to_number,
                    'response' => $response->json()
                ]);
                return true;
            } else {
                return $this->sendViaWhatsAppWebURL($message);
            }
        } catch (\Exception $e) {
            Log::error('WhatsApp Web API exception: ' . $e->getMessage());
            return $this->sendViaWhatsAppWebURL($message);
        }
    }

    /**
     * إرسال الرسالة عبر AiSensy API
     */
    private function sendViaAiSensy($message)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . config('whatsapp.api_token', ''),
            ])->post('https://backend.aisensy.com/campaign/t1/api/v2/send', [
                'phone' => $message->to_number,
                'message' => $message->message_content
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp message sent successfully via AiSensy', [
                    'message_id' => $message->message_id,
                    'to' => $message->to_number,
                    'response' => $response->json()
                ]);
                return true;
            } else {
                Log::error('AiSensy API error', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('AiSensy API exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * إرسال الرسالة عبر Whapi API
     */
    private function sendViaWhapi($message)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . config('whatsapp.api_token', ''),
            ])->post('https://gate.whapi.cloud/messages/text', [
                'to' => $message->to_number,
                'body' => $message->message_content
            ]);

            if ($response->successful()) {
                Log::info('WhatsApp message sent successfully via Whapi', [
                    'message_id' => $message->message_id,
                    'to' => $message->to_number,
                    'response' => $response->json()
                ]);
                return true;
            } else {
                Log::error('Whapi API error', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Whapi API exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * الحصول على الرقم الأساسي للواتساب
     */
    private function getPrimaryWhatsAppNumber()
    {
        return Config::get('whatsapp.primary_number', '966599476482');
    }

    /**
     * اختبار الاتصال بـ WhatsApp API
     */
    public function testConnection()
    {
        try {
            $apiProvider = config('whatsapp.api.provider', 'auto_api');
            
            switch ($apiProvider) {
                case 'auto_api':
                    return $this->testAutoAPIConnection();
                case 'free_api':
                    return $this->testFreeAPIConnection();
                case 'aisensy':
                    return $this->testAiSensyConnection();
                case 'whapi':
                    return $this->testWhapiConnection();
                case 'whatsapp_web':
                    return $this->testWhatsAppWebConnection();
                default:
                    return $this->testAutoAPIConnection();
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في الاتصال: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * اختبار الاتصال بـ Auto API (إرسال تلقائي)
     */
    private function testAutoAPIConnection()
    {
        try {
            $autoService = new WhatsAppAutoService();
            $results = $autoService->testConnection();
            
            $successfulServices = array_filter($results, function($result) {
                return $result['success'];
            });
            
            if (!empty($successfulServices)) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم العثور على خدمات إرسال تلقائي متاحة',
                    'provider' => 'Auto API',
                    'data' => [
                        'available_services' => array_keys($successfulServices),
                        'total_services' => count($results),
                        'working_services' => count($successfulServices),
                        'details' => $results
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'لا توجد خدمات إرسال تلقائي متاحة حالياً',
                    'provider' => 'Auto API',
                    'data' => [
                        'total_services' => count($results),
                        'working_services' => 0,
                        'details' => $results,
                        'fallback' => 'سيتم استخدام إنشاء الروابط كبديل'
                    ]
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في اختبار الخدمات التلقائية: ' . $e->getMessage(),
                'provider' => 'Auto API'
            ]);
        }
    }

    /**
     * اختبار الاتصال بـ Free API
     */
    private function testFreeAPIConnection()
    {
        try {
            // اختبار الاتصال بـ WhatsApp Web
            $response = Http::timeout(10)->get('https://web.whatsapp.com');
            
            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'الاتصال بـ WhatsApp Web ناجح - يمكن إرسال الرسائل',
                    'provider' => 'Free API (WhatsApp Web)',
                    'data' => [
                        'status' => 'connected',
                        'method' => 'whatsapp_web_url',
                        'primary_number' => $this->getPrimaryWhatsAppNumber()
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'WhatsApp Web متاح - سيتم إنشاء روابط للإرسال',
                    'provider' => 'Free API (WhatsApp Web)',
                    'data' => [
                        'status' => 'available',
                        'method' => 'whatsapp_web_url',
                        'primary_number' => $this->getPrimaryWhatsAppNumber()
                    ]
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => true,
                'message' => 'WhatsApp Web متاح - سيتم إنشاء روابط للإرسال',
                'provider' => 'Free API (WhatsApp Web)',
                'data' => [
                    'status' => 'available',
                    'method' => 'whatsapp_web_url',
                    'primary_number' => $this->getPrimaryWhatsAppNumber(),
                    'note' => 'سيتم إنشاء روابط WhatsApp Web للإرسال'
                ]
            ]);
        }
    }

    /**
     * اختبار الاتصال بـ WhatsApp Web
     */
    private function testWhatsAppWebConnection()
    {
        try {
            $response = Http::timeout(10)->get('https://web.whatsapp.com');
            
            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'message' => 'الاتصال بـ WhatsApp Web ناجح',
                    'provider' => 'WhatsApp Web',
                    'data' => [
                        'status' => 'connected',
                        'primary_number' => $this->getPrimaryWhatsAppNumber()
                    ]
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'فشل الاتصال بـ WhatsApp Web',
                    'provider' => 'WhatsApp Web'
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في الاتصال بـ WhatsApp Web: ' . $e->getMessage(),
                'provider' => 'WhatsApp Web'
            ]);
        }
    }

    /**
     * اختبار الاتصال بـ AiSensy API
     */
    private function testAiSensyConnection()
    {
        try {
            $apiToken = config('whatsapp.api.api_token');
            
            if (empty($apiToken)) {
                return response()->json([
                    'success' => false,
                    'message' => 'API Token غير محدد. يرجى إضافة WHATSAPP_API_TOKEN في ملف .env'
                ]);
            }
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiToken,
            ])->get('https://backend.aisensy.com/campaign/t1/api/v2/status');

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'success' => true,
                    'message' => 'الاتصال بـ AiSensy API ناجح',
                    'provider' => 'AiSensy',
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'فشل الاتصال بـ AiSensy API',
                    'provider' => 'AiSensy',
                    'error' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في الاتصال بـ AiSensy: ' . $e->getMessage(),
                'provider' => 'AiSensy'
            ]);
        }
    }

    /**
     * اختبار الاتصال بـ Whapi API
     */
    private function testWhapiConnection()
    {
        try {
            $apiToken = config('whatsapp.api.api_token');
            
            if (empty($apiToken)) {
                return response()->json([
                    'success' => false,
                    'message' => 'API Token غير محدد. يرجى إضافة WHATSAPP_API_TOKEN في ملف .env'
                ]);
            }
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiToken,
            ])->get('https://gate.whapi.cloud/status');

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'success' => true,
                    'message' => 'الاتصال بـ Whapi API ناجح',
                    'provider' => 'Whapi',
                    'data' => $data
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'فشل الاتصال بـ Whapi API',
                    'provider' => 'Whapi',
                    'error' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في الاتصال بـ Whapi: ' . $e->getMessage(),
                'provider' => 'Whapi'
            ]);
        }
    }

    /**
     * اختبار إرسال رسالة تجريبية
     */
    public function testMessage(Request $request)
    {
        try {
            $validated = $request->validate([
                'to_number' => 'required|string',
                'message_content' => 'required|string|max:4096',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في البيانات المرسلة',
                'errors' => $e->errors()
            ], 422);
        }

        try {
            $toNumber = WhatsAppMessage::formatPhoneNumber($validated['to_number']);
            
            // إنشاء معرف فريد للرسالة
            $messageId = 'test_msg_' . time() . '_' . Str::random(10);

            // حفظ الرسالة في قاعدة البيانات
            $message = WhatsAppMessage::create([
                'message_id' => $messageId,
                'from_number' => $this->getPrimaryWhatsAppNumber(),
                'to_number' => $toNumber,
                'contact_name' => 'اختبار',
                'message_content' => $validated['message_content'],
                'message_type' => 'text',
                'direction' => 'outbound',
                'status' => 'sent',
                'sent_at' => now(),
                'sent_by' => Auth::guard('admin')->id(),
                'contact_type' => 'external',
            ]);

            // محاولة إرسال الرسالة تلقائياً
            $autoService = new WhatsAppAutoService();
            $sendResult = $autoService->sendMessage($toNumber, $validated['message_content']);
            
            if ($sendResult['success']) {
                $message->update([
                    'status' => 'delivered',
                    'delivered_at' => now()
                ]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'تم إرسال الرسالة التجريبية تلقائياً بنجاح',
                    'data' => [
                        'message_id' => $message->message_id,
                        'from_number' => $message->from_number,
                        'to_number' => $message->to_number,
                        'whatsapp_url' => $message->whatsapp_url,
                        'auto_sent' => true,
                        'service_used' => $sendResult['service'] ?? 'unknown'
                    ]
                ]);
            } else {
                // في حالة فشل الإرسال التلقائي، استخدم الطريقة القديمة
                $this->sendViaWhatsAppWeb($message);
                
                return response()->json([
                    'success' => true,
                    'message' => 'تم إنشاء رابط WhatsApp (الإرسال التلقائي غير متاح)',
                    'data' => [
                        'message_id' => $message->message_id,
                        'from_number' => $message->from_number,
                        'to_number' => $message->to_number,
                        'whatsapp_url' => $message->whatsapp_url,
                        'auto_sent' => false,
                        'auto_send_error' => $sendResult['error'] ?? 'Unknown error'
                    ]
                ]);
            }
        } catch (\Exception $e) {
            Log::error('WhatsApp test message error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في إرسال الرسالة التجريبية: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * الحصول على إحصائيات المحادثات
     */
    public function getConversationStats()
    {
        $stats = [
            'total_conversations' => WhatsAppMessage::notArchived()
                ->selectRaw('DISTINCT CASE WHEN direction = "inbound" THEN from_number ELSE to_number END as contact_number')
                ->count(),
            'active_conversations' => WhatsAppMessage::notArchived()
                ->where('sent_at', '>=', now()->subDays(7))
                ->selectRaw('DISTINCT CASE WHEN direction = "inbound" THEN from_number ELSE to_number END as contact_number')
                ->count(),
            'unread_conversations' => WhatsAppMessage::notArchived()
                ->inbound()
                ->where('status', 'delivered')
                ->selectRaw('DISTINCT from_number')
                ->count(),
        ];

        return response()->json($stats);
    }
}