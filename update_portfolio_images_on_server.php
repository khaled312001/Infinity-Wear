<?php
/**
 * سكربت لتحديث مسارات صور المعرض في قاعدة البيانات على الخادم
 * قم بتشغيله مرة واحدة فقط على الخادم
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PortfolioItem;

echo "===========================================\n";
echo "تحديث مسارات صور المعرض\n";
echo "===========================================\n\n";

// قائمة الصور الحقيقية الموجودة في public/images/portfolio/
$realImages = [
    'basketball_team_1.jpg',
    'basketball_team_2.jpg', 
    'basketball_team_ahli.jpg',
    'basketball_women_team.jpg',
    'corporate_uniform_1.jpg',
    'corporate_uniform_aramco.jpg',
    'corporate_uniform_stc.jpg',
    'football_academy_training.jpg',
    'football_kit_1.jpg',
    'football_kit_complete.jpg',
    'football_team_1.jpg',
    'football_team_2.jpg',
    'football_team_riyadh.jpg',
    'medical_uniform_1.jpg',
    'medical_uniform_emergency.jpg',
    'medical_uniform_king_fahd.jpg',
    'school_uniform_1.jpg',
    'school_uniform_2.jpg',
    'school_uniform_riyadh_international.jpg',
    'sports_wear_1.jpg',
    'sports_wear_gym.jpg',
    'sports_wear_outdoor.jpg',
    'university_sports_team.jpg'
];

// تحديث مسارات الصور في قاعدة البيانات
$portfolioItems = PortfolioItem::orderBy('id')->get();
$updated = 0;

foreach ($portfolioItems as $index => $item) {
    if ($index < count($realImages)) {
        $oldImage = $item->image;
        $item->image = 'portfolio/' . $realImages[$index];
        $item->save();
        
        echo "✓ تم تحديث '{$item->title}'\n";
        echo "  من: {$oldImage}\n";
        echo "  إلى: {$item->image}\n\n";
        
        $updated++;
    }
}

echo "\n===========================================\n";
echo "اكتمل التحديث!\n";
echo "تم تحديث {$updated} عنصر من المعرض\n";
echo "===========================================\n";

