<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class TestLoginCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:test-login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test login functionality for marketing and sales users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Testing Login Functionality ===');
        
        // اختبار تسجيل دخول فريق التسويق
        $this->info('Testing Marketing User Login...');
        $marketingUser = User::where('email', 'marketing@infinitywear.sa')->first();
        
        if ($marketingUser) {
            $passwordCheck = Hash::check('marketing123', $marketingUser->password);
            $this->line("Marketing User: {$marketingUser->name}");
            $this->line("Email: {$marketingUser->email}");
            $this->line("Password Check: " . ($passwordCheck ? 'PASS' : 'FAIL'));
            $this->line("User Type: {$marketingUser->user_type}");
            $this->line("Is Active: " . ($marketingUser->is_active ? 'Yes' : 'No'));
        } else {
            $this->error('Marketing user not found!');
        }
        
        $this->line('');
        
        // اختبار تسجيل دخول فريق المبيعات
        $this->info('Testing Sales User Login...');
        $salesUser = User::where('email', 'sales@infinitywear.sa')->first();
        
        if ($salesUser) {
            $passwordCheck = Hash::check('sales123', $salesUser->password);
            $this->line("Sales User: {$salesUser->name}");
            $this->line("Email: {$salesUser->email}");
            $this->line("Password Check: " . ($passwordCheck ? 'PASS' : 'FAIL'));
            $this->line("User Type: {$salesUser->user_type}");
            $this->line("Is Active: " . ($salesUser->is_active ? 'Yes' : 'No'));
        } else {
            $this->error('Sales user not found!');
        }
        
        $this->line('');
        $this->info('=== Login URLs ===');
        $this->line('Marketing Login: /marketing/login');
        $this->line('Sales Login: /sales/login');
        $this->line('Admin Login: /admin/login');
        
        $this->line('');
        $this->info('=== Dashboard URLs ===');
        $this->line('Marketing Dashboard: /marketing/dashboard');
        $this->line('Sales Dashboard: /sales/dashboard');
        $this->line('Admin Dashboard: /admin/dashboard');
        
        return 0;
    }
}
