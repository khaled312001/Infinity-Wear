<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use App\Mail\ContactFormMail;
use App\Mail\NotificationMail;
use App\Mail\TaskNotificationMail;
use App\Mail\ImporterRequestMail;
use App\Http\Controllers\PusherNotificationController;

class EmailService
{
    protected $adminEmail;
    protected $fromEmail;
    protected $fromName;
    protected $pusherController;

    public function __construct()
    {
        $this->adminEmail = config('mail.admin_email', 'info@infinitywearsa.com');
        $this->fromEmail = config('mail.from.address', 'info@infinitywearsa.com');
        $this->fromName = config('mail.from.name', 'Infinity Wear');
        $this->pusherController = new PusherNotificationController();
    }

    /**
     * Send contact form email
     */
    public function sendContactForm($data)
    {
        try {
            // Send email
            Mail::to($this->adminEmail)->send(new ContactFormMail($data));
            Log::info('Contact form email sent successfully', ['email' => $data['email']]);
            
            // Send push notification
            $this->pusherController->sendContactFormNotification($data);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send contact form email', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Send notification email
     */
    public function sendNotification($to, $subject, $message, $type = 'general')
    {
        try {
            Mail::to($to)->send(new NotificationMail($subject, $message, $type));
            Log::info('Notification email sent successfully', ['to' => $to, 'subject' => $subject]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send notification email', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Send task notification email
     */
    public function sendTaskNotification($to, $task, $action)
    {
        try {
            Mail::to($to)->send(new TaskNotificationMail($task, $action));
            Log::info('Task notification email sent successfully', ['to' => $to, 'task_id' => $task->id]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send task notification email', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Send importer request email
     */
    public function sendImporterRequest($data)
    {
        try {
            // Send email
            Mail::to($this->adminEmail)->send(new ImporterRequestMail($data));
            Log::info('Importer request email sent successfully', ['email' => $data['email']]);
            
            // Send push notification
            $this->pusherController->sendImporterRequestNotification($data);
            
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send importer request email', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Send bulk notification to multiple recipients
     */
    public function sendBulkNotification($recipients, $subject, $message, $type = 'general')
    {
        $successCount = 0;
        $failCount = 0;

        foreach ($recipients as $recipient) {
            if ($this->sendNotification($recipient, $subject, $message, $type)) {
                $successCount++;
            } else {
                $failCount++;
            }
        }

        Log::info('Bulk notification completed', [
            'success_count' => $successCount,
            'fail_count' => $failCount,
            'total' => count($recipients)
        ]);

        return ['success' => $successCount, 'failed' => $failCount];
    }

    /**
     * Send system alert to admin
     */
    public function sendSystemAlert($subject, $message, $level = 'info')
    {
        try {
            $alertData = [
                'subject' => "[SYSTEM ALERT] {$subject}",
                'message' => $message,
                'level' => $level,
                'timestamp' => now()->format('Y-m-d H:i:s')
            ];

            // Send email
            Mail::to($this->adminEmail)->send(new NotificationMail(
                $alertData['subject'],
                $alertData['message'],
                'system_alert'
            ));

            // Send push notification
            $this->pusherController->sendSystemAlertNotification($subject, $message, $level);

            Log::info('System alert sent successfully', ['subject' => $subject, 'level' => $level]);
            return true;
        } catch (\Exception $e) {
            Log::error('Failed to send system alert', ['error' => $e->getMessage()]);
            return false;
        }
    }

    /**
     * Test email configuration
     */
    public function testEmailConfiguration()
    {
        try {
            $testData = [
                'subject' => 'Test Email - Infinity Wear',
                'message' => 'This is a test email to verify the email configuration is working properly.',
                'timestamp' => now()->format('Y-m-d H:i:s')
            ];

            Mail::to($this->adminEmail)->send(new NotificationMail(
                $testData['subject'],
                $testData['message'],
                'test'
            ));

            Log::info('Test email sent successfully');
            return ['status' => 'success', 'message' => 'Test email sent successfully'];
        } catch (\Exception $e) {
            Log::error('Test email failed', ['error' => $e->getMessage()]);
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    /**
     * Get email configuration status
     */
    public function getEmailStatus()
    {
        return [
            'admin_email' => $this->adminEmail,
            'from_email' => $this->fromEmail,
            'from_name' => $this->fromName,
            'mailer' => config('mail.default'),
            'host' => config('mail.mailers.smtp.host'),
            'port' => config('mail.mailers.smtp.port'),
            'encryption' => config('mail.mailers.smtp.encryption'),
        ];
    }
}
