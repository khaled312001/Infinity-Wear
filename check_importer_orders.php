<?php
/**
 * فحص طلبات المستوردين في قاعدة البيانات
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ImporterOrder;

echo "===========================================\n";
echo "فحص طلبات المستوردين\n";
echo "===========================================\n\n";

$orders = ImporterOrder::whereNotNull('design_details')->get(['id', 'order_number', 'design_details']);

if ($orders->count() > 0) {
    echo "تم العثور على " . $orders->count() . " طلب:\n\n";
    
    foreach ($orders as $order) {
        echo "Order ID: " . $order->id . "\n";
        echo "Order Number: " . $order->order_number . "\n";
        echo "Design Details: " . json_encode($order->design_details, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) . "\n";
        echo "----------------------------------------\n\n";
    }
} else {
    echo "لا توجد طلبات في قاعدة البيانات\n";
}

echo "===========================================\n";
echo "اكتمل الفحص!\n";
echo "===========================================\n";
