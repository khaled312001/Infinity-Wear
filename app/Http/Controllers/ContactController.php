<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
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
            // Create contact record
            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'company' => $request->company,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => 'new',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // إنشاء إشعار للرسالة الجديدة
            $this->notificationService->createContactNotification($contact);

            // Send email notification to admin
            $this->sendAdminNotification($contact);

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

    /**
     * Send email notification to admin
     */
    private function sendAdminNotification(Contact $contact)
    {
        try {
            $adminEmail = config('mail.admin_email', 'admin@infinitywear.sa');
            
            Mail::send('emails.contact-notification', [
                'contact' => $contact
            ], function ($message) use ($adminEmail, $contact) {
                $message->to($adminEmail)
                    ->cc($contact->email) // Send copy to sender
                    ->subject('رسالة جديدة من موقع Infinity Wear - ' . $contact->subject);
            });

        } catch (\Exception $e) {
            // Log the error but don't fail the contact form submission
            Log::error('Failed to send contact notification email: ' . $e->getMessage());
        }
    }
}
