<?php

namespace App\Console\Commands;

use App\Models\Notification;
use Illuminate\Console\Command;

class CreateTestNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:create-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'إنشاء إشعارات تجريبية لاختبار النظام';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('إنشاء الإشعارات التجريبية...');

        // إنشاء إشعارات تجريبية
        $notifications = [
            [
                'type' => 'order',
                'title' => 'طلب جديد',
                'message' => 'تم استلام طلب جديد من العميل أحمد محمد بقيمة 1,250 ريال',
                'icon' => 'fas fa-shopping-cart',
                'color' => 'success'
            ],
            [
                'type' => 'contact',
                'title' => 'رسالة اتصال جديدة',
                'message' => 'رسالة جديدة من سارة أحمد - استفسار عن المنتجات',
                'icon' => 'fas fa-envelope',
                'color' => 'info'
            ],
            [
                'type' => 'whatsapp',
                'title' => 'رسالة واتساب جديدة',
                'message' => 'رسالة جديدة من محمد علي (+966501234567)',
                'icon' => 'fab fa-whatsapp',
                'color' => 'success'
            ],
            [
                'type' => 'importer_order',
                'title' => 'طلب مستورد جديد',
                'message' => 'طلب جديد من المستورد شركة الأزياء الحديثة',
                'icon' => 'fas fa-industry',
                'color' => 'warning'
            ],
            [
                'type' => 'order',
                'title' => 'طلب جديد',
                'message' => 'تم استلام طلب جديد من العميل فاطمة السعيد بقيمة 850 ريال',
                'icon' => 'fas fa-shopping-cart',
                'color' => 'success'
            ]
        ];

        foreach ($notifications as $notificationData) {
            Notification::create($notificationData);
        }

        $this->info('تم إنشاء ' . count($notifications) . ' إشعار تجريبي بنجاح!');
        
        return 0;
    }
}
