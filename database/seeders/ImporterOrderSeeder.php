<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ImporterOrder;
use App\Models\Importer;
use App\Models\Admin;

class ImporterOrderSeeder extends Seeder
{
    public function run(): void
    {
        $importers = Importer::all();
        $admins = Admin::all();
        
        if ($importers->count() > 0 && $admins->count() > 0) {
            // طلب أول
            ImporterOrder::create([
                'importer_id' => $importers->first()->id,
                'order_number' => 'ORD-' . date('Ymd') . '-001',
                'status' => 'new',
                'requirements' => 'زي مدرسي للمرحلة الابتدائية والمتوسطة',
                'quantity' => 500,
                'design_details' => json_encode([
                    'colors' => ['أزرق داكن', 'أبيض'],
                    'logo' => 'شعار المدرسة على الجيب',
                    'material' => 'قطن 100%'
                ]),
                'estimated_cost' => 25000.00,
                'delivery_date' => now()->addDays(30),
                'notes' => 'يجب أن يكون الزي مطابق للمواصفات المرفقة',
                'assigned_to' => $admins->first()->id
            ]);
            
            // طلب ثاني
            if ($importers->count() > 1) {
                ImporterOrder::create([
                    'importer_id' => $importers->skip(1)->first()->id,
                    'order_number' => 'ORD-' . date('Ymd') . '-002',
                    'status' => 'processing',
                    'requirements' => 'زي رياضي لفريق كرة القدم',
                    'quantity' => 30,
                    'design_details' => json_encode([
                        'colors' => ['أخضر', 'أبيض'],
                        'logo' => 'شعار النادي على الصدر',
                        'material' => 'بوليستر مع خاصية امتصاص العرق'
                    ]),
                    'estimated_cost' => 6000.00,
                    'final_cost' => 5800.00,
                    'delivery_date' => now()->addDays(15),
                    'notes' => 'يجب طباعة أرقام اللاعبين على الظهر',
                    'assigned_to' => $admins->skip(1)->first()->id ?? $admins->first()->id
                ]);
            }
            
            // طلب ثالث
            if ($importers->count() > 0) {
                ImporterOrder::create([
                    'importer_id' => $importers->first()->id,
                    'order_number' => 'ORD-' . date('Ymd') . '-003',
                    'status' => 'completed',
                    'requirements' => 'زي موحد لموظفي الاستقبال',
                    'quantity' => 20,
                    'design_details' => json_encode([
                        'colors' => ['أسود', 'ذهبي'],
                        'logo' => 'شعار الشركة مطرز',
                        'material' => 'قماش فاخر مقاوم للتجاعيد'
                    ]),
                    'estimated_cost' => 4000.00,
                    'final_cost' => 4200.00,
                    'delivery_date' => now()->subDays(5),
                    'notes' => 'تم التسليم قبل الموعد المحدد',
                    'assigned_to' => $admins->first()->id
                ]);
            }
        }
    }
}