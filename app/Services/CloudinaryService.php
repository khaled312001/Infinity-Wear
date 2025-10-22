<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class CloudinaryService
{
    private $cloudinary;

    public function __construct()
    {
        // تكوين Cloudinary باستخدام v3 API
        $this->cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => config('cloudinary.cloud_name', 'infinity-wear'),
                'api_key' => config('cloudinary.api_key', '787844769525158'),
                'api_secret' => config('cloudinary.api_secret', 'uZa3Vo50vIgiE4UizMtVMW_OAHI'),
            ],
            'url' => [
                'secure' => config('cloudinary.secure', true),
            ],
        ]);
    }

    /**
     * رفع ملف إلى Cloudinary
     */
    public function uploadFile(UploadedFile $file, string $folder = 'designs', array $options = [])
    {
        try {
            $uploadOptions = array_merge([
                'folder' => $folder,
                'resource_type' => 'auto',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ], $options);

            $result = $this->cloudinary->uploadApi()->upload(
                $file->getRealPath(),
                $uploadOptions
            );

            return [
                'success' => true,
                'public_id' => $result['public_id'],
                'secure_url' => $result['secure_url'],
                'url' => $result['url'],
                'format' => $result['format'],
                'width' => $result['width'] ?? null,
                'height' => $result['height'] ?? null,
                'bytes' => $result['bytes'] ?? null,
            ];
        } catch (\Exception $e) {
            Log::error('Cloudinary upload failed', [
                'error' => $e->getMessage(),
                'file' => $file->getClientOriginalName(),
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * رفع ملف من مسار محلي
     */
    public function uploadFromPath(string $filePath, string $folder = 'designs', array $options = [])
    {
        try {
            $uploadOptions = array_merge([
                'folder' => $folder,
                'resource_type' => 'auto',
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ], $options);

            $result = $this->cloudinary->uploadApi()->upload($filePath, $uploadOptions);

            return [
                'success' => true,
                'public_id' => $result['public_id'],
                'secure_url' => $result['secure_url'],
                'url' => $result['url'],
                'format' => $result['format'],
                'width' => $result['width'] ?? null,
                'height' => $result['height'] ?? null,
                'bytes' => $result['bytes'] ?? null,
            ];
        } catch (\Exception $e) {
            Log::error('Cloudinary upload from path failed', [
                'error' => $e->getMessage(),
                'file_path' => $filePath,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * حذف ملف من Cloudinary
     */
    public function deleteFile(string $publicId)
    {
        try {
            $result = $this->cloudinary->uploadApi()->destroy($publicId);
            
            return [
                'success' => $result['result'] === 'ok',
                'result' => $result['result'],
            ];
        } catch (\Exception $e) {
            Log::error('Cloudinary delete failed', [
                'error' => $e->getMessage(),
                'public_id' => $publicId,
            ]);

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * الحصول على URL محسن للصورة
     */
    public function getOptimizedUrl(string $publicId, array $transformations = [])
    {
        try {
            $defaultTransformations = [
                'quality' => 'auto',
                'fetch_format' => 'auto',
            ];

            $transformations = array_merge($defaultTransformations, $transformations);

            $image = $this->cloudinary->image($publicId);
            
            // Apply transformations
            foreach ($transformations as $key => $value) {
                if ($key === 'quality') {
                    $image = $image->quality($value);
                } elseif ($key === 'fetch_format') {
                    $image = $image->format($value);
                } elseif ($key === 'width') {
                    $image = $image->resize(\Cloudinary\Transformation\Resize::scale()->width($value));
                } elseif ($key === 'height') {
                    $image = $image->resize(\Cloudinary\Transformation\Resize::scale()->height($value));
                } elseif ($key === 'crop') {
                    $image = $image->resize(\Cloudinary\Transformation\Resize::fill());
                } elseif ($key === 'gravity') {
                    $image = $image->resize(\Cloudinary\Transformation\Resize::fill()->gravity($value));
                }
            }

            return $image->toUrl();
        } catch (\Exception $e) {
            Log::error('Cloudinary URL generation failed', [
                'error' => $e->getMessage(),
                'public_id' => $publicId,
            ]);

            return null;
        }
    }

    /**
     * الحصول على معاينة صغيرة للصورة
     */
    public function getThumbnailUrl(string $publicId, int $width = 300, int $height = 300)
    {
        return $this->getOptimizedUrl($publicId, [
            'width' => $width,
            'height' => $height,
            'crop' => 'fill',
            'gravity' => 'auto',
        ]);
    }

    /**
     * تحويل URL محلي إلى Cloudinary URL
     */
    public function migrateLocalToCloudinary(string $localPath, string $folder = 'designs')
    {
        if (!file_exists($localPath)) {
            return [
                'success' => false,
                'error' => 'File not found',
            ];
        }

        return $this->uploadFromPath($localPath, $folder);
    }
}
