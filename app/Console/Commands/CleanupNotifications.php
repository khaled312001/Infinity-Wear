<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationService;

class CleanupNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:cleanup {--days=30 : Number of days to keep old notifications}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cleanup old notifications and subscriptions';

    protected $notificationService;

    /**
     * Create a new command instance.
     */
    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        
        $this->info("Cleaning up notifications older than {$days} days...");
        
        try {
            $this->notificationService->cleanupOldNotifications();
            $this->info('Notification cleanup completed successfully.');
            
        } catch (\Exception $e) {
            $this->error('Failed to cleanup notifications: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
