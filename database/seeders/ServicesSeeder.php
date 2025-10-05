<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'title' => 'ملابس رياضية',
                'description' => 'نقدم أفضل الملابس الرياضية للأكاديميات والفرق الرياضية بأعلى معايير الجودة والراحة',
                'icon' => 'fas fa-tshirt',
                'image' => 'images/sections/sports-equipment.svg',
                'features' => [
                    'قمصان رياضية',
                    'شورتات رياضية',
                    'جوارب رياضية',
                    'أحذية رياضية'
                ],
                'order' => 1,
                'is_active' => true,
                'meta_title' => 'ملابس رياضية - Infinity Wear',
                'meta_description' => 'أفضل الملابس الرياضية للأكاديميات والفرق الرياضية بأعلى معايير الجودة'
            ],
            [
                'title' => 'زي مدرسي',
                'description' => 'زي موحد أنيق ومريح للمدارس والأكاديميات مصمم ليكون عمليا ومريحا للطلاب',
                'icon' => 'fas fa-user-graduate',
                'image' => 'images/sections/uniform-design.svg',
                'features' => [
                    'قمصان مدرسية',
                    'بنطلونات مدرسية',
                    'جاكيتات مدرسية',
                    'حقائب مدرسية'
                ],
                'order' => 2,
                'is_active' => true,
                'meta_title' => 'زي مدرسي - Infinity Wear',
                'meta_description' => 'زي موحد أنيق ومريح للمدارس والأكاديميات'
            ],
            [
                'title' => 'زي شركات',
                'description' => 'زي موحد احترافي للشركات والمؤسسات يعكس هوية الشركة ويوفر مظهرا موحدا',
                'icon' => 'fas fa-building',
                'image' => 'images/sections/quality-manufacturing.svg',
                'features' => [
                    'قمصان عمل',
                    'بدلات عمل',
                    'معاطف عمل',
                    'إكسسوارات'
                ],
                'order' => 3,
                'is_active' => true,
                'meta_title' => 'زي شركات - Infinity Wear',
                'meta_description' => 'زي موحد احترافي للشركات والمؤسسات'
            ],
            [
                'title' => 'تصميم مخصص',
                'description' => 'نقدم خدمة التصميم المخصص لإنشاء زي موحد يناسب احتياجاتكم ومتطلباتكم الخاصة',
                'icon' => 'fas fa-palette',
                'image' => 'images/sections/custom-design.svg',
                'features' => [
                    'تصميم الشعار',
                    'اختيار الألوان',
                    'تخصيص النصوص',
                    'معاينة التصميم'
                ],
                'order' => 4,
                'is_active' => true,
                'meta_title' => 'تصميم مخصص - Infinity Wear',
                'meta_description' => 'خدمة التصميم المخصص لإنشاء زي موحد يناسب احتياجاتكم'
            ],
            [
                'title' => 'طباعة عالية الجودة',
                'description' => 'نستخدم أحدث تقنيات الطباعة لضمان جودة عالية وديمومة في التصاميم',
                'icon' => 'fas fa-print',
                'image' => 'images/sections/printing-service.svg',
                'features' => [
                    'طباعة الشاشة',
                    'طباعة النقل الحراري',
                    'طباعة التطريز',
                    'طباعة DTG'
                ],
                'order' => 5,
                'is_active' => true,
                'meta_title' => 'طباعة عالية الجودة - Infinity Wear',
                'meta_description' => 'أحدث تقنيات الطباعة لضمان جودة عالية وديمومة في التصاميم'
            ],
            [
                'title' => 'توصيل سريع',
                'description' => 'نقدم خدمة التوصيل السريع لجميع أنحاء المملكة العربية السعودية',
                'icon' => 'fas fa-shipping-fast',
                'image' => 'images/sections/customer-service.svg',
                'features' => [
                    'توصيل مجاني',
                    'توصيل سريع',
                    'تتبع الشحنة',
                    'خدمة عملاء 24/7'
                ],
                'order' => 6,
                'is_active' => true,
                'meta_title' => 'توصيل سريع - Infinity Wear',
                'meta_description' => 'خدمة التوصيل السريع لجميع أنحاء المملكة العربية السعودية'
            ]
        ];

        foreach ($services as $serviceData) {
            Service::create($serviceData);
        }
    }
}