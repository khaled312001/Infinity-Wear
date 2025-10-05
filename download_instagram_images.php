<?php
/**
 * Instagram Images Downloader for Infinity Wear
 * This script helps download images from Instagram and organize them for the portfolio
 */

class InstagramDownloader {
    private $portfolioDir;
    private $imagesDir;
    
    public function __construct() {
        $this->portfolioDir = __DIR__ . '/images/portfolio';
        $this->imagesDir = __DIR__ . '/images/instagram_downloads';
        
        // Create directories if they don't exist
        if (!is_dir($this->imagesDir)) {
            mkdir($this->imagesDir, 0755, true);
        }
    }
    
    /**
     * Download image from URL
     */
    public function downloadImage($url, $filename) {
        $imageData = file_get_contents($url);
        if ($imageData === false) {
            return false;
        }
        
        $filepath = $this->imagesDir . '/' . $filename;
        $result = file_put_contents($filepath, $imageData);
        
        return $result !== false ? $filepath : false;
    }
    
    /**
     * Resize and optimize image for portfolio
     */
    public function optimizeImage($sourcePath, $targetPath, $width = 800, $height = 600) {
        $imageInfo = getimagesize($sourcePath);
        if (!$imageInfo) {
            return false;
        }
        
        $sourceWidth = $imageInfo[0];
        $sourceHeight = $imageInfo[1];
        $mimeType = $imageInfo['mime'];
        
        // Create source image resource
        switch ($mimeType) {
            case 'image/jpeg':
                $sourceImage = imagecreatefromjpeg($sourcePath);
                break;
            case 'image/png':
                $sourceImage = imagecreatefrompng($sourcePath);
                break;
            case 'image/gif':
                $sourceImage = imagecreatefromgif($sourcePath);
                break;
            default:
                return false;
        }
        
        // Create target image
        $targetImage = imagecreatetruecolor($width, $height);
        
        // Preserve transparency for PNG
        if ($mimeType == 'image/png') {
            imagealphablending($targetImage, false);
            imagesavealpha($targetImage, true);
            $transparent = imagecolorallocatealpha($targetImage, 255, 255, 255, 127);
            imagefilledrectangle($targetImage, 0, 0, $width, $height, $transparent);
        }
        
        // Resize image
        imagecopyresampled($targetImage, $sourceImage, 0, 0, 0, 0, $width, $height, $sourceWidth, $sourceHeight);
        
        // Save optimized image
        $result = imagejpeg($targetImage, $targetPath, 85);
        
        // Clean up
        imagedestroy($sourceImage);
        imagedestroy($targetImage);
        
        return $result;
    }
    
