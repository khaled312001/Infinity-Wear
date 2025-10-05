<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

class MarketingSalesUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء مستخدم فريق التسويق
        $marketingUser = User::create([
            'name' => 'أحمد التسويق',
            'email' => 'marketing@infinitywear.sa',
            'password' => Hash::make('marketing123'),
            'phone' => '+966501234567',
            'address' => 'الرياض، حي النخيل',
            'city' => 'الرياض',
            'user_type' => 'marketing',
            'is_active' => true,
            'bio' => 'مدير فريق التسويق في شركة إنفينيتي وير',
            'email_verified_at' => now(),
        ]);

        // إنشاء مستخدم فريق المبيعات
        $salesUser = User::create([
            'name' => 'محمد المبيعات',
            'email' => 'sales@infinitywear.sa',
            'password' => Hash::make('sales123'),
            'phone' => '+966501234568',
            'address' => 'الرياض، حي العليا',
            'city' => 'الرياض',
            'user_type' => 'sales',
            'is_active' => true,
            'bio' => 'مدير فريق المبيعات في شركة إنفينيتي وير',
            'email_verified_at' => now(),
        ]);

        // إنشاء مستخدم إضافي لفريق التسويق
        $marketingUser2 = User::create([
            'name' => 'فاطمة التسويق',
            'email' => 'marketing2@infinitywear.sa',
            'password' => Hash::make('marketing123'),
            'phone' => '+966501234569',
            'address' => 'جدة، حي الزهراء',
            'city' => 'جدة',
            'user_type' => 'marketing',
            'is_active' => true,
            'bio' => 'مصممة جرافيك في فريق التسويق',
            'email_verified_at' => now(),
        ]);

        // إنشاء مستخدم إضافي لفريق المبيعات
        $salesUser2 = User::create([
            'name' => 'خالد المبيعات',
            'email' => 'sales2@infinitywear.sa',
            'password' => Hash::make('sales123'),
            'phone' => '+966501234570',
            'address' => 'الدمام، حي الفيصلية',
            'city' => 'الدمام',
            'user_type' => 'sales',
            'is_active' => true,
            'bio' => 'مندوب مبيعات في فريق المبيعات',
            'email_verified_at' => now(),
        ]);

        // ربط المستخدمين بالأدوار المناسبة
        $this->assignRoles($marketingUser, 'marketing_rep');
        $this->assignRoles($salesUser, 'sales_rep');
        $this->assignRoles($marketingUser2, 'marketing_rep');
        $this->assignRoles($salesUser2, 'sales_rep');

        $this->command->info('تم إنشاء حسابات الماركتنج والسيلز بنجاح!');
        $this->command->info('حسابات التسويق:');
        $this->command->info('- marketing@infinitywear.sa / marketing123');
        $this->command->info('- marketing2@infinitywear.sa / marketing123');
        $this->command->info('حسابات المبيعات:');
        $this->command->info('- sales@infinitywear.sa / sales123');
        $this->command->info('- sales2@infinitywear.sa / sales123');
    }

    /**
     * ربط المستخدم بالدور المناسب
     */
    private function assignRoles(User $user, string $roleName): void
    {
        $role = Role::where('name', $roleName)->first();
        if ($role) {
            $user->roles()->attach($role->id);
        }
    }
}
