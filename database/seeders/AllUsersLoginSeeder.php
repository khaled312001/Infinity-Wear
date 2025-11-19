<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\Importer;
use App\Models\MarketingTeam;
use App\Models\SalesTeam;

class AllUsersLoginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('بدء إنشاء حسابات تسجيل الدخول لجميع أنواع المستخدمين...');

        // 1. إنشاء حساب المدير (Admin) في جدول Admin
        $admin = Admin::updateOrCreate(
            ['email' => 'admin@infinitywear.sa'],
            [
                'name' => 'مدير النظام',
                'email' => 'admin@infinitywear.sa',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'is_active' => true,
            ]
        );
        $this->command->info('✓ تم إنشاء/تحديث حساب المدير في جدول Admin');

        // 2. إنشاء حساب المدير (Admin) في جدول User أيضاً
        $adminUser = User::updateOrCreate(
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
        $this->command->info('✓ تم إنشاء/تحديث حساب المدير في جدول User');

        // 3. إنشاء حساب المستورد (Importer)
        $importerUser = User::updateOrCreate(
            ['email' => 'importer@infinitywear.sa'],
            [
                'name' => 'مستورد تجريبي',
                'email' => 'importer@infinitywear.sa',
                'password' => Hash::make('importer123'),
                'phone' => '+966501234568',
                'address' => 'مكة المملكة العربية السعودية',
                'city' => 'مكة',
                'user_type' => 'importer',
                'is_active' => true,
                'bio' => 'مستورد تجريبي للنظام',
                'email_verified_at' => now(),
            ]
        );

        // إنشاء سجل المستورد في جدول Importers
        Importer::updateOrCreate(
            ['user_id' => $importerUser->id],
            [
                'user_id' => $importerUser->id,
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
            ]
        );
        $this->command->info('✓ تم إنشاء/تحديث حساب المستورد');

        // 4. إنشاء حساب فريق التسويق (Marketing)
        $marketingUser = User::updateOrCreate(
            ['email' => 'marketing@infinitywear.sa'],
            [
                'name' => 'أحمد التسويق',
                'email' => 'marketing@infinitywear.sa',
                'password' => Hash::make('marketing123'),
                'phone' => '+966501234569',
                'address' => 'الرياض، حي النخيل',
                'city' => 'الرياض',
                'user_type' => 'marketing',
                'is_active' => true,
                'bio' => 'مدير فريق التسويق في شركة إنفينيتي وير',
                'email_verified_at' => now(),
            ]
        );

        // محاولة إنشاء سجل في marketing_team (إذا كان مرتبط بـ admin_id)
        // لكن أولاً نحتاج إلى إنشاء Admin لهذا المستخدم
        $marketingAdmin = Admin::updateOrCreate(
            ['email' => 'marketing@infinitywear.sa'],
            [
                'name' => 'أحمد التسويق',
                'email' => 'marketing@infinitywear.sa',
                'password' => Hash::make('marketing123'),
                'role' => 'marketing',
                'is_active' => true,
            ]
        );

        MarketingTeam::updateOrCreate(
            ['admin_id' => $marketingAdmin->id],
            [
                'admin_id' => $marketingAdmin->id,
                'department' => 'تسويق',
                'position' => 'مدير فريق التسويق',
                'phone' => '+966501234569',
                'is_active' => true,
            ]
        );
        $this->command->info('✓ تم إنشاء/تحديث حساب فريق التسويق');

        // 5. إنشاء حساب فريق المبيعات (Sales)
        $salesUser = User::updateOrCreate(
            ['email' => 'sales@infinitywear.sa'],
            [
                'name' => 'محمد المبيعات',
                'email' => 'sales@infinitywear.sa',
                'password' => Hash::make('sales123'),
                'phone' => '+966501234570',
                'address' => 'الرياض، حي العليا',
                'city' => 'الرياض',
                'user_type' => 'sales',
                'is_active' => true,
                'bio' => 'مدير فريق المبيعات في شركة إنفينيتي وير',
                'email_verified_at' => now(),
            ]
        );

        // محاولة إنشاء سجل في sales_team (إذا كان مرتبط بـ admin_id)
        $salesAdmin = Admin::updateOrCreate(
            ['email' => 'sales@infinitywear.sa'],
            [
                'name' => 'محمد المبيعات',
                'email' => 'sales@infinitywear.sa',
                'password' => Hash::make('sales123'),
                'role' => 'sales',
                'is_active' => true,
            ]
        );

        SalesTeam::updateOrCreate(
            ['admin_id' => $salesAdmin->id],
            [
                'admin_id' => $salesAdmin->id,
                'position' => 'مدير فريق المبيعات',
                'region' => 'الرياض',
                'target' => 100000,
                'achieved' => 0,
                'phone' => '+966501234570',
                'is_active' => true,
            ]
        );
        $this->command->info('✓ تم إنشاء/تحديث حساب فريق المبيعات');

        $this->command->newLine();
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->info('تم إنشاء جميع حسابات تسجيل الدخول بنجاح!');
        $this->command->info('═══════════════════════════════════════════════════════');
        $this->command->newLine();
        $this->command->info('1. المدير (Admin):');
        $this->command->info('   الرابط: https://infinitywearsa.com/admin/login');
        $this->command->info('   البريد: admin@infinitywear.sa');
        $this->command->info('   كلمة المرور: password123');
        $this->command->newLine();
        $this->command->info('2. المستورد (Importer):');
        $this->command->info('   الرابط: https://infinitywearsa.com/login');
        $this->command->info('   البريد: importer@infinitywear.sa');
        $this->command->info('   كلمة المرور: importer123');
        $this->command->newLine();
        $this->command->info('3. فريق المبيعات (Sales):');
        $this->command->info('   الرابط: https://infinitywearsa.com/sales/login');
        $this->command->info('   البريد: sales@infinitywear.sa');
        $this->command->info('   كلمة المرور: sales123');
        $this->command->newLine();
        $this->command->info('4. فريق التسويق (Marketing):');
        $this->command->info('   الرابط: https://infinitywearsa.com/marketing/login');
        $this->command->info('   البريد: marketing@infinitywear.sa');
        $this->command->info('   كلمة المرور: marketing123');
        $this->command->newLine();
    }
}

