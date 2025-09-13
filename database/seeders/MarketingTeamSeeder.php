<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\MarketingTeam;
use Illuminate\Support\Facades\Hash;

class MarketingTeamSeeder extends Seeder
{
    public function run(): void
    {
        // إنشاء مسؤول جديد لفريق التسويق
        $admin1 = Admin::create([
            'name' => 'مدير التسويق',
            'email' => 'marketing.manager@infinitywear.sa',
            'password' => Hash::make('marketing123'),
            'role' => 'manager',
            'is_active' => true,
        ]);

        // إضافة المسؤول إلى فريق التسويق
        MarketingTeam::create([
            'admin_id' => $admin1->id,
            'department' => 'digital',
            'position' => 'مدير التسويق',
            'bio' => 'مدير فريق التسويق مع خبرة أكثر من 5 سنوات في مجال التسويق الرقمي',
            'phone' => '+966501234570',
            'is_active' => true
        ]);

        // إنشاء مسؤول آخر لفريق التسويق
        $admin2 = Admin::create([
            'name' => 'أخصائي تسويق',
            'email' => 'marketing.specialist@infinitywear.sa',
            'password' => Hash::make('marketing456'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // إضافة المسؤول إلى فريق التسويق
        MarketingTeam::create([
            'admin_id' => $admin2->id,
            'department' => 'content',
            'position' => 'أخصائي محتوى',
            'bio' => 'أخصائي محتوى مع خبرة في إنشاء المحتوى التسويقي للمنتجات',
            'phone' => '+966501234571',
            'is_active' => true
        ]);
    }
}