<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\WhatsAppMessage;

class WhatsAppAutoService
{
    private $apiUrl;
    private $apiKey;
    private $sessionId;

    public function __construct()
    {
        $this->apiUrl = config('whatsapp.auto_api.url', 'https://api.whatsapp.com');
        $this->apiKey = config('whatsapp.auto_api.key');
        $this->sessionId = config('whatsapp.auto_api.session_id', 'infinity_wear_auto');
    }

    /**
     * إرسال رسالة تلقائية عبر WhatsApp
     */
    public function sendMessage($toNumber, $message, $options = [])
    {
        try {
            // تنظيف رقم الهاتف
            $cleanNumber = $this->cleanPhoneNumber($toNumber);
            
            // محاولة الإرسال عبر الخدمات المختلفة
            $result = $this->tryMultipleServices($cleanNumber, $message, $options);
            
            if ($result['success']) {
                Log::info('WhatsApp message sent successfully', [
                    'to' => $cleanNumber,
                    'message' => $message,
                    'service' => $result['service']
                ]);
            }
            
            return $result;
            
        } catch (\Exception $e) {
            Log::error('WhatsApp auto send error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * محاولة الإرسال عبر خدمات متعددة
     */
    private function tryMultipleServices($phoneNumber, $message, $options)
    {
        $services = [
            'whatsapp_web_api' => [$this, 'sendViaWhatsAppWebAPI'],
            'baileys_api' => [$this, 'sendViaBaileysAPI'],
            'whatsapp_business_api' => [$this, 'sendViaBusinessAPI'],
            'alternative_api' => [$this, 'sendViaAlternativeAPI']
        ];

        foreach ($services as $serviceName => $method) {
            try {
                $result = call_user_func($method, $phoneNumber, $message, $options);
                if ($result['success']) {
                    return array_merge($result, ['service' => $serviceName]);
                }
            } catch (\Exception $e) {
                Log::warning("Service {$serviceName} failed: " . $e->getMessage());
                continue;
            }
        }

        return [
            'success' => false,
            'error' => 'All services failed'
        ];
    }

    /**
     * الإرسال عبر WhatsApp Web API
     */
    private function sendViaWhatsAppWebAPI($phoneNumber, $message, $options)
    {
        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
                ])
                ->post($this->apiUrl . '/send', [
                    'phone' => $phoneNumber,
                    'message' => $message,
                    'session' => $this->sessionId
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message_id' => $response->json('message_id'),
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'error' => 'WhatsApp Web API failed: ' . $response->body()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'WhatsApp Web API exception: ' . $e->getMessage()
            ];
        }
    }

    /**
     * الإرسال عبر Baileys API
     */
    private function sendViaBaileysAPI($phoneNumber, $message, $options)
    {
        try {
            $baileysUrl = config('whatsapp.auto_api.baileys_url', 'http://localhost:3000');
            
            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->apiKey
                ])
                ->post($baileysUrl . '/send-message', [
                    'jid' => $phoneNumber . '@s.whatsapp.net',
                    'message' => $message,
                    'session' => $this->sessionId
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message_id' => $response->json('id'),
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'error' => 'Baileys API failed: ' . $response->body()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Baileys API exception: ' . $e->getMessage()
            ];
        }
    }

