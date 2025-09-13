<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // تنفيذ البذور الجديدة فقط
        $this->call([
            AdminSeeder::class,
            ImporterSeeder::class,
            MarketingTeamSeeder::class,
            SalesTeamSeeder::class,
            ImporterOrderSeeder::class,
            TaskSeeder::class,
            PortfolioItemSeeder::class,
            TestimonialSeeder::class,
            OrderSeeder::class,
        ]);

        // إنشاء مستخدم تجريبي
        User::create([
            'name' => 'مستخدم تجريبي',
            'email' => 'test@infinitywear.sa',
            'password' => bcrypt('password123'),
            'phone' => '+966501234567',
            'address' => 'مكة المملكة العربية السعودية',
            'city' => 'مكة',
            'user_type' => 'customer',
        ]);
    }
}
