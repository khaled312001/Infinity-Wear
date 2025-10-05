<?php
/**
 * Portfolio Updater for Infinity Wear
 * This script updates the portfolio section with new Instagram images
 */

class PortfolioUpdater {
    private $portfolioDir;
    private $homeViewPath;
    private $backupPath;
    
    public function __construct() {
        $this->portfolioDir = __DIR__ . '/images/portfolio';
        $this->homeViewPath = __DIR__ . '/resources/views/home.blade.php';
        $this->backupPath = __DIR__ . '/backups';
        
        // Create backup directory
        if (!is_dir($this->backupPath)) {
            mkdir($this->backupPath, 0755, true);
        }
    }
    
    /**
     * Backup current home.blade.php file
     */
    public function backupHomeView() {
        $backupFile = $this->backupPath . '/home_backup_' . date('Y-m-d_H-i-s') . '.blade.php';
        return copy($this->homeViewPath, $backupFile);
    }
    
    /**
     * Get all portfolio images
     */
    public function getPortfolioImages() {
        $images = [];
        $files = glob($this->portfolioDir . '/*.{jpg,jpeg,png,gif}', GLOB_BRACE);
        
        foreach ($files as $file) {
            $filename = basename($file);
            $images[] = [
                'filename' => $filename,
                'path' => $file,
                'size' => filesize($file),
                'modified' => filemtime($file)
            ];
        }
        
        return $images;
    }
    
    /**
     * Generate portfolio item HTML
     */
    public function generatePortfolioItem($image, $index) {
        $category = $this->determineCategory($image['filename']);
        $title = $this->generateTitle($image['filename']);
        $description = $this->generateDescription($image['filename']);
        
        return '
                <div class="portfolio-item" data-category="' . $category . '">
                    <div class="portfolio-image">
                        <img src="{{ asset(\'images/portfolio/' . $image['filename'] . '\') }}" alt="' . $title . '">
                        <div class="portfolio-overlay">
                            <div class="portfolio-content">
                                <h3>' . $title . '</h3>
                                <p>' . $description . '</p>
                                <a href="#" class="btn btn-primary">عرض المزيد</a>
                            </div>
                        </div>
                    </div>
                </div>';
    }
    
    /**
     * Determine category from filename
     */
    private function determineCategory($filename) {
        $filename = strtolower($filename);
        
        if (strpos($filename, 'football') !== false || strpos($filename, 'soccer') !== false) {
            return 'football';
        } elseif (strpos($filename, 'basketball') !== false) {
            return 'basketball';
        } elseif (strpos($filename, 'school') !== false || strpos($filename, 'uniform') !== false) {
            return 'schools';
        } elseif (strpos($filename, 'corporate') !== false || strpos($filename, 'company') !== false) {
            return 'companies';
        } elseif (strpos($filename, 'medical') !== false) {
            return 'medical';
        } else {
            return 'football'; // default category
        }
    }
    
    /**
     * Generate title from filename
     */
    private function generateTitle($filename) {
        $filename = strtolower($filename);
        
        if (strpos($filename, 'football') !== false) {
            return 'تصميم فريق كرة قدم';
        } elseif (strpos($filename, 'basketball') !== false) {
            return 'تصميم فريق كرة سلة';
        } elseif (strpos($filename, 'school') !== false) {
            return 'زي مدرسي رياضي';
        } elseif (strpos($filename, 'corporate') !== false) {
            return 'زي شركة';
        } elseif (strpos($filename, 'medical') !== false) {
            return 'زي طبي';
        } elseif (strpos($filename, 'instagram') !== false) {
            return 'تصميم إنفينيتي وير';
        } else {
            return 'تصميم مخصص';
        }
    }
    
    /**
     * Generate description from filename
     */
    private function generateDescription($filename) {
        $filename = strtolower($filename);
        
        if (strpos($filename, 'football') !== false) {
            return 'تصميم متكامل لفريق كرة قدم مع جيرسي وشورت وجوارب';
        } elseif (strpos($filename, 'basketball') !== false) {
            return 'تصميم احترافي لفريق كرة سلة بألوان مميزة';
        } elseif (strpos($filename, 'school') !== false) {
            return 'زي رياضي موحد للمدارس بتصميم عصري';
        } elseif (strpos($filename, 'corporate') !== false) {
            return 'زي عمل احترافي للشركات والمؤسسات';
        } elseif (strpos($filename, 'medical') !== false) {
            return 'زي طبي عالي الجودة للمستشفيات والعيادات';
        } else {
            return 'تصميم مخصص من إنفينيتي وير';
        }
    }
    
