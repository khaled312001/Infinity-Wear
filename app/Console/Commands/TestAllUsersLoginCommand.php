<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Admin;
use App\Models\Importer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class TestAllUsersLoginCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:test-all-login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test login functionality for all user types (Admin, Importer, Sales, Marketing)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('═══════════════════════════════════════════════════════');
        $this->info('اختبار تسجيل الدخول لجميع أنواع المستخدمين');
        $this->info('═══════════════════════════════════════════════════════');
        $this->newLine();

        $users = [
            [
                'type' => 'Admin (User Table)',
                'email' => 'admin@infinitywear.sa',
                'password' => 'password123',
                'login_url' => '/admin/login',
            ],
            [
                'type' => 'Admin (Admin Table)',
                'email' => 'admin@infinitywear.sa',
                'password' => 'password123',
                'login_url' => '/admin/login',
                'table' => 'admins',
            ],
            [
                'type' => 'Importer',
                'email' => 'importer@infinitywear.sa',
                'password' => 'importer123',
                'login_url' => '/login',
            ],
            [
                'type' => 'Sales',
                'email' => 'sales@infinitywear.sa',
                'password' => 'sales123',
                'login_url' => '/sales/login',
            ],
            [
                'type' => 'Marketing',
                'email' => 'marketing@infinitywear.sa',
                'password' => 'marketing123',
                'login_url' => '/marketing/login',
            ],
        ];

        $allPassed = true;

        foreach ($users as $userData) {
            $this->info("اختبار: {$userData['type']}");
            $this->line("البريد: {$userData['email']}");
            
            if (isset($userData['table']) && $userData['table'] === 'admins') {
                // اختبار Admin من جدول admins
                $admin = Admin::where('email', $userData['email'])->first();
                
                if ($admin) {
                    $passwordCheck = Hash::check($userData['password'], $admin->password);
                    $this->line("الحالة: " . ($admin->is_active ? 'نشط' : 'غير نشط'));
                    $this->line("الدور: {$admin->role}");
                    $this->line("التحقق من كلمة المرور: " . ($passwordCheck ? '✓ نجح' : '✗ فشل'));
                    
                    if (!$passwordCheck) {
                        $allPassed = false;
                    }
                } else {
                    $this->error('✗ المستخدم غير موجود في جدول admins');
                    $allPassed = false;
                }
            } else {
                // اختبار User من جدول users
                $user = User::where('email', $userData['email'])->first();
                
                if ($user) {
                    $passwordCheck = Hash::check($userData['password'], $user->password);
                    $this->line("الاسم: {$user->name}");
                    $this->line("نوع المستخدم: {$user->user_type}");
                    $this->line("الحالة: " . ($user->is_active ? 'نشط' : 'غير نشط'));
                    $this->line("البريد مفعّل: " . ($user->email_verified_at ? 'نعم' : 'لا'));
                    $this->line("التحقق من كلمة المرور: " . ($passwordCheck ? '✓ نجح' : '✗ فشل'));
                    
                    // التحقق من السجلات المرتبطة
                    if ($user->user_type === 'importer') {
                        $importer = Importer::where('user_id', $user->id)->first();
                        $this->line("سجل المستورد: " . ($importer ? '✓ موجود' : '✗ غير موجود'));
                    }
                    
                    if (!$passwordCheck) {
                        $allPassed = false;
                    }
                } else {
                    $this->error('✗ المستخدم غير موجود في جدول users');
                    $allPassed = false;
                }
            }
            
            $this->line("رابط تسجيل الدخول: {$userData['login_url']}");
            $this->newLine();
        }

        $this->info('═══════════════════════════════════════════════════════');
        if ($allPassed) {
            $this->info('✓ جميع الاختبارات نجحت!');
        } else {
            $this->error('✗ بعض الاختبارات فشلت!');
        }
        $this->info('═══════════════════════════════════════════════════════');
        
        $this->newLine();
        $this->info('ملخص روابط تسجيل الدخول:');
        $this->table(
            ['النوع', 'البريد الإلكتروني', 'كلمة المرور', 'الرابط'],
            [
                ['المدير', 'admin@infinitywear.sa', 'password123', 'https://infinitywearsa.com/admin/login'],
                ['المستورد', 'importer@infinitywear.sa', 'importer123', 'https://infinitywearsa.com/login'],
                ['فريق المبيعات', 'sales@infinitywear.sa', 'sales123', 'https://infinitywearsa.com/sales/login'],
                ['فريق التسويق', 'marketing@infinitywear.sa', 'marketing123', 'https://infinitywearsa.com/marketing/login'],
            ]
        );

        return $allPassed ? 0 : 1;
    }
}

