<?php
/**
 * Simple Instagram Image Downloader for Infinity Wear
 * This script helps download images from Instagram URLs
 */

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

class SimpleInstagramDownloader {
    private $downloadDir;
    private $portfolioDir;
    
    public function __construct() {
        $this->downloadDir = __DIR__ . '/images/instagram_downloads';
        $this->portfolioDir = __DIR__ . '/images/portfolio';
        
        // Create directories if they don't exist
        if (!is_dir($this->downloadDir)) {
            mkdir($this->downloadDir, 0755, true);
        }
        if (!is_dir($this->portfolioDir)) {
            mkdir($this->portfolioDir, 0755, true);
        }
    }
    
    /**
     * Download image from URL
     */
    public function downloadImage($url, $filename) {
        // Initialize cURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        
        $imageData = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        if ($httpCode !== 200 || $imageData === false) {
            return false;
        }
        
        $filepath = $this->downloadDir . '/' . $filename;
        $result = file_put_contents($filepath, $imageData);
        
        return $result !== false ? $filepath : false;
    }
    
    /**
     * Copy image to portfolio directory
     */
    public function addToPortfolio($sourcePath, $newName) {
        $targetPath = $this->portfolioDir . '/' . $newName;
        return copy($sourcePath, $targetPath);
    }
    
    /**
     * Get file extension from URL
     */
    private function getFileExtension($url) {
        $path = parse_url($url, PHP_URL_PATH);
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        return $extension ?: 'jpg';
    }
    
    /**
     * Generate unique filename
     */
    private function generateFilename($category = 'instagram') {
        return $category . '_' . date('Y-m-d_H-i-s') . '_' . uniqid() . '.jpg';
    }
}

// Handle form submission
$message = '';
$error = '';

