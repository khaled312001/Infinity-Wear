<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\SalesTeam;
use Illuminate\Support\Facades\Hash;

class SalesTeamSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء مسؤول جديد لفريق المبيعات
        $admin1 = Admin::create([
            'name' => 'مدير المبيعات',
            'email' => 'sales.manager@infinitywear.sa',
            'password' => Hash::make('sales123'),
            'role' => 'manager',
            'is_active' => true,
        ]);

        // إضافة المسؤول إلى فريق المبيعات
        SalesTeam::create([
            'admin_id' => $admin1->id,
            'position' => 'مدير المبيعات',
            'region' => 'مكة',
            'target' => 100000.00,
            'achieved' => 75000.00,
            'phone' => '+966501234572',
            'is_active' => true
        ]);

        // إنشاء مسؤول آخر لفريق المبيعات
        $admin2 = Admin::create([
            'name' => 'مندوب مبيعات',
            'email' => 'sales.rep@infinitywear.sa',
            'password' => Hash::make('sales456'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // إضافة المسؤول إلى فريق المبيعات
        SalesTeam::create([
            'admin_id' => $admin2->id,
            'position' => 'مندوب مبيعات',
            'region' => 'جدة',
            'target' => 50000.00,
            'achieved' => 30000.00,
            'phone' => '+966501234573',
            'is_active' => true
        ]);
    }
}