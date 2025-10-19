<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EmailService;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationMail;

class EmailTestController extends Controller
{
    protected $emailService;

    public function __construct(EmailService $emailService)
    {
        $this->emailService = $emailService;
    }

    /**
     * Test email configuration
     */
    public function testEmail()
    {
        try {
            $result = $this->emailService->testEmailConfiguration();
            
            if ($result['status'] === 'success') {
                return response()->json([
                    'success' => true,
                    'message' => 'Test email sent successfully!',
                    'details' => $result
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send test email',
                    'error' => $result['message']
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error testing email configuration',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get email configuration status
     */
    public function getEmailStatus()
    {
        try {
            $status = $this->emailService->getEmailStatus();
            
            return response()->json([
                'success' => true,
                'status' => $status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error getting email status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send test notification
     */
    public function sendTestNotification(Request $request)
    {
        try {
            $email = $request->input('email', 'info@infinitywearsa.com');
            $subject = $request->input('subject', 'Test Notification - Infinity Wear');
            $message = $request->input('message', 'This is a test notification to verify the email system is working properly.');
            $type = $request->input('type', 'test');

            $result = $this->emailService->sendNotification($email, $subject, $message, $type);
            
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Test notification sent successfully!',
                    'recipient' => $email
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send test notification'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error sending test notification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send system alert
     */
    public function sendSystemAlert(Request $request)
    {
        try {
            $subject = $request->input('subject', 'System Alert');
            $message = $request->input('message', 'This is a system alert notification.');
            $level = $request->input('level', 'info');

            $result = $this->emailService->sendSystemAlert($subject, $message, $level);
            
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'System alert sent successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send system alert'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error sending system alert',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test contact form email
     */
    public function testContactForm()
    {
        try {
            $testData = [
                'name' => 'Test User',
                'email' => 'test@example.com',
                'phone' => '+966501234567',
                'subject' => 'Test Contact Form',
                'message' => 'This is a test message from the contact form to verify email functionality.'
            ];

            $result = $this->emailService->sendContactForm($testData);
            
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Test contact form email sent successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send test contact form email'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error sending test contact form email',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test importer request email
     */
    public function testImporterRequest()
    {
        try {
            $testData = [
                'name' => 'Test Importer',
                'email' => 'importer@example.com',
                'phone' => '+966501234567',
                'company' => 'Test Company Ltd.',
                'business_type' => 'Retail Store',
                'country' => 'Saudi Arabia',
                'city' => 'Riyadh',
                'experience' => '5+ years',
                'expected_volume' => '100-500 pieces/month',
                'message' => 'This is a test importer request to verify email functionality.',
                'urgent' => false
            ];

            $result = $this->emailService->sendImporterRequest($testData);
            
            if ($result) {
                return response()->json([
                    'success' => true,
                    'message' => 'Test importer request email sent successfully!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to send test importer request email'
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error sending test importer request email',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
