<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class EmailMarketingController extends Controller
{
    /**
     * Display the email marketing dashboard
     */
    public function index()
    {
        // Get user counts by type
        $userCounts = [
            'all' => User::count(),
            'importers' => User::where('user_type', 'importer')->count(),
            'sales' => User::where('user_type', 'sales')->count(),
            'marketing' => User::where('user_type', 'marketing')->count(),
        ];

        return view('admin.email-marketing.index', compact('userCounts'));
    }

    /**
     * Show the form for creating a new email campaign
     */
    public function create()
    {
        return view('admin.email-marketing.create');
    }

    /**
     * Store a newly created email campaign and send emails
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'content' => 'required|string|min:10',
            'recipients' => 'required|array|min:1',
            'recipients.*' => 'in:all,importers,sales,marketing',
            'send_immediately' => 'boolean',
            'scheduled_at' => 'nullable|date|after:now'
        ], [
            'subject.required' => 'عنوان الرسالة مطلوب',
            'subject.max' => 'عنوان الرسالة يجب أن يكون أقل من 255 حرف',
            'content.required' => 'محتوى الرسالة مطلوب',
            'content.min' => 'محتوى الرسالة يجب أن يكون على الأقل 10 أحرف',
            'recipients.required' => 'يجب اختيار فئة واحدة على الأقل من المستلمين',
            'recipients.min' => 'يجب اختيار فئة واحدة على الأقل من المستلمين',
            'recipients.*.in' => 'فئة المستلمين غير صحيحة',
            'scheduled_at.after' => 'تاريخ الإرسال يجب أن يكون في المستقبل'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Get recipients based on selected types
            $recipients = $this->getRecipients($request->recipients);
            
            if ($recipients->isEmpty()) {
                return redirect()->back()
                    ->with('error', 'لا يوجد مستلمين للفئات المحددة')
                    ->withInput();
            }

            // Send emails
            $sentCount = $this->sendEmails($recipients, $request->input('subject'), $request->input('content'));

            return redirect()->route('admin.email-marketing.index')
                ->with('success', "تم إرسال الرسالة بنجاح إلى {$sentCount} مستلم");

        } catch (\Exception $e) {
            Log::error('Email marketing error: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء إرسال الرسائل. يرجى المحاولة مرة أخرى.')
                ->withInput();
        }
    }

    /**
     * Get recipients based on selected types
     */
    private function getRecipients(array $recipientTypes)
    {
        $query = User::where('is_active', true)
                    ->whereNotNull('email')
                    ->where('email', '!=', '');

        if (!in_array('all', $recipientTypes)) {
            $query->whereIn('user_type', $recipientTypes);
        }

        return $query->get();
    }

    /**
     * Send emails to recipients
     */
    private function sendEmails($recipients, $subject, $content)
    {
        $sentCount = 0;

        foreach ($recipients as $recipient) {
            try {
                Mail::send('emails.marketing-campaign', [
                    'recipient' => $recipient,
                    'content' => $content,
                    'subject' => $subject
                ], function ($message) use ($recipient, $subject) {
                    $message->to($recipient->email, $recipient->name)
                           ->subject($subject);
                });

                $sentCount++;
                
                // Add small delay to prevent overwhelming the mail server
                usleep(100000); // 0.1 second delay

            } catch (\Exception $e) {
                Log::error("Failed to send email to {$recipient->email}: " . $e->getMessage());
                continue;
            }
        }

        return $sentCount;
    }

    /**
     * Get user statistics for dashboard
     */
    public function getStats()
    {
        $stats = [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'users_by_type' => User::selectRaw('user_type, COUNT(*) as count')
                ->groupBy('user_type')
                ->pluck('count', 'user_type')
                ->toArray(),
            'users_with_email' => User::whereNotNull('email')
                ->where('email', '!=', '')
                ->count()
        ];

        return response()->json($stats);
    }
}
