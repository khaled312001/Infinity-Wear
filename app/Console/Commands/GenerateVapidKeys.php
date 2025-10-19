<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Minishlink\WebPush\VAPID;

class GenerateVapidKeys extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:generate-vapid-keys';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate VAPID keys for push notifications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Generating VAPID keys for push notifications...');
        
        try {
            $keys = VAPID::createVapidKeys();
            
            $this->info('VAPID keys generated successfully!');
            $this->line('');
            $this->line('Add these keys to your .env file:');
            $this->line('');
            $this->line('PUSH_VAPID_PUBLIC_KEY=' . $keys['publicKey']);
            $this->line('PUSH_VAPID_PRIVATE_KEY=' . $keys['privateKey']);
            $this->line('PUSH_VAPID_SUBJECT=mailto:admin@infinitywear.com');
            $this->line('');
            $this->warn('Make sure to keep the private key secure and never commit it to version control!');
            
        } catch (\Exception $e) {
            $this->error('Failed to generate VAPID keys: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
