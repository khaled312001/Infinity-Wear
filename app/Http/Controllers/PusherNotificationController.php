<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PusherNotificationController extends Controller
{
    protected $instanceId;
    protected $secretKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->instanceId = config('pusher.beams.instance_id', '6e2dea3b-9769-4e5b-a6d3-e92b3e8c8186');
        $this->secretKey = config('pusher.beams.secret_key', '766DDD7303E1AB7AD5BC490099FCE12A0E16B78D09E4E2AA39CBD3C20F331E12');
        $this->baseUrl = "https://{$this->instanceId}.pushnotifications.pusher.com/publish_api/v1/instances/{$this->instanceId}/publishes";
    }

    /**
     * Send push notification to specific interests
     */
    public function sendNotification($interests, $title, $body, $data = [])
    {
        try {
            $payload = [
                'interests' => is_array($interests) ? $interests : [$interests],
                'web' => [
                    'notification' => [
                        'title' => $title,
                        'body' => $body,
                        'icon' => asset('images/logo.png'),
                        'badge' => asset('images/logo.png'),
                        'data' => $data
                    ]
                ]
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->secretKey
            ])->post($this->baseUrl, $payload);

            if ($response->successful()) {
                Log::info('Pusher notification sent successfully', [
                    'interests' => $interests,
                    'title' => $title,
                    'response' => $response->json()
                ]);
                return true;
            } else {
                Log::error('Failed to send Pusher notification', [
                    'interests' => $interests,
                    'title' => $title,
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return false;
            }

        } catch (\Exception $e) {
            Log::error('Pusher notification error', [
                'interests' => $interests,
                'title' => $title,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Send contact form notification
     */
    public function sendContactFormNotification($contactData)
    {
        return $this->sendNotification(
            ['contact-form', 'admin-notifications'],
            'رسالة تواصل جديدة - Infinity Wear',
            "رسالة جديدة من: {$contactData['name']} - {$contactData['subject']}",
            [
                'type' => 'contact_form',
                'contact_id' => $contactData['id'] ?? null,
                'url' => '/admin/contacts'
            ]
        );
    }

    /**
     * Send importer request notification
     */
    public function sendImporterRequestNotification($importerData)
    {
        return $this->sendNotification(
            ['importer-requests', 'admin-notifications'],
            'طلب مستورد جديد - Infinity Wear',
            "طلب جديد من: {$importerData['name']} - {$importerData['company']}",
            [
                'type' => 'importer_request',
                'importer_id' => $importerData['id'] ?? null,
                'url' => '/admin/importers'
            ]
        );
    }

    /**
     * Send task update notification
     */
    public function sendTaskUpdateNotification($taskData, $action = 'updated')
    {
        $actionText = match($action) {
            'created' => 'تم إنشاء مهمة جديدة',
            'updated' => 'تم تحديث المهمة',
            'completed' => 'تم إنجاز المهمة',
            'assigned' => 'تم تعيين مهمة جديدة لك',
            default => 'تحديث في المهمة'
        };

        return $this->sendNotification(
            ['task-updates', 'admin-notifications'],
            "{$actionText} - Infinity Wear",
            "المهمة: {$taskData['title']} - الحالة: {$taskData['status']}",
            [
                'type' => 'task_update',
                'task_id' => $taskData['id'] ?? null,
                'action' => $action,
                'url' => '/admin/tasks'
            ]
        );
    }

    /**
     * Send system alert notification
     */
    public function sendSystemAlertNotification($title, $message, $level = 'info')
    {
        return $this->sendNotification(
            ['admin-notifications', 'system-alerts'],
            "تنبيه نظام - {$title}",
            $message,
            [
                'type' => 'system_alert',
                'level' => $level,
                'url' => '/admin'
            ]
        );
    }

    /**
     * Send general notification
     */
    public function sendGeneralNotification($title, $message, $interests = ['notifications'])
    {
        return $this->sendNotification(
            $interests,
            $title,
            $message,
            [
                'type' => 'general',
                'url' => '/'
            ]
        );
    }

    /**
     * Test notification endpoint
     */
    public function testNotification(Request $request)
    {
        $title = $request->input('title', 'اختبار إشعار - Infinity Wear');
        $message = $request->input('message', 'هذا اختبار لنظام الإشعارات');
        $interests = $request->input('interests', ['notifications']);

        $result = $this->sendNotification($interests, $title, $message, [
            'type' => 'test',
            'url' => '/email-test'
        ]);

        return response()->json([
            'success' => $result,
            'message' => $result ? 'تم إرسال الإشعار بنجاح' : 'فشل في إرسال الإشعار',
            'data' => [
                'title' => $title,
                'message' => $message,
                'interests' => $interests
            ]
        ]);
    }

    /**
     * Get notification statistics
     */
    public function getStats()
    {
        return response()->json([
            'instance_id' => $this->instanceId,
            'base_url' => $this->baseUrl,
            'status' => 'active',
            'supported_interests' => [
                'notifications',
                'admin-notifications',
                'contact-form',
                'importer-requests',
                'task-updates',
                'system-alerts'
            ]
        ]);
    }
}
