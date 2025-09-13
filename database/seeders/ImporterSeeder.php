<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Importer;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ImporterSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء مستخدم مستورد
        $user = User::create([
            'name' => 'مستورد تجريبي',
            'email' => 'importer@infinitywear.sa',
            'password' => Hash::make('importer123'),
            'phone' => '+966501234568',
            'address' => 'مكة المملكة العربية السعودية',
            'city' => 'مكة',
            'user_type' => 'customer',
        ]);

        // إنشاء مستورد مرتبط بالمستخدم
        Importer::create([
            'user_id' => $user->id,
            'name' => 'مستورد تجريبي',
            'email' => 'importer@infinitywear.sa',
            'phone' => '+966501234568',
            'company_name' => 'شركة الاستيراد التجريبية',
            'business_type' => 'store',
            'address' => 'مكة المملكة العربية السعودية',
            'city' => 'مكة',
            'country' => 'المملكة العربية السعودية',
            'notes' => 'مستورد تجريبي للنظام',
            'status' => 'new'
        ]);

        // إنشاء مستورد آخر بدون حساب مستخدم
        Importer::create([
            'name' => 'مستورد جديد',
            'email' => 'new.importer@example.com',
            'phone' => '+966501234569',
            'company_name' => 'شركة الاستيراد الجديدة',
            'business_type' => 'academy',
            'address' => 'جدة المملكة العربية السعودية',
            'city' => 'جدة',
            'country' => 'المملكة العربية السعودية',
            'notes' => 'مستورد جديد للنظام',
            'status' => 'contacted'
        ]);
    }
}