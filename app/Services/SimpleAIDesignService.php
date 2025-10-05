<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class SimpleAIDesignService
{
    /**
     * Generate T-Shirt design using simple AI
     */
    public function generateTShirtDesign(string $prompt): array
    {
        try {
            Log::info('Starting Simple AI T-Shirt Design Generation', ['prompt' => $prompt]);
            
            // Enhance the prompt for t-shirt design
            $enhancedPrompt = $this->enhanceTShirtPrompt($prompt);
            Log::info('Enhanced prompt created', ['enhanced_prompt' => $enhancedPrompt]);
            
            // Try to generate with free APIs
            $imageUrl = $this->generateWithFreeAPIs($enhancedPrompt);
            Log::info('Image generation completed', ['image_url' => $imageUrl]);
            
            return [
                'success' => true,
                'image_url' => $imageUrl,
                'prompt' => $enhancedPrompt,
                'fallback' => $imageUrl === $this->getFallbackImage()
            ];

        } catch (\Exception $e) {
            Log::error('Simple AI T-Shirt Design Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return [
                'success' => false,
                'error' => 'حدث خطأ في إنشاء تصميم التيشرت: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Try free APIs for image generation
     */
    private function generateWithFreeAPIs(string $prompt): string
    {
        Log::info('Starting free APIs generation', ['prompt' => $prompt]);
        
        // For now, create a simple placeholder design
        $designImage = $this->createSimpleDesign($prompt);
        if ($designImage !== null) {
            Log::info('Simple design created', ['result' => $designImage]);
            return $designImage;
        }
        
        // Final fallback
        Log::warning('Simple design failed, using fallback image');
        return $this->getFallbackImage();
    }

    /**
     * Generate with Hugging Face Inference API (free)
     */
    private function generateWithHuggingFace(string $prompt): ?string
    {
        try {
            Log::info('Trying Hugging Face Inference API');
            
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => false, // Disable SSL verification for testing
            ])->timeout(120)->post('https://api-inference.huggingface.co/models/stabilityai/stable-diffusion-xl-base-1.0', [
                'inputs' => $prompt,
                'parameters' => [
                    'negative_prompt' => 'blurry, low quality, distorted, watermark, text, signature, nsfw',
                    'width' => 1024,
                    'height' => 1024,
                    'num_inference_steps' => 20,
                    'guidance_scale' => 7.5
                ]
            ]);

            Log::info('Hugging Face API Response', [
                'status' => $response->status(),
                'content_type' => $response->header('Content-Type')
            ]);

            if ($response->successful()) {
                $contentType = $response->header('Content-Type');
                
                if (strpos($contentType, 'image/') === 0) {
                    // Direct image response
                    $imageData = $response->body();
                    return $this->saveImageData($imageData, $prompt);
                } else {
                    // JSON response with error
                    $data = $response->json();
                    Log::warning('Hugging Face API returned JSON instead of image', ['data' => $data]);
                }
            } else {
                Log::error('Hugging Face API Error: ' . $response->body());
            }

            return null;

        } catch (\Exception $e) {
            Log::error('Hugging Face Error: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return null;
        }
    }

    /**
     * Generate with Stable Diffusion Web (with SSL disabled)
     */
    private function generateWithStableDiffusionWeb(string $prompt): ?string
    {
        try {
            Log::info('Trying Stable Diffusion Web API with SSL disabled');
            
            $apiKey = config('services.stablediffusion.api_key');
            if (empty($apiKey)) {
                Log::warning('Stable Diffusion Web API key not configured');
                return null;
            }
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => false, // Disable SSL verification
                'curl' => [
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                    CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2,
                ]
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
     * Enhance prompt for t-shirt design
     */
    private function enhanceTShirtPrompt(string $prompt): string
    {
        return "Professional t-shirt design: {$prompt}. High quality, suitable for screen printing, clear colors, detailed design, 1024x1024 resolution.";
    }

    /**
     * Save image data directly
     */
    private function saveImageData(string $imageData, string $prompt): string
    {
        try {
            $filename = 'design_' . time() . '_' . uniqid() . '.png';
            $path = storage_path('app/public/designs/' . $filename);
            
            // Ensure directory exists
            $directory = dirname($path);
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
            
            file_put_contents($path, $imageData);
            
            return asset('storage/designs/' . $filename);
        } catch (\Exception $e) {
            Log::error('Error saving image data: ' . $e->getMessage());
            return $this->getFallbackImage();
        }
    }

    /**
     * Save generated image from URL
     */
    private function saveGeneratedImage(string $imageUrl, string $prompt): string
    {
        try {
            $filename = 'design_' . time() . '_' . uniqid() . '.png';
            $path = storage_path('app/public/designs/' . $filename);
            
            // Ensure directory exists
            $directory = dirname($path);
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
            
            // Download image
            $imageData = file_get_contents($imageUrl);
            if ($imageData !== false) {
                file_put_contents($path, $imageData);
                return asset('storage/designs/' . $filename);
            }
            
            return $this->getFallbackImage();
        } catch (\Exception $e) {
            Log::error('Error saving generated image: ' . $e->getMessage());
            return $this->getFallbackImage();
        }
    }

    /**
     * Create a simple design based on prompt
     */
    private function createSimpleDesign(string $prompt): ?string
    {
        try {
            Log::info('Creating simple design', ['prompt' => $prompt]);
            
            // Create a simple PNG image with text
            $width = 400;
            $height = 300;
            
            // Create image
            $image = imagecreatetruecolor($width, $height);
            
            // Define colors
            $white = imagecolorallocate($image, 255, 255, 255);
            $black = imagecolorallocate($image, 0, 0, 0);
            $red = imagecolorallocate($image, 255, 0, 0);
            $blue = imagecolorallocate($image, 0, 0, 255);
            $green = imagecolorallocate($image, 0, 255, 0);
            
            // Fill background
            imagefill($image, 0, 0, $white);
            
            // Add border
            imagerectangle($image, 5, 5, $width-5, $height-5, $black);
            
            // Add title
            $title = "AI Generated Design";
            imagestring($image, 5, 50, 20, $title, $black);
            
            // Add prompt (truncated)
            $displayPrompt = substr($prompt, 0, 50) . "...";
            imagestring($image, 3, 20, 60, $displayPrompt, $blue);
            
            // Add some decorative elements based on prompt
            if (strpos(strtolower($prompt), 'red') !== false || strpos(strtolower($prompt), 'أحمر') !== false) {
                imagefilledrectangle($image, 50, 100, 150, 150, $red);
            }
            if (strpos(strtolower($prompt), 'blue') !== false || strpos(strtolower($prompt), 'أزرق') !== false) {
                imagefilledrectangle($image, 200, 100, 300, 150, $blue);
            }
            if (strpos(strtolower($prompt), 'green') !== false || strpos(strtolower($prompt), 'أخضر') !== false) {
                imagefilledrectangle($image, 125, 180, 225, 230, $green);
            }
            
            // Add timestamp
            $timestamp = date('Y-m-d H:i:s');
            imagestring($image, 2, 20, $height-30, $timestamp, $black);
            
            // Save image
            $filename = 'simple_design_' . time() . '_' . uniqid() . '.png';
            $path = storage_path('app/public/designs/' . $filename);
            
            // Ensure directory exists
            $directory = dirname($path);
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }
            
            if (imagepng($image, $path)) {
                imagedestroy($image);
                return asset('storage/designs/' . $filename);
            }
            
            imagedestroy($image);
            return null;
            
        } catch (\Exception $e) {
            Log::error('Error creating simple design: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get fallback image
     */
    private function getFallbackImage(): string
    {
        return asset('images/placeholder-design.svg');
    }
}
