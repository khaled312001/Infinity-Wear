<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\DailyReportService;
use App\Services\NotificationService;
use App\Mail\DailyReportMail;
use Illuminate\Support\Facades\Mail;
use App\Models\NotificationSetting;

class SendDailyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:daily {--date=} {--email=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily report to admin';

    protected $dailyReportService;
    protected $notificationService;

    public function __construct(DailyReportService $dailyReportService, NotificationService $notificationService)
    {
        parent::__construct();
        $this->dailyReportService = $dailyReportService;
        $this->notificationService = $notificationService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== إرسال التقرير اليومي ===');
        $this->newLine();

        try {
            // الحصول على التاريخ
            $date = $this->option('date') ?: null;
            
            // الحصول على البريد الإلكتروني
            $email = $this->option('email') ?: $this->getAdminEmail();
            
            if (!$email) {
                $this->error('❌ لم يتم العثور على بريد إلكتروني للمدير');
                return 1;
            }

            $this->info('1. إنشاء التقرير اليومي...');
            $this->info('   التاريخ: ' . ($date ?: 'أمس'));
            $this->info('   البريد الإلكتروني: ' . $email);
            
            // إنشاء التقرير
            $reportData = $this->dailyReportService->generateDailyReport($date);
            
            $this->info('   ✅ تم إنشاء التقرير بنجاح!');
            $this->newLine();

            // عرض ملخص التقرير
            $this->info('2. ملخص التقرير:');
            $this->info('   الطلبات: ' . $reportData['summary']['total_orders']);
            $this->info('   رسائل الاتصال: ' . $reportData['summary']['total_contacts']);
            $this->info('   رسائل الواتساب: ' . $reportData['summary']['total_whatsapp']);
            $this->info('   طلبات المستوردين: ' . $reportData['summary']['total_importer_orders']);
            $this->info('   المهام: ' . $reportData['summary']['total_tasks']);
            $this->info('   التقارير التسويقية: ' . $reportData['summary']['total_marketing_reports']);
            $this->info('   تقارير المبيعات: ' . $reportData['summary']['total_sales_reports']);
            $this->info('   الإشعارات: ' . $reportData['summary']['total_notifications']);
            $this->newLine();

            // إرسال التقرير
            $this->info('3. إرسال التقرير...');
            
            // تحديث إعدادات البريد الإلكتروني
            $this->updateMailConfig();
            
            // إرسال الإيميل
            Mail::to($email)->send(new DailyReportMail($reportData));
            
            $this->info('   ✅ تم إرسال التقرير بنجاح!');
            $this->newLine();

            // إرسال إشعار في النظام
            $this->info('4. إرسال إشعار في النظام...');
            
            $this->notificationService->createSystemNotification(
                'التقرير اليومي',
                'تم إرسال التقرير اليومي بنجاح إلى ' . $email,
                [
                    'report_date' => $reportData['date'],
                    'total_activities' => $reportData['statistics']['total_activities'],
                    'email_sent_to' => $email
                ]
            );
            
            $this->info('   ✅ تم إرسال الإشعار بنجاح!');
            $this->newLine();

            $this->info('=== انتهى الإرسال ===');
            $this->info('النتيجة: ✅ تم إرسال التقرير اليومي بنجاح!');
            
            return 0;

        } catch (\Exception $e) {
            $this->error('❌ خطأ في إرسال التقرير: ' . $e->getMessage());
            $this->error('تتبع الخطأ: ' . $e->getTraceAsString());
            
            return 1;
        }
    }

    /**
     * الحصول على بريد المدير الإلكتروني
     */
    private function getAdminEmail()
    {
        try {
            $settings = NotificationSetting::getSettings();
            return $settings->admin_email ?: 'info@infinitywearsa.com';
        } catch (\Exception $e) {
            return 'info@infinitywearsa.com';
        }
    }

    /**
     * تحديث إعدادات البريد الإلكتروني
     */
    private function updateMailConfig()
    {
        config([
            'mail.default' => 'smtp',
            'mail.mailers.smtp.host' => 'smtp.hostinger.com',
            'mail.mailers.smtp.port' => 465,
            'mail.mailers.smtp.username' => 'info@infinitywearsa.com',
            'mail.mailers.smtp.password' => 'Info2025#*',
            'mail.mailers.smtp.encryption' => 'ssl',
            'mail.from.address' => 'info@infinitywearsa.com',
            'mail.from.name' => 'Infinity Wear',
        ]);
    }
}