if ($_POST) {
    $downloader = new SimpleInstagramDownloader();
    
    if (isset($_POST['image_url']) && !empty($_POST['image_url'])) {
        $url = $_POST['image_url'];
        $category = $_POST['category'] ?? 'instagram';
        $customName = $_POST['custom_name'] ?? '';
        
        // Generate filename
        if (!empty($customName)) {
            $filename = $customName . '.jpg';
        } else {
            $filename = $downloader->generateFilename($category);
        }
        
        // Download image
        $result = $downloader->downloadImage($url, $filename);
        
        if ($result) {
            // Add to portfolio if requested
            if (isset($_POST['add_to_portfolio'])) {
                $portfolioResult = $downloader->addToPortfolio($result, $filename);
                if ($portfolioResult) {
                    $message = "تم تنزيل الصورة وإضافتها للمعرض بنجاح: " . $filename;
                } else {
                    $message = "تم تنزيل الصورة بنجاح: " . $filename . " (لم يتم إضافتها للمعرض)";
                }
            } else {
                $message = "تم تنزيل الصورة بنجاح: " . $filename;
            }
        } else {
            $error = "فشل في تنزيل الصورة. تأكد من صحة الرابط.";
        }
    } else {
        $error = "يرجى إدخال رابط الصورة.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تنزيل صور إنستغرام - إنفينيتي وير</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
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
            font-size: 2em;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        
        input[type="url"], input[type="text"], select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        input[type="url"]:focus, input[type="text"]:focus, select:focus {
            outline: none;
            border-color: #667eea;
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            margin: 15px 0;
        }
        
        .checkbox-group input[type="checkbox"] {
            margin-left: 10px;
            transform: scale(1.2);
        }
        
        .btn {
            background: #667eea;
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.3s;
            width: 100%;
        }
        
        .btn:hover {
            background: #5a6fd8;
        }
        
        .message {
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: bold;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .instructions {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            border-right: 4px solid #667eea;
        }
        
        .instructions h3 {
            color: #667eea;
            margin-bottom: 15px;
        }
        
        .instructions ol {
            padding-right: 20px;
        }
        
        .instructions li {
            margin-bottom: 8px;
            line-height: 1.6;
        }
        
        .category-info {
            background: #e8f4fd;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
            font-size: 14px;
        }
        
        .category-info strong {
            color: #0066cc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>تنزيل صور إنستغرام - إنفينيتي وير</h1>
        
        <div class="instructions">
            <h3>كيفية الحصول على رابط الصورة:</h3>
            <ol>
                <li>انتقل إلى حساب إنستغرام <a href="https://www.instagram.com/infinityw.sa" target="_blank">@infinityw.sa</a></li>
                <li>انقر على الصورة التي تريد تنزيلها</li>
                <li>انقر على النقاط الثلاث (...) في الزاوية العلوية</li>
                <li>اختر "نسخ الرابط" أو "Copy Link"</li>
                <li>الصق الرابط في الحقل أدناه</li>
            </ol>
        </div>
        
        <?php if ($message): ?>
            <div class="message success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="message error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="image_url">رابط صورة إنستغرام:</label>
                <input type="url" id="image_url" name="image_url" 
                       placeholder="https://www.instagram.com/p/..." 
                       value="<?php echo isset($_POST['image_url']) ? htmlspecialchars($_POST['image_url']) : ''; ?>" required>
            </div>
            
            <div class="form-group">
                <label for="category">فئة الصورة:</label>
                <select id="category" name="category">
                    <option value="football" <?php echo (isset($_POST['category']) && $_POST['category'] === 'football') ? 'selected' : ''; ?>>كرة قدم</option>
                    <option value="basketball" <?php echo (isset($_POST['category']) && $_POST['category'] === 'basketball') ? 'selected' : ''; ?>>كرة سلة</option>
                    <option value="school" <?php echo (isset($_POST['category']) && $_POST['category'] === 'school') ? 'selected' : ''; ?>>مدارس</option>
                    <option value="corporate" <?php echo (isset($_POST['category']) && $_POST['category'] === 'corporate') ? 'selected' : ''; ?>>شركات</option>
                    <option value="medical" <?php echo (isset($_POST['category']) && $_POST['category'] === 'medical') ? 'selected' : ''; ?>>طبي</option>
                    <option value="instagram" <?php echo (isset($_POST['category']) && $_POST['category'] === 'instagram') ? 'selected' : ''; ?>>عام</option>
                </select>
                <div class="category-info">
                    <strong>ملاحظة:</strong> الفئة تساعد في تنظيم الصور في المعرض. 
                    سيتم استخدامها لتحديد الفلتر المناسب في قسم "أعمالنا السابقة".
                </div>
            </div>
            
            <div class="form-group">
                <label for="custom_name">اسم مخصص (اختياري):</label>
                <input type="text" id="custom_name" name="custom_name" 
                       placeholder="مثال: فريق_الرياض_2024"
                       value="<?php echo isset($_POST['custom_name']) ? htmlspecialchars($_POST['custom_name']) : ''; ?>">
                <small style="color: #666; font-size: 14px;">اتركه فارغاً لاستخدام اسم تلقائي</small>
            </div>
            
            <div class="checkbox-group">
                <input type="checkbox" id="add_to_portfolio" name="add_to_portfolio" 
                       <?php echo isset($_POST['add_to_portfolio']) ? 'checked' : 'checked'; ?>>
                <label for="add_to_portfolio">إضافة الصورة إلى معرض الأعمال تلقائياً</label>
            </div>
            
            <button type="submit" class="btn">تنزيل الصورة</button>
        </form>
        
        <div style="margin-top: 30px; padding: 20px; background: #fff3cd; border-radius: 10px; border-right: 4px solid #ffc107;">
            <h3 style="color: #856404; margin-bottom: 10px;">نصائح مهمة:</h3>
            <ul style="color: #856404; padding-right: 20px;">
                <li>تأكد من أن الصور من تصميماتك الخاصة</li>
                <li>استخدم أسماء وصفية للصور لتسهيل التنظيم</li>
                <li>بعد التنزيل، انتقل إلى <a href="update_portfolio.php">صفحة تحديث المعرض</a> لتحديث الموقع</li>
                <li>يمكنك مراجعة الصور المنزلة في مجلد <code>images/instagram_downloads/</code></li>
            </ul>
        </div>
    </div>
</body>
</html>