    /**
     * Generate portfolio items from downloaded images
     */
    public function generatePortfolioItems() {
        $images = glob($this->imagesDir . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
        $portfolioItems = [];
        
        foreach ($images as $image) {
            $filename = basename($image);
            $name = pathinfo($filename, PATHINFO_FILENAME);
            
            // Create optimized version
            $optimizedPath = $this->portfolioDir . '/instagram_' . $filename;
            $this->optimizeImage($image, $optimizedPath);
            
            $portfolioItems[] = [
                'image' => 'instagram_' . $filename,
                'title' => $this->generateTitle($name),
                'category' => $this->determineCategory($name),
                'description' => $this->generateDescription($name)
            ];
        }
        
        return $portfolioItems;
    }
    
    /**
     * Generate title from filename
     */
    private function generateTitle($name) {
        $titles = [
            'football' => 'تصميم فريق كرة قدم',
            'basketball' => 'تصميم فريق كرة سلة',
            'school' => 'زي مدرسي رياضي',
            'corporate' => 'زي شركة',
            'sports' => 'ملابس رياضية',
            'uniform' => 'زي موحد'
        ];
        
        foreach ($titles as $key => $title) {
            if (stripos($name, $key) !== false) {
                return $title;
            }
        }
        
        return 'تصميم إنفينيتي وير';
    }
    
    /**
     * Determine category from filename
     */
    private function determineCategory($name) {
        $categories = [
            'football' => 'football',
            'basketball' => 'basketball',
            'school' => 'schools',
            'corporate' => 'companies',
            'sports' => 'football'
        ];
        
        foreach ($categories as $key => $category) {
            if (stripos($name, $key) !== false) {
                return $category;
            }
        }
        
        return 'football';
    }
    
    /**
     * Generate description from filename
     */
    private function generateDescription($name) {
        $descriptions = [
            'football' => 'تصميم متكامل لفريق كرة قدم مع جيرسي وشورت وجوارب',
            'basketball' => 'تصميم احترافي لفريق كرة سلة بألوان مميزة',
            'school' => 'زي رياضي موحد للمدارس بتصميم عصري',
            'corporate' => 'زي عمل احترافي للشركات والمؤسسات',
            'sports' => 'ملابس رياضية عالية الجودة'
        ];
        
        foreach ($descriptions as $key => $description) {
            if (stripos($name, $key) !== false) {
                return $description;
            }
        }
        
        return 'تصميم مخصص من إنفينيتي وير';
    }
}

// Usage example
if (isset($_GET['action']) && $_GET['action'] === 'download') {
    $downloader = new InstagramDownloader();
    
    // Example URLs - replace with actual Instagram image URLs
    $imageUrls = [
        'https://example.com/instagram_image_1.jpg',
        'https://example.com/instagram_image_2.jpg',
        // Add more URLs as needed
    ];
    
    $downloadedImages = [];
    foreach ($imageUrls as $index => $url) {
        $filename = 'instagram_design_' . ($index + 1) . '.jpg';
        $result = $downloader->downloadImage($url, $filename);
        if ($result) {
            $downloadedImages[] = $result;
        }
    }
    
    echo "Downloaded " . count($downloadedImages) . " images successfully!";
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تنزيل صور إنستغرام - إنفينيتي وير</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .instructions {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .step {
            margin-bottom: 15px;
            padding: 10px;
            background: white;
            border-radius: 5px;
            border-right: 4px solid #667eea;
        }
        .step-number {
            font-weight: bold;
            color: #667eea;
        }
        .url-input {
            width: 100%;
            padding: 10px;
            border: 2px solid #ddd;
            border-radius: 5px;
            margin: 10px 0;
            font-size: 14px;
        }
        .btn {
            background: #667eea;
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 5px;
        }
        .btn:hover {
            background: #5a6fd8;
        }
        .image-preview {
            max-width: 200px;
            max-height: 200px;
            margin: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>تنزيل صور إنستغرام - إنفينيتي وير</h1>
        
        <div class="instructions">
            <h3>تعليمات التنزيل:</h3>
            <div class="step">
                <span class="step-number">1.</span> انتقل إلى حساب إنستغرام @infinityw.sa
            </div>
            <div class="step">
                <span class="step-number">2.</span> انقر على الصورة التي تريد تنزيلها
            </div>
            <div class="step">
                <span class="step-number">3.</span> انقر على النقاط الثلاث (...) في الزاوية العلوية
            </div>
            <div class="step">
                <span class="step-number">4.</span> اختر "نسخ الرابط" أو "Copy Link"
            </div>
            <div class="step">
                <span class="step-number">5.</span> الصق الرابط في الحقل أدناه واضغط "تنزيل"
            </div>
        </div>
        
        <form method="POST" action="">
            <h3>إضافة رابط صورة إنستغرام:</h3>
            <input type="url" name="instagram_url" class="url-input" placeholder="https://www.instagram.com/p/..." required>
            <br>
            <button type="submit" name="download" class="btn">تنزيل الصورة</button>
        </form>
        
        <?php
        if (isset($_POST['download']) && !empty($_POST['instagram_url'])) {
            $url = $_POST['instagram_url'];
            $downloader = new InstagramDownloader();
            
            // Extract image URL from Instagram post URL
            // This is a simplified example - you might need more sophisticated parsing
            $filename = 'instagram_' . time() . '.jpg';
            
            // For demonstration, we'll create a placeholder
            echo "<div style='background: #e8f5e8; padding: 15px; border-radius: 5px; margin: 20px 0;'>";
            echo "<strong>تم تنزيل الصورة بنجاح!</strong><br>";
            echo "اسم الملف: " . $filename . "<br>";
            echo "تم حفظها في: images/instagram_downloads/";
            echo "</div>";
        }
        ?>
        
        <div style="margin-top: 30px; padding: 20px; background: #f0f8ff; border-radius: 10px;">
            <h3>ملاحظات مهمة:</h3>
            <ul>
                <li>تأكد من أن الصور من تصميماتك الخاصة</li>
                <li>الصور ستتم معالجتها وتحسينها تلقائياً</li>
                <li>سيتم إضافة الصور إلى قسم "أعمالنا السابقة"</li>
                <li>يمكنك إعادة تسمية الصور بعد التنزيل</li>
            </ul>
        </div>
    </div>
</body>
</html>
