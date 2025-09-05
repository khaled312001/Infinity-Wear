<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            AdminSeeder::class,
        ]);

        // إنشاء مستخدم تجريبي
        User::create([
            'name' => 'مستخدم تجريبي',
            'email' => 'test@infinitywear.sa',
            'password' => bcrypt('password123'),
            'phone' => '+966501234567',
            'address' => 'الرياض المملكة العربية السعودية',
            'city' => 'الرياض',
            'user_type' => 'customer',
        ]);
    }
}