    /**
     * الإرسال عبر WhatsApp Business API
     */
    private function sendViaBusinessAPI($phoneNumber, $message, $options)
    {
        try {
            $businessApiUrl = config('whatsapp.auto_api.business_url', 'https://graph.facebook.com/v18.0');
            $phoneNumberId = config('whatsapp.auto_api.phone_number_id');
            $accessToken = config('whatsapp.auto_api.access_token');

            if (!$phoneNumberId || !$accessToken) {
                return [
                    'success' => false,
                    'error' => 'Business API credentials not configured'
                ];
            }

            $response = Http::timeout(30)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Content-Type' => 'application/json'
                ])
                ->post($businessApiUrl . '/' . $phoneNumberId . '/messages', [
                    'messaging_product' => 'whatsapp',
                    'to' => $phoneNumber,
                    'type' => 'text',
                    'text' => [
                        'body' => $message
                    ]
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message_id' => $response->json('messages.0.id'),
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'error' => 'Business API failed: ' . $response->body()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Business API exception: ' . $e->getMessage()
            ];
        }
    }

    /**
     * الإرسال عبر خدمة بديلة
     */
    private function sendViaAlternativeAPI($phoneNumber, $message, $options)
    {
        try {
            // استخدام خدمة مجانية متاحة
            $alternativeUrl = config('whatsapp.auto_api.alternative_url', 'https://api.whatsapp.com/send');
            
            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
                ])
                ->post($alternativeUrl, [
                    'phone' => $phoneNumber,
                    'text' => $message,
                    'session' => $this->sessionId
                ]);

            if ($response->successful()) {
                return [
                    'success' => true,
                    'message_id' => 'alt_' . time(),
                    'data' => $response->json()
                ];
            }

            return [
                'success' => false,
                'error' => 'Alternative API failed: ' . $response->body()
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Alternative API exception: ' . $e->getMessage()
            ];
        }
    }

    /**
     * تنظيف رقم الهاتف
     */
    private function cleanPhoneNumber($phoneNumber)
    {
        // إزالة جميع الأحرف غير الرقمية
        $phone = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // إضافة رمز البلد إذا لم يكن موجود
        if (!str_starts_with($phone, '966') && !str_starts_with($phone, '+966')) {
            if (str_starts_with($phone, '0')) {
                $phone = '966' . substr($phone, 1);
            } else {
                $phone = '966' . $phone;
            }
        }
        
        return $phone;
    }

    /**
     * اختبار الاتصال بالخدمات
     */
    public function testConnection()
    {
        $services = [
            'WhatsApp Web API' => [$this, 'testWhatsAppWebAPI'],
            'Baileys API' => [$this, 'testBaileysAPI'],
            'Business API' => [$this, 'testBusinessAPI'],
            'Alternative API' => [$this, 'testAlternativeAPI']
        ];

        $results = [];

        foreach ($services as $serviceName => $method) {
            try {
                $result = call_user_func($method);
                $results[$serviceName] = $result;
            } catch (\Exception $e) {
                $results[$serviceName] = [
                    'success' => false,
                    'error' => $e->getMessage()
                ];
            }
        }

        return $results;
    }

    /**
     * اختبار WhatsApp Web API
     */
    private function testWhatsAppWebAPI()
    {
        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey
                ])
                ->get($this->apiUrl . '/status');

            return [
                'success' => $response->successful(),
                'data' => $response->json(),
                'status' => $response->status()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * اختبار Baileys API
     */
    private function testBaileysAPI()
    {
        try {
            $baileysUrl = config('whatsapp.auto_api.baileys_url', 'http://localhost:3000');
            
            $response = Http::timeout(10)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey
                ])
                ->get($baileysUrl . '/status');

            return [
                'success' => $response->successful(),
                'data' => $response->json(),
                'status' => $response->status()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * اختبار Business API
     */
    private function testBusinessAPI()
    {
        try {
            $phoneNumberId = config('whatsapp.auto_api.phone_number_id');
            $accessToken = config('whatsapp.auto_api.access_token');

            if (!$phoneNumberId || !$accessToken) {
                return [
                    'success' => false,
                    'error' => 'Credentials not configured'
                ];
            }

            $businessApiUrl = config('whatsapp.auto_api.business_url', 'https://graph.facebook.com/v18.0');
            
            $response = Http::timeout(10)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $accessToken
                ])
                ->get($businessApiUrl . '/' . $phoneNumberId);

            return [
                'success' => $response->successful(),
                'data' => $response->json(),
                'status' => $response->status()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * اختبار Alternative API
     */
    private function testAlternativeAPI()
    {
        try {
            $alternativeUrl = config('whatsapp.auto_api.alternative_url', 'https://api.whatsapp.com');
            
            $response = Http::timeout(10)
                ->get($alternativeUrl . '/status');

            return [
                'success' => $response->successful(),
                'data' => $response->json(),
                'status' => $response->status()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
