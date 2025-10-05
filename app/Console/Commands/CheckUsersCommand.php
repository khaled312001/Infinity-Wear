<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CheckUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check marketing and sales users in database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== Marketing Users ===');
        $marketingUsers = User::where('user_type', 'marketing')->get(['name', 'email', 'user_type', 'is_active']);
        
        if ($marketingUsers->count() > 0) {
            foreach($marketingUsers as $user) {
                $this->line("Name: {$user->name}");
                $this->line("Email: {$user->email}");
                $this->line("Type: {$user->user_type}");
                $this->line("Active: " . ($user->is_active ? 'Yes' : 'No'));
                $this->line("---");
            }
        } else {
            $this->warn('No marketing users found!');
        }

        $this->info('');
        $this->info('=== Sales Users ===');
        $salesUsers = User::where('user_type', 'sales')->get(['name', 'email', 'user_type', 'is_active']);
        
        if ($salesUsers->count() > 0) {
            foreach($salesUsers as $user) {
                $this->line("Name: {$user->name}");
                $this->line("Email: {$user->email}");
                $this->line("Type: {$user->user_type}");
                $this->line("Active: " . ($user->is_active ? 'Yes' : 'No'));
                $this->line("---");
            }
        } else {
            $this->warn('No sales users found!');
        }

        $this->info('');
        $this->info("Total Marketing Users: {$marketingUsers->count()}");
        $this->info("Total Sales Users: {$salesUsers->count()}");
        
        return 0;
    }
}
