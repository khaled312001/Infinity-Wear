<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Services\NotificationService;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ContactController extends Controller
{
    protected $notificationService;
    protected $emailService;

    public function __construct(NotificationService $notificationService, EmailService $emailService)
    {
        $this->notificationService = $notificationService;
        $this->emailService = $emailService;
    }
    /**
     * Show the contact form
     */
    public function index()
    {
        return view('contact');
    }

    /**
     * Handle contact form submission
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ], [
            'name.required' => 'الاسم مطلوب',
            'email.required' => 'البريد الإلكتروني مطلوب',
            'email.email' => 'البريد الإلكتروني غير صحيح',
            'subject.required' => 'الموضوع مطلوب',
            'message.required' => 'الرسالة مطلوبة',
            'message.max' => 'الرسالة طويلة جداً (الحد الأقصى 2000 حرف)',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'يرجى التحقق من البيانات المدخلة',
                    'errors' => $validator->errors()
                ], 422);
            }
            
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Build payload only with columns that actually exist to avoid SQL errors
            $payload = [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => 'new',
            ];

            if (Schema::hasColumn('contacts', 'phone')) {
                $payload['phone'] = $request->phone;
            }
            if (Schema::hasColumn('contacts', 'company')) {
                $payload['company'] = $request->company;
            }
            if (Schema::hasColumn('contacts', 'ip_address')) {
                $payload['ip_address'] = $request->ip();
            }
            if (Schema::hasColumn('contacts', 'user_agent')) {
                $payload['user_agent'] = $request->userAgent();
            }

            $contact = Contact::create($payload);

            // إنشاء إشعار للرسالة الجديدة
            $this->notificationService->createContactNotification($contact);

            // Send email notification to admin using EmailService
            $this->emailService->sendContactForm([
                'name' => $contact->name,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'company' => $contact->company,
                'subject' => $contact->subject,
                'message' => $contact->message
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.',
                    'data' => [
                        'id' => $contact->id,
                        'timestamp' => now()->toISOString()
                    ]
                ], 201);
            }

            return redirect()->back()->with('success', 'تم إرسال رسالتك بنجاح! سنتواصل معك قريباً.');

        } catch (\Exception $e) {
            Log::error('Contact form submission error: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'حدث خطأ أثناء إرسال الرسالة. يرجى المحاولة مرة أخرى.',
                    'error' => 'Server error'
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء إرسال الرسالة. يرجى المحاولة مرة أخرى.')
                ->withInput();
        }
    }

}
