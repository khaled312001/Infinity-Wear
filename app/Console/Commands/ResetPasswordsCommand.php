<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:reset-passwords {--new-password=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset passwords for marketing and sales users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $newPassword = $this->option('new-password') ?: 'password123';
        
        $this->info('Resetting passwords for marketing and sales users...');
        
        // إعادة تعيين كلمات مرور فريق التسويق
        $marketingUsers = User::where('user_type', 'marketing')->get();
        foreach ($marketingUsers as $user) {
            $user->password = Hash::make($newPassword);
            $user->save();
            $this->line("Reset password for marketing user: {$user->name} ({$user->email})");
        }
        
        // إعادة تعيين كلمات مرور فريق المبيعات
        $salesUsers = User::where('user_type', 'sales')->get();
        foreach ($salesUsers as $user) {
            $user->password = Hash::make($newPassword);
            $user->save();
            $this->line("Reset password for sales user: {$user->name} ({$user->email})");
        }
        
        $this->info('');
        $this->info("All passwords have been reset to: {$newPassword}");
        $this->info('Marketing users can login at: /marketing/login');
        $this->info('Sales users can login at: /sales/login');
        
        return 0;
    }
}
