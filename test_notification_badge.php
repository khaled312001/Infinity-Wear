<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Notification;

// البحث عن مستخدم مستورد
$user = User::where('user_type', 'importer')->first();

if ($user) {
    $unreadCount = Notification::where('user_id', $user->id)
        ->where('is_read', false)
        ->where('is_archived', false)
        ->count();
    
    echo "عدد الإشعارات غير المقروءة للمستخدم {$user->name}: {$unreadCount}\n";
    
    // إنشاء إشعار جديد للاختبار
    Notification::create([
        'user_id' => $user->id,
        'type' => 'test',
        'title' => 'إشعار اختبار',
        'message' => 'هذا إشعار للاختبار',
        'icon' => 'fas fa-test',
        'color' => 'primary',
        'is_read' => false,
        'data' => ['test' => true]
    ]);
    
    echo "تم إنشاء إشعار اختبار جديد\n";
    
    $newUnreadCount = Notification::where('user_id', $user->id)
        ->where('is_read', false)
        ->where('is_archived', false)
        ->count();
    
    echo "عدد الإشعارات غير المقروءة بعد إضافة الإشعار الجديد: {$newUnreadCount}\n";
} else {
    echo "لم يتم العثور على مستخدم مستورد\n";
}




