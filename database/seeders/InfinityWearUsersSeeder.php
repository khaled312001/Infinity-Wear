<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class InfinityWearUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء مستخدم الإدارة
        User::updateOrCreate(
            ['email' => 'admin@infinitywear.sa'],
            [
                'name' => 'عبدالكريم',
                'email' => 'admin@infinitywear.sa',
                'password' => Hash::make('password123'),
                'phone' => '+966501234567',
                'address' => 'الرياض، المملكة العربية السعودية',
                'city' => 'الرياض',
                'user_type' => 'admin',
                'is_active' => true,
                'bio' => 'مدير النظام في شركة إنفينيتي وير',
                'email_verified_at' => now(),
            ]
        );

        // إنشاء مستخدم فريق التسويق
        User::updateOrCreate(
            ['email' => 'marketing@infinitywear.sa'],
            [
                'name' => 'أحمد التسويق',
                'email' => 'marketing@infinitywear.sa',
                'password' => Hash::make('marketing123'),
                'phone' => '+966501234568',
                'address' => 'الرياض، حي النخيل',
                'city' => 'الرياض',
                'user_type' => 'marketing',
                'is_active' => true,
                'bio' => 'مدير فريق التسويق في شركة إنفينيتي وير',
                'email_verified_at' => now(),
            ]
        );

        // إنشاء مستخدم فريق المبيعات
        User::updateOrCreate(
            ['email' => 'sales@infinitywear.sa'],
            [
                'name' => 'محمد المبيعات',
                'email' => 'sales@infinitywear.sa',
                'password' => Hash::make('sales123'),
                'phone' => '+966501234569',
                'address' => 'الرياض، حي العليا',
                'city' => 'الرياض',
                'user_type' => 'sales',
                'is_active' => true,
                'bio' => 'مدير فريق المبيعات في شركة إنفينيتي وير',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('تم إنشاء حسابات المستخدمين بنجاح!');
        $this->command->info('حساب الإدارة: admin@infinitywear.sa / password123');
        $this->command->info('حساب التسويق: marketing@infinitywear.sa / marketing123');
        $this->command->info('حساب المبيعات: sales@infinitywear.sa / sales123');
    }
}
