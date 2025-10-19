<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // إرسال التقرير اليومي في الساعة 8:00 صباحاً
        $schedule->command('report:daily')
            ->dailyAt('08:00')
            ->timezone('Asia/Riyadh')
            ->withoutOverlapping()
            ->runInBackground();

        // معالجة الإشعارات المجدولة كل 5 دقائق
        $schedule->command('notifications:process-scheduled')
            ->everyFiveMinutes()
            ->withoutOverlapping()
            ->runInBackground();

        // تنظيف الإشعارات القديمة يومياً في الساعة 2:00 صباحاً
        $schedule->command('notifications:cleanup')
            ->dailyAt('02:00')
            ->timezone('Asia/Riyadh')
            ->withoutOverlapping()
            ->runInBackground();

        // توليد مفاتيح VAPID إذا لم تكن موجودة
        $schedule->command('notifications:generate-vapid-keys')
            ->dailyAt('03:00')
            ->timezone('Asia/Riyadh')
            ->withoutOverlapping()
            ->runInBackground();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
