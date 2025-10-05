<?php

namespace App\Console\Commands;

use App\Services\NotificationService;
use Illuminate\Console\Command;

class CleanupOldNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:cleanup {--days=30 : عدد الأيام للاحتفاظ بالإشعارات}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'تنظيف الإشعارات المؤرشفة القديمة';

    protected $notificationService;

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
        
        $this->info("تنظيف الإشعارات المؤرشفة الأقدم من {$days} يوم...");

        $deletedCount = $this->notificationService->cleanupOldNotifications($days);

        $this->info("تم حذف {$deletedCount} إشعار مؤرشف قديم.");
        
        return 0;
    }
}
