<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AIDesignService
{
    private $apiKey;
    private $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
        $this->baseUrl = config('services.openai.base_url', 'https://api.openai.com/v1');
    }

    /**
     * Generate design description using AI
     */
    public function generateDesignDescription(string $prompt, string $style = 'realistic'): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'أنت مصمم أزياء محترف متخصص في تصميم الملابس الرياضية والعملية. قم بتحليل الطلب وتقديم وصف مفصل للتصميم المطلوب مع التركيز على الجوانب التقنية والجمالية.'
                    ],
                    [
                        'role' => 'user',
                        'content' => "قم بتحليل هذا الطلب وتقديم وصف مفصل للتصميم: {$prompt}. النمط المطلوب: {$style}. قدم وصفاً شاملاً يتضمن الألوان، المواد، القص، التفاصيل التقنية، والجوانب الجمالية."
                    ]
                ],
                'max_tokens' => 1000,
                'temperature' => 0.7,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'description' => $data['choices'][0]['message']['content'] ?? 'لم يتم الحصول على وصف مناسب',
                    'usage' => $data['usage'] ?? null
                ];
            }

            return [
                'success' => false,
                'error' => 'فشل في الاتصال بخدمة الذكاء الاصطناعي',
                'details' => $response->body()
            ];

        } catch (\Exception $e) {
            Log::error('AI Design Service Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'حدث خطأ في خدمة الذكاء الاصطناعي',
                'details' => $e->getMessage()
            ];
        }
    }

    /**
     * Generate design variations
     */
    public function generateDesignVariations(string $basePrompt, int $variations = 3): array
    {
        $variationsList = [];
        
        for ($i = 1; $i <= $variations; $i++) {
            $variationPrompt = $basePrompt . " - تنويع رقم {$i} مع تغيير طفيف في الألوان أو التفاصيل";
            $result = $this->generateDesignDescription($variationPrompt);
            
            if ($result['success']) {
                $variationsList[] = [
                    'variation' => $i,
                    'description' => $result['description']
                ];
            }
        }

        return $variationsList;
    }

    /**
     * Analyze design requirements and suggest improvements
     */
    public function analyzeDesignRequirements(string $requirements): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'أنت خبير في تحليل متطلبات تصميم الملابس. قم بتحليل المتطلبات وتقديم اقتراحات لتحسين التصميم مع التركيز على الجودة والوظائف والجماليات.'
                    ],
                    [
                        'role' => 'user',
                        'content' => "قم بتحليل هذه المتطلبات وتقديم اقتراحات للتحسين: {$requirements}"
                    ]
                ],
                'max_tokens' => 800,
                'temperature' => 0.6,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'analysis' => $data['choices'][0]['message']['content'] ?? 'لم يتم الحصول على تحليل مناسب',
                    'suggestions' => $this->extractSuggestions($data['choices'][0]['message']['content'] ?? '')
                ];
            }

            return [
                'success' => false,
                'error' => 'فشل في تحليل المتطلبات'
            ];

        } catch (\Exception $e) {
            Log::error('AI Analysis Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'حدث خطأ في تحليل المتطلبات'
            ];
        }
    }

    /**
     * Extract suggestions from AI response
     */
    private function extractSuggestions(string $content): array
    {
        $suggestions = [];
        $lines = explode("\n", $content);
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (preg_match('/^[\d\-\*\+]\s*(.+)/', $line, $matches)) {
                $suggestions[] = trim($matches[1]);
            }
        }

        return array_slice($suggestions, 0, 5); // Return max 5 suggestions
    }

    /**
     * Generate design mockup description
     */
    public function generateMockupDescription(string $designDescription): array
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'أنت مصمم جرافيك متخصص في إنشاء أوصاف مفصلة للتصاميم البصرية. قم بتحويل وصف التصميم إلى وصف بصري مفصل يمكن استخدامه لإنشاء mockup.'
                    ],
                    [
                        'role' => 'user',
                        'content' => "قم بتحويل هذا الوصف إلى وصف بصري مفصل: {$designDescription}"
                    ]
                ],
                'max_tokens' => 600,
                'temperature' => 0.5,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'mockup_description' => $data['choices'][0]['message']['content'] ?? 'لم يتم الحصول على وصف بصري مناسب'
                ];
            }

            return [
                'success' => false,
                'error' => 'فشل في إنشاء الوصف البصري'
            ];

        } catch (\Exception $e) {
            Log::error('AI Mockup Error: ' . $e->getMessage());
            return [
                'success' => false,
                'error' => 'حدث خطأ في إنشاء الوصف البصري'
            ];
        }
    }

    /**
     * Generate T-Shirt design using AI
     */
    public function generateTShirtDesign(string $prompt): array
    {
        try {
            Log::info('Starting AI T-Shirt Design Generation', ['prompt' => $prompt]);
            
            // First, enhance the prompt for t-shirt design
            $enhancedPrompt = $this->enhanceTShirtPrompt($prompt);
            Log::info('Enhanced prompt created', ['enhanced_prompt' => $enhancedPrompt]);
            
            // Try multiple AI services
            $imageUrl = $this->generateWithMultipleServices($enhancedPrompt);
            Log::info('Image generation completed', ['image_url' => $imageUrl]);
            
            if ($imageUrl && $imageUrl !== $this->getFallbackImage()) {
                return [
                    'success' => true,
                    'image_url' => $imageUrl,
                    'prompt' => $enhancedPrompt
                ];
            } else {
                Log::warning('All AI services failed, using fallback image');
                return [
                    'success' => true,
                    'image_url' => $this->getFallbackImage(),
                    'prompt' => $enhancedPrompt,
                    'fallback' => true
                ];
            }

        } catch (\Exception $e) {
            Log::error('AI T-Shirt Design Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return [
                'success' => false,
                'error' => 'حدث خطأ في إنشاء تصميم التيشرت: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Try multiple AI services for image generation
     */
    private function generateWithMultipleServices(string $prompt): string
    {
        Log::info('Starting multiple AI services generation', ['prompt' => $prompt]);
        
        // Try ModelsLab FLUX first (highest quality)
        $modelslabKey = 'IE9WLrlMvdVEP8m3IeCDKvQ5InrOUQH9z4fHigEXbI2kZ3PE6Z71bGMnA7cw';
        if (!empty($modelslabKey) && $modelslabKey !== 'your-modelslab-api-key-here') {
            Log::info('Trying ModelsLab FLUX API');
            $fluxResult = $this->generateWithModelsLab($prompt);
            if ($fluxResult !== null) {
                Log::info('ModelsLab FLUX succeeded', ['result' => $fluxResult]);
                return $fluxResult;
            }
            Log::warning('ModelsLab FLUX failed');
        } else {
            Log::info('ModelsLab FLUX API key not configured or invalid');
        }
        
        // Try Stable Diffusion Web (your API key)
        $sdToken = config('services.stablediffusion.api_key');
        if (!empty($sdToken)) {
            Log::info('Trying Stable Diffusion Web API');
            $sdResult = $this->generateWithStableDiffusion($prompt);
            if ($sdResult !== null) {
                Log::info('Stable Diffusion Web succeeded', ['result' => $sdResult]);
                return $sdResult;
            }
            Log::warning('Stable Diffusion Web failed');
        } else {
            Log::info('Stable Diffusion Web API key not configured');
        }
        
        // Try DALL-E (if API key is available)
        if (!empty($this->apiKey)) {
            Log::info('Trying DALL-E API');
            $dalleResult = $this->generateWithDALLE($prompt);
            if ($dalleResult !== null) {
                Log::info('DALL-E succeeded', ['result' => $dalleResult]);
                return $dalleResult;
            }
            Log::warning('DALL-E failed');
        } else {
            Log::info('DALL-E API key not configured');
        }
        
        // Try Replicate API (free tier available)
        Log::info('Trying Replicate API');
        $replicateResult = $this->generateWithReplicate($prompt);
        if ($replicateResult !== null) {
            Log::info('Replicate succeeded', ['result' => $replicateResult]);
            return $replicateResult;
        }
        Log::warning('Replicate failed');
        
        // Final fallback
        Log::warning('All AI services failed, using fallback image');
        return $this->getFallbackImage();
    }

    /**
     * Generate with ModelsLab FLUX API (highest quality)
     */
    private function generateWithModelsLab(string $prompt): ?string
    {
        try {
            $apiKey = 'IE9WLrlMvdVEP8m3IeCDKvQ5InrOUQH9z4fHigEXbI2kZ3PE6Z71bGMnA7cw';
            if (empty($apiKey)) {
                Log::warning('ModelsLab API key not configured');
                return null;
            }
            
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => false, // Disable SSL verification for testing
            ])->timeout(120)->post('https://modelslab.com/api/v6/images/text2img', [
                'key' => $apiKey,
                'model_id' => 'flux',
                'prompt' => $prompt,
                'negative_prompt' => 'blurry, low quality, distorted, watermark, text, signature, nsfw',
                'width' => 1024,
                'height' => 1024,
                'samples' => 1,
                'num_inference_steps' => 20,
                'safety_checker' => false,
                'seed' => null,
                'guidance_scale' => 7.5,
                'clip_skip' => 2,
                'multi_lingual' => true,
                'upscale' => false,
                'highres_fix' => false,
                'base64' => false,
                'temp' => false
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (isset($data['status']) && $data['status'] === 'success' && !empty($data['output'])) {
                    $imageUrl = $data['output'][0];
                    return $this->saveGeneratedImage($imageUrl, $prompt);
                }
            }

            Log::error('ModelsLab FLUX API Error: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('ModelsLab FLUX Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Generate with DALL-E API
     */
    private function generateWithDALLE(string $prompt): ?string
    {
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->timeout(60)->post($this->baseUrl . '/images/generations', [
                'model' => 'dall-e-3',
                'prompt' => $prompt,
                'n' => 1,
                'size' => '1024x1024',
                'quality' => 'standard',
                'style' => 'vivid'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $imageUrl = $data['data'][0]['url'] ?? null;
                
                if ($imageUrl) {
                    return $this->saveGeneratedImage($imageUrl, $prompt);
                }
            }

            Log::error('DALL-E API Error: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('DALL-E Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Generate with Stable Diffusion Web API
     */
    private function generateWithStableDiffusion(string $prompt): ?string
    {
        try {
            // Using Stable Diffusion Web API
            $sdToken = config('services.stablediffusion.api_key');
            if (empty($sdToken)) {
                Log::warning('Stable Diffusion API key not configured');
                return null;
            }
            
            Log::info('Calling Stable Diffusion Web API', ['prompt' => $prompt]);
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $sdToken,
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => false, // Disable SSL verification for testing
            ])->timeout(120)->post('https://api.stablediffusionweb.com/v1/generate', [
                'prompt' => $prompt,
                'width' => 1024,
                'height' => 1024,
                'steps' => 20,
                'cfg_scale' => 7.5,
                'sampler' => 'DPM++ 2M Karras',
                'model' => 'realistic-vision-v5',
                'negative_prompt' => 'blurry, low quality, distorted, watermark, text, signature',
                'seed' => -1
            ]);

            Log::info('Stable Diffusion Web API Response', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $imageUrl = $data['image_url'] ?? null;
                
                if ($imageUrl) {
                    Log::info('Stable Diffusion Web succeeded', ['image_url' => $imageUrl]);
                    return $this->saveGeneratedImage($imageUrl, $prompt);
                } else {
                    Log::warning('No image_url in Stable Diffusion Web response', ['data' => $data]);
                }
            } else {
                Log::error('Stable Diffusion Web API Error: ' . $response->body());
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Stable Diffusion Web Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return null;
        }
    }

    /**
     * Generate with Replicate API (free tier)
     */
    private function generateWithReplicate(string $prompt): ?string
    {
        try {
            // Using Replicate's free Stable Diffusion model
            $replicateToken = config('services.replicate.api_token');
            if (empty($replicateToken)) {
                Log::warning('Replicate API token not configured');
                return null;
            }
            
            $response = Http::withHeaders([
                'Authorization' => 'Token ' . $replicateToken,
                'Content-Type' => 'application/json',
            ])->timeout(120)->post('https://api.replicate.com/v1/predictions', [
                'version' => 'ac732df83cea7fff18b8472768c88ad041fa750ff7682a21affe81863cbe77e4', // SDXL model
                'input' => [
                    'prompt' => $prompt,
                    'width' => 1024,
                    'height' => 1024,
                    'num_inference_steps' => 20,
                    'guidance_scale' => 7.5,
                    'scheduler' => 'K_EULER'
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $predictionId = $data['id'] ?? null;
                
                if ($predictionId) {
                    // Poll for completion
                    return $this->pollReplicateResult($predictionId, $prompt);
                }
            }

            Log::error('Replicate API Error: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('Replicate Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Poll Replicate API for result
     */
    private function pollReplicateResult(string $predictionId, string $prompt): ?string
    {
        $maxAttempts = 30; // 5 minutes max
        $attempt = 0;
        
        while ($attempt < $maxAttempts) {
            try {
                $replicateToken = config('services.replicate.api_token');
                $response = Http::withHeaders([
                    'Authorization' => 'Token ' . $replicateToken,
                ])->get("https://api.replicate.com/v1/predictions/{$predictionId}");
                
                if ($response->successful()) {
                    $data = $response->json();
                    $status = $data['status'] ?? '';
                    
                    if ($status === 'succeeded') {
                        $output = $data['output'] ?? [];
                        $imageUrl = $output[0] ?? null;
                        
                        if ($imageUrl) {
                            return $this->saveGeneratedImage($imageUrl, $prompt);
                        }
                    } elseif ($status === 'failed') {
                        Log::error('Replicate generation failed: ' . ($data['error'] ?? 'Unknown error'));
                        return null;
                    }
                }
                
                sleep(10); // Wait 10 seconds before next poll
                $attempt++;
                
            } catch (\Exception $e) {
                Log::error('Replicate polling error: ' . $e->getMessage());
                return null;
            }
        }
        
        Log::error('Replicate polling timeout');
        return null;
    }

    /**
     * Enhance prompt for t-shirt design
     */
    private function enhanceTShirtPrompt(string $prompt): string
    {
        return "Professional t-shirt design: {$prompt}. High quality, suitable for screen printing, clear colors, detailed design, 1024x1024 resolution.";
    }

    /**
     * Generate real t-shirt design using DALL-E API
     */
    private function generatePlaceholderDesign(string $prompt): string
    {
        try {
            // Enhanced prompt for t-shirt design with specific constraints
            $enhancedPrompt = $this->createTShirtPrompt($prompt);
            
            // Call DALL-E API
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])->post($this->baseUrl . '/images/generations', [
                'model' => 'dall-e-3',
                'prompt' => $enhancedPrompt,
                'n' => 1,
                'size' => '1024x1024',
                'quality' => 'standard',
                'style' => 'vivid'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $imageUrl = $data['data'][0]['url'] ?? null;
                
                if ($imageUrl) {
                    // Download and save the image
                    return $this->saveGeneratedImage($imageUrl, $prompt);
                }
            }

            Log::error('DALL-E API Error: ' . $response->body());
            return $this->getFallbackImage();

        } catch (\Exception $e) {
            Log::error('AI Image Generation Error: ' . $e->getMessage());
            return $this->getFallbackImage();
        }
    }

    /**
     * Create optimized prompt for t-shirt design
     */
    private function createTShirtPrompt(string $originalPrompt): string
    {
        $basePrompt = "Professional t-shirt design, ";
        $constraints = "suitable for screen printing, high contrast colors, clear and bold design, ";
        $dimensions = "designed for front chest area of t-shirt, ";
        $style = "modern and trendy style, ";
        $technical = "vector-style graphics, clean lines, print-ready design, ";
        $language = "Arabic and English text support, ";
        
        return $basePrompt . $constraints . $dimensions . $style . $technical . $language . $originalPrompt . 
               ". The design should be centered and sized appropriately for a t-shirt front, with clear visibility and professional appearance.";
    }

    /**
     * Save generated image to storage
     */
    private function saveGeneratedImage(string $imageUrl, string $prompt): string
    {
        try {
            // Download image
            $imageData = Http::get($imageUrl)->body();
            
            // Generate unique filename
            $filename = 'tshirt_design_' . time() . '_' . substr(md5($prompt), 0, 8) . '.png';
            $path = 'designs/' . $filename;
            
            // Save to storage
            \Storage::disk('public')->put($path, $imageData);
            
            // Return public URL
            return \Storage::disk('public')->url($path);
            
        } catch (\Exception $e) {
            Log::error('Image Save Error: ' . $e->getMessage());
            return $this->getFallbackImage();
        }
    }

    /**
     * Get fallback image when AI generation fails
     */
    private function getFallbackImage(): string
    {
        return asset('images/placeholder-design.svg');
    }
}
