<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MarketingReport;
use App\Models\User;
use Carbon\Carbon;

class MarketingReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing users for created_by field
        $users = User::all();
        if ($users->isEmpty()) {
            // Create a default user if none exist
            $user = User::create([
                'name' => 'مدير المبيعات',
                'email' => 'sales@infinitywearsa.com',
                'password' => bcrypt('password'),
                'role' => 'sales'
            ]);
            $users = collect([$user]);
        }

        $representatives = [
            'أحمد محمد العتيبي',
            'سارة عبدالله القحطاني',
            'محمد سالم الشهري',
            'فاطمة أحمد الزهراني',
            'عبدالرحمن خالد المطيري',
            'نورا سعد الغامدي',
            'خالد عبدالعزيز النعيمي',
            'ريم عبدالله العتيبي',
            'عبدالله محمد القحطاني',
            'هند سعد الشهري'
        ];

        $companies = [
            [
                'name' => 'أكاديمية النجاح الرياضية',
                'activity' => 'sports_academy',
                'address' => 'الرياض - حي النرجس',
                'responsible' => 'عبدالله محمد النجاح',
                'phone' => '0501234567',
                'position' => 'مدير الأكاديمية'
            ],
            [
                'name' => 'مدرسة الأمل الابتدائية',
                'activity' => 'school',
                'address' => 'جدة - حي الروضة',
                'responsible' => 'فاطمة أحمد الأمل',
                'phone' => '0502345678',
                'position' => 'مديرة المدرسة'
            ],
            [
                'name' => 'شركة التقنية المتقدمة',
                'activity' => 'institution_company',
                'address' => 'الدمام - حي الفيصلية',
                'responsible' => 'محمد سالم التقني',
                'phone' => '0503456789',
                'position' => 'مدير الموارد البشرية'
            ],
            [
                'name' => 'محل الجملة التجاري',
                'activity' => 'wholesale_store',
                'address' => 'مكة المكرمة - شارع الستين',
                'responsible' => 'سعد عبدالله التجاري',
                'phone' => '0504567890',
                'position' => 'صاحب المحل'
            ],
            [
                'name' => 'أكاديمية النجوم الذهبية',
                'activity' => 'sports_academy',
                'address' => 'الرياض - حي الملز',
                'responsible' => 'نورا سعد النجوم',
                'phone' => '0505678901',
                'position' => 'مديرة الأكاديمية'
            ],
            [
                'name' => 'مدرسة المستقبل الثانوية',
                'activity' => 'school',
                'address' => 'الخبر - حي الشاطئ',
                'responsible' => 'خالد عبدالعزيز المستقبل',
                'phone' => '0506789012',
                'position' => 'مدير المدرسة'
            ],
            [
                'name' => 'مؤسسة التميز للخدمات',
                'activity' => 'institution_company',
                'address' => 'الطائف - حي العزيزية',
                'responsible' => 'ريم عبدالله التميز',
                'phone' => '0507890123',
                'position' => 'مديرة المؤسسة'
            ],
            [
                'name' => 'محل التجزئة الحديث',
                'activity' => 'retail_store',
                'address' => 'الرياض - حي العليا',
                'responsible' => 'عبدالرحمن خالد الحديث',
                'phone' => '0508901234',
                'position' => 'مدير المحل'
            ],
            [
                'name' => 'أكاديمية الأبطال الرياضية',
                'activity' => 'sports_academy',
                'address' => 'جدة - حي الزهراء',
                'responsible' => 'هند سعد الأبطال',
                'phone' => '0509012345',
                'position' => 'مديرة الأكاديمية'
            ],
            [
                'name' => 'مدرسة النهضة الابتدائية',
                'activity' => 'school',
                'address' => 'الدمام - حي الشاطئ',
                'responsible' => 'أحمد محمد النهضة',
                'phone' => '0500123456',
                'position' => 'مدير المدرسة'
            ],
            [
                'name' => 'شركة الإبداع التقني',
                'activity' => 'institution_company',
                'address' => 'الرياض - حي النخيل',
                'responsible' => 'سارة عبدالله الإبداع',
                'phone' => '0501234567',
                'position' => 'مديرة الموارد البشرية'
            ],
            [
                'name' => 'محل الجملة الكبير',
                'activity' => 'wholesale_store',
                'address' => 'مكة المكرمة - حي العزيزية',
                'responsible' => 'محمد سالم الكبير',
                'phone' => '0502345678',
                'position' => 'صاحب المحل'
            ],
            [
                'name' => 'أكاديمية النخبة الرياضية',
                'activity' => 'sports_academy',
                'address' => 'الخبر - حي الشاطئ',
                'responsible' => 'فاطمة أحمد النخبة',
                'phone' => '0503456789',
                'position' => 'مديرة الأكاديمية'
            ],
            [
                'name' => 'مدرسة الريادة الثانوية',
                'activity' => 'school',
                'address' => 'الطائف - حي العزيزية',
                'responsible' => 'عبدالله محمد الريادة',
                'phone' => '0504567890',
                'position' => 'مدير المدرسة'
            ],
            [
                'name' => 'مؤسسة التطوير المتقدم',
                'activity' => 'institution_company',
                'address' => 'جدة - حي الروضة',
                'responsible' => 'نورا سعد التطوير',
                'phone' => '0505678901',
                'position' => 'مديرة المؤسسة'
            ]
        ];

        $visitTypes = ['office_visit', 'phone_call', 'whatsapp'];
        $agreementStatuses = ['agreed', 'rejected', 'needs_time'];
        $reportStatuses = ['pending', 'approved', 'rejected', 'under_review'];

        $customerConcerns = [
            ['الجودة', 'السعر', 'وقت التسليم'],
            ['السعر', 'التصميم', 'الخدمة'],
            ['الجودة', 'وقت التسليم'],
            ['السعر', 'التصميم'],
            ['الجودة', 'السعر', 'التصميم', 'وقت التسليم'],
            ['وقت التسليم', 'الخدمة'],
            ['السعر', 'الخدمة'],
            ['الجودة', 'التصميم'],
            ['السعر', 'وقت التسليم', 'الخدمة'],
            ['الجودة', 'التصميم', 'الخدمة']
        ];

        $recommendations = [
            'تطوير خط إنتاج جديد يناسب احتياجات العميل',
            'تقديم خصم خاص للطلبات الكبيرة',
            'تحسين جودة المواد المستخدمة',
            'تقليل وقت التسليم إلى النصف',
            'إضافة خدمات ما بعد البيع',
            'تطوير تطبيق إلكتروني للطلبات',
            'تقديم ضمان إضافي على المنتجات',
            'تحسين التصميمات لتكون أكثر عصرية',
            'تطوير نظام تتبع الطلبات',
            'تقديم خدمات التصميم المخصص'
        ];

        $nextSteps = [
            'إرسال عينة من المنتجات للعميل',
            'إعداد عرض أسعار مفصل',
            'ترتيب لقاء مع الإدارة العليا',
            'إرسال كتالوج المنتجات الجديد',
            'تقديم عرض تقديمي للفريق',
            'إعداد اتفاقية إطارية',
            'ترتيب زيارة للمصنع',
            'إرسال تقرير مفصل عن الخدمات',
            'تنسيق اجتماع مع فريق المشتريات',
            'إعداد خطة عمل مفصلة'
        ];

        // Create 50 marketing reports with realistic data
        for ($i = 0; $i < 50; $i++) {
            $company = $companies[array_rand($companies)];
            $representative = $representatives[array_rand($representatives)];
            $visitType = $visitTypes[array_rand($visitTypes)];
            $agreementStatus = $agreementStatuses[array_rand($agreementStatuses)];
            $reportStatus = $reportStatuses[array_rand($reportStatuses)];
            $user = $users->random();

            // Create realistic date range (last 6 months)
            $createdAt = Carbon::now()->subDays(rand(0, 180))->subHours(rand(0, 23))->subMinutes(rand(0, 59));

            MarketingReport::create([
                'representative_name' => $representative,
                'company_name' => $company['name'],
                'company_images' => [
                    'company_1.jpg',
                    'company_2.jpg',
                    'company_3.jpg'
                ],
                'company_address' => $company['address'],
                'company_activity' => $company['activity'],
                'responsible_name' => $company['responsible'],
                'responsible_phone' => $company['phone'],
                'responsible_position' => $company['position'],
                'visit_type' => $visitType,
                'agreement_status' => $agreementStatus,
                'customer_concerns' => $customerConcerns[array_rand($customerConcerns)],
                'target_quantity' => rand(50, 2000),
                'annual_consumption' => rand(100, 5000),
                'recommendations' => $recommendations[array_rand($recommendations)],
                'next_steps' => $nextSteps[array_rand($nextSteps)],
                'created_by' => $user->id,
                'status' => $reportStatus,
                'notes' => 'تقرير مفصل عن الزيارة مع ملاحظات إضافية حول احتياجات العميل وتوقعاته من الخدمة المقدمة.',
                'created_at' => $createdAt,
                'updated_at' => $createdAt
            ]);
        }

        // Create some reports with specific patterns for better statistics
        $this->createSpecificReports($users, $companies, $representatives);
    }

    private function createSpecificReports($users, $companies, $representatives)
    {
        // Create reports for this month
        for ($i = 0; $i < 15; $i++) {
            $company = $companies[array_rand($companies)];
            $representative = $representatives[array_rand($representatives)];
            $user = $users->random();

            MarketingReport::create([
                'representative_name' => $representative,
                'company_name' => $company['name'] . ' - فرع ' . ($i + 1),
                'company_images' => ['company_' . ($i + 1) . '.jpg'],
                'company_address' => $company['address'],
                'company_activity' => $company['activity'],
                'responsible_name' => $company['responsible'],
                'responsible_phone' => '050' . rand(1000000, 9999999),
                'responsible_position' => $company['position'],
                'visit_type' => 'office_visit',
                'agreement_status' => 'agreed',
                'customer_concerns' => ['الجودة', 'السعر'],
                'target_quantity' => rand(100, 1000),
                'annual_consumption' => rand(200, 2000),
                'recommendations' => 'تطوير خط إنتاج جديد يناسب احتياجات العميل',
                'next_steps' => 'إرسال عينة من المنتجات للعميل',
                'created_by' => $user->id,
                'status' => 'approved',
                'notes' => 'تقرير شهري - تم الاتفاق مع العميل على شروط التعاون',
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now()->subDays(rand(1, 30))
            ]);
        }

        // Create some pending reports
        for ($i = 0; $i < 8; $i++) {
            $company = $companies[array_rand($companies)];
            $representative = $representatives[array_rand($representatives)];
            $user = $users->random();

            MarketingReport::create([
                'representative_name' => $representative,
                'company_name' => $company['name'] . ' - مراجعة ' . ($i + 1),
                'company_images' => ['review_' . ($i + 1) . '.jpg'],
                'company_address' => $company['address'],
                'company_activity' => $company['activity'],
                'responsible_name' => $company['responsible'],
                'responsible_phone' => '050' . rand(1000000, 9999999),
                'responsible_position' => $company['position'],
                'visit_type' => 'phone_call',
                'agreement_status' => 'needs_time',
                'customer_concerns' => ['وقت التسليم', 'الخدمة'],
                'target_quantity' => rand(75, 800),
                'annual_consumption' => rand(150, 1500),
                'recommendations' => 'تحسين وقت التسليم وتقديم خدمات إضافية',
                'next_steps' => 'إعداد عرض أسعار مفصل',
                'created_by' => $user->id,
                'status' => 'pending',
                'notes' => 'تقرير قيد المراجعة - يحتاج إلى موافقة الإدارة',
                'created_at' => Carbon::now()->subDays(rand(1, 15)),
                'updated_at' => Carbon::now()->subDays(rand(1, 15))
            ]);
        }
    }
}