    /**
     * Update portfolio section in home.blade.php
     */
    public function updatePortfolioSection() {
        // Backup current file
        $this->backupHomeView();
        
        // Read current home.blade.php
        $content = file_get_contents($this->homeViewPath);
        
        // Get all portfolio images
        $images = $this->getPortfolioImages();
        
        // Generate new portfolio items
        $portfolioItems = '';
        foreach ($images as $index => $image) {
            $portfolioItems .= $this->generatePortfolioItem($image, $index);
        }
        
        // Find and replace portfolio grid section
        $pattern = '/<div class="infinity-portfolio-grid">(.*?)<\/div>/s';
        $replacement = '<div class="infinity-portfolio-grid">' . $portfolioItems . '
            </div>';
        
        $newContent = preg_replace($pattern, $replacement, $content);
        
        // Write updated content
        return file_put_contents($this->homeViewPath, $newContent);
    }
    
    /**
     * Add new image to portfolio
     */
    public function addImageToPortfolio($imagePath, $category = 'football', $title = '', $description = '') {
        $filename = basename($imagePath);
        $targetPath = $this->portfolioDir . '/' . $filename;
        
        // Copy image to portfolio directory
        if (copy($imagePath, $targetPath)) {
            // Update portfolio section
            $this->updatePortfolioSection();
            return true;
        }
        
        return false;
    }
    
    /**
     * Get portfolio statistics
     */
    public function getPortfolioStats() {
        $images = $this->getPortfolioImages();
        $categories = [];
        $totalSize = 0;
        
        foreach ($images as $image) {
            $category = $this->determineCategory($image['filename']);
            $categories[$category] = ($categories[$category] ?? 0) + 1;
            $totalSize += $image['size'];
        }
        
        return [
            'total_images' => count($images),
            'categories' => $categories,
            'total_size' => $totalSize,
            'total_size_mb' => round($totalSize / 1024 / 1024, 2)
        ];
    }
}

// Usage example
if (isset($_GET['action'])) {
    $updater = new PortfolioUpdater();
    
    switch ($_GET['action']) {
        case 'update':
            $result = $updater->updatePortfolioSection();
            echo $result ? "Portfolio updated successfully!" : "Failed to update portfolio.";
            break;
            
        case 'stats':
            $stats = $updater->getPortfolioStats();
            echo "<pre>" . print_r($stats, true) . "</pre>";
            break;
            
        case 'backup':
            $result = $updater->backupHomeView();
            echo $result ? "Backup created successfully!" : "Failed to create backup.";
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تحديث معرض الأعمال - إنفينيتي وير</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        .container {
            max-width: 1000px;
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
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            border-right: 4px solid #667eea;
        }
        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #667eea;
        }
        .stat-label {
            color: #666;
            margin-top: 5px;
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
            text-decoration: none;
            display: inline-block;
        }
        .btn:hover {
            background: #5a6fd8;
        }
        .btn-success {
            background: #28a745;
        }
        .btn-success:hover {
            background: #218838;
        }
        .btn-warning {
            background: #ffc107;
            color: #212529;
        }
        .btn-warning:hover {
            background: #e0a800;
        }
        .actions {
            text-align: center;
            margin: 30px 0;
        }
        .image-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
            margin-top: 20px;
        }
        .image-item {
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
        }
        .image-item img {
            max-width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
        }
        .image-name {
            font-size: 12px;
            margin-top: 5px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>تحديث معرض الأعمال - إنفينيتي وير</h1>
        
        <?php
        $updater = new PortfolioUpdater();
        $stats = $updater->getPortfolioStats();
        $images = $updater->getPortfolioImages();
        ?>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total_images']; ?></div>
                <div class="stat-label">إجمالي الصور</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total_size_mb']; ?> MB</div>
                <div class="stat-label">حجم الملفات</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo count($stats['categories']); ?></div>
                <div class="stat-label">عدد الفئات</div>
            </div>
        </div>
        
        <div class="actions">
            <a href="?action=update" class="btn btn-success">تحديث المعرض</a>
            <a href="?action=backup" class="btn btn-warning">إنشاء نسخة احتياطية</a>
            <a href="?action=stats" class="btn">عرض الإحصائيات</a>
        </div>
        
        <h3>الصور الحالية في المعرض:</h3>
        <div class="image-grid">
            <?php foreach ($images as $image): ?>
                <div class="image-item">
                    <img src="images/portfolio/<?php echo $image['filename']; ?>" alt="<?php echo $image['filename']; ?>">
                    <div class="image-name"><?php echo $image['filename']; ?></div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div style="margin-top: 30px; padding: 20px; background: #f0f8ff; border-radius: 10px;">
            <h3>تعليمات الاستخدام:</h3>
            <ol>
                <li>قم بتنزيل الصور من إنستغرام باستخدام الأداة السابقة</li>
                <li>احفظ الصور في مجلد <code>images/portfolio/</code></li>
                <li>اضغط على "تحديث المعرض" لتحديث صفحة الموقع</li>
                <li>سيتم إنشاء نسخة احتياطية تلقائياً قبل التحديث</li>
            </ol>
        </div>
    </div>
</body>
</html>
