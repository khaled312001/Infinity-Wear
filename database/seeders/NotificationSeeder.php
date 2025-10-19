<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notification;
use App\Models\User;
use App\Models\Admin;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // الحصول على أول مدير
        $admin = Admin::first();
        if (!$admin) {
            $this->command->warn('No admin found. Please create an admin first.');
            return;
        }

        // البحث عن مستخدم مطابق للمدير
        $user = User::where('email', $admin->email)->where('user_type', 'admin')->first();
        
        if (!$user) {
            // إنشاء مستخدم جديد للمدير إذا لم يكن موجوداً
            $user = User::create([
                'name' => $admin->name,
                'email' => $admin->email,
                'password' => $admin->password,
                'user_type' => 'admin',
                'is_active' => true,
            ]);
            $this->command->info('Created admin user: ' . $user->email);
        }

        // إنشاء إشعارات متنوعة
        $notifications = [
            [
                'user_id' => $user->id,
                'type' => 'order',
                'title' => 'طلب جديد من العميل أحمد محمد',
                'message' => 'تم استلام طلب جديد بقيمة 1,500 ريال. يرجى مراجعة التفاصيل والبدء في المعالجة.',
                'icon' => 'fas fa-shopping-cart',
                'color' => 'success',
                'data' => ['order_id' => 1001, 'amount' => 1500],
                'is_read' => false,
                'created_at' => now()->subMinutes(30),
            ],
            [
                'user_id' => $user->id,
                'type' => 'contact',
                'title' => 'رسالة تواصل جديدة من سارة أحمد',
                'message' => 'العميلة سارة أحمد تريد الاستفسار عن خدمات التصميم المخصص. يرجى الرد خلال 24 ساعة.',
                'icon' => 'fas fa-envelope',
                'color' => 'info',
                'data' => ['contact_id' => 2001, 'priority' => 'high'],
                'is_read' => false,
                'created_at' => now()->subHours(2),
            ],
            [
                'user_id' => $user->id,
                'type' => 'whatsapp',
                'title' => 'رسالة واتساب من العميل محمد علي',
                'message' => 'العميل محمد علي يريد تحديث طلبه رقم 1001. يرجى التواصل معه.',
                'icon' => 'fab fa-whatsapp',
                'color' => 'warning',
                'data' => ['phone' => '+966501234567', 'order_id' => 1001],
                'is_read' => true,
                'read_at' => now()->subMinutes(15),
                'created_at' => now()->subHours(4),
            ],
            [
                'user_id' => $user->id,
                'type' => 'importer_order',
                'title' => 'طلب مستورد جديد من شركة الرياض للملابس',
                'message' => 'شركة الرياض للملابس تريد طلب 500 قطعة من التيشيرتات الرياضية. يرجى إعداد عرض السعر.',
                'icon' => 'fas fa-truck',
                'color' => 'danger',
                'data' => ['company' => 'شركة الرياض للملابس', 'quantity' => 500],
                'is_read' => false,
                'created_at' => now()->subHours(6),
            ],
            [
                'user_id' => $user->id,
                'type' => 'system',
                'title' => 'تحديث النظام بنجاح',
                'message' => 'تم تحديث النظام إلى الإصدار 2.1.0 بنجاح. جميع الميزات الجديدة متاحة الآن.',
                'icon' => 'fas fa-cog',
                'color' => 'primary',
                'data' => ['version' => '2.1.0', 'features' => ['notifications', 'reports']],
                'is_read' => true,
                'read_at' => now()->subHours(1),
                'created_at' => now()->subDay(),
            ],
            [
                'user_id' => $user->id,
                'type' => 'order',
                'title' => 'تم تسليم الطلب رقم 1000',
                'message' => 'تم تسليم طلب العميل فهد السعد بنجاح. العميل راضٍ عن الجودة والخدمة.',
                'icon' => 'fas fa-check-circle',
                'color' => 'success',
                'data' => ['order_id' => 1000, 'delivery_date' => now()->subHours(3)],
                'is_read' => false,
                'created_at' => now()->subHours(3),
            ],
            [
                'user_id' => $user->id,
                'type' => 'contact',
                'title' => 'استفسار عن الأسعار من مدرسة النخيل',
                'message' => 'مدرسة النخيل تريد عرض أسعار للزي المدرسي لـ 200 طالب. يرجى إعداد العرض.',
                'icon' => 'fas fa-graduation-cap',
                'color' => 'info',
                'data' => ['school' => 'مدرسة النخيل', 'students' => 200],
                'is_read' => false,
                'created_at' => now()->subHours(8),
            ],
            [
                'user_id' => $user->id,
                'type' => 'whatsapp',
                'title' => 'تأكيد موعد من العميل نورا أحمد',
                'message' => 'العميلة نورا أحمد تؤكد موعدها غداً الساعة 10 صباحاً لمراجعة التصاميم.',
                'icon' => 'fab fa-whatsapp',
                'color' => 'warning',
                'data' => ['phone' => '+966507654321', 'appointment' => 'tomorrow 10am'],
                'is_read' => true,
                'read_at' => now()->subMinutes(45),
                'created_at' => now()->subHours(12),
            ],
            [
                'user_id' => $user->id,
                'type' => 'importer_order',
                'title' => 'طلب عاجل من نادي الشباب الرياضي',
                'message' => 'نادي الشباب الرياضي يطلب 100 جيرسي عاجلاً للمباراة القادمة. يرجى إعطاء الأولوية.',
                'icon' => 'fas fa-exclamation-triangle',
                'color' => 'danger',
                'data' => ['club' => 'نادي الشباب الرياضي', 'urgency' => 'high', 'quantity' => 100],
                'is_read' => false,
                'created_at' => now()->subMinutes(15),
            ],
            [
                'user_id' => $user->id,
                'type' => 'system',
                'title' => 'نسخة احتياطية مكتملة',
                'message' => 'تم إنشاء نسخة احتياطية من قاعدة البيانات بنجاح. البيانات محفوظة بأمان.',
                'icon' => 'fas fa-database',
                'color' => 'primary',
                'data' => ['backup_size' => '2.5GB', 'location' => 'secure_server'],
                'is_read' => true,
                'read_at' => now()->subHours(2),
                'created_at' => now()->subHours(3),
            ],
        ];

        // إنشاء الإشعارات
        foreach ($notifications as $notificationData) {
            Notification::create($notificationData);
        }

        $this->command->info('Created ' . count($notifications) . ' notifications successfully!');
        
        // عرض إحصائيات
        $totalNotifications = Notification::count();
        $unreadNotifications = Notification::where('is_read', false)->count();
        $readNotifications = Notification::where('is_read', true)->count();
        
        $this->command->info("Notification Statistics:");
        $this->command->info("- Total: {$totalNotifications}");
        $this->command->info("- Unread: {$unreadNotifications}");
        $this->command->info("- Read: {$readNotifications}");
    }
}