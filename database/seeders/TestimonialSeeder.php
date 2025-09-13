<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'محمد العبدالله',
                'client_position' => 'مدير المشتريات',
                'client_company' => 'مدارس مكة الأهلية',
                'content' => 'تعاملنا مع شركة إنفينيتي وير كان تجربة رائعة. الجودة ممتازة والالتزام بالمواعيد مثالي. نوصي بهم بشدة لجميع المدارس التي تبحث عن زي مدرسي متميز.',
                'rating' => 5,
                'image' => 'testimonials/client1.jpg',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'client_name' => 'سارة الفهد',
                'client_position' => 'مديرة الموارد البشرية',
                'client_company' => 'شركة الاتصالات المتكاملة',
                'content' => 'الزي الموحد الذي صممته وأنتجته شركة إنفينيتي وير لموظفينا كان أكثر من رائع. الاهتمام بالتفاصيل والجودة العالية جعلت موظفينا سعداء جدًا بالزي الجديد.',
                'rating' => 5,
                'image' => 'testimonials/client2.jpg',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'client_name' => 'خالد المنصور',
                'client_position' => 'المدير مكةي',
                'client_company' => 'نادي النصر مكةي',
                'content' => 'الأطقم الرياضية التي صنعتها إنفينيتي وير لفريقنا كانت ذات جودة استثنائية. المواد المستخدمة مريحة ومتينة، والتصميم كان مميزًا جدًا.',
                'rating' => 4,
                'image' => 'testimonials/client3.jpg',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'client_name' => 'نورة السعيد',
                'client_position' => 'مديرة العمليات',
                'client_company' => 'مستشفى الشفاء',
                'content' => 'الزي الطبي الذي أنتجته إنفينيتي وير لطاقمنا الطبي كان مثاليًا من حيث الراحة والمتانة. نقدر التزامهم بالجودة والمواعيد.',
                'rating' => 5,
                'image' => 'testimonials/client4.jpg',
                'is_active' => true
            ],
            [
                'client_name' => 'فهد العتيبي',
                'client_position' => 'مدير عام',
                'client_company' => 'فنادق الخليج',
                'content' => 'تعاملنا مع إنفينيتي وير لتصميم وإنتاج زي موحد لموظفي الفندق. كانت النتيجة مبهرة والخدمة ممتازة من البداية إلى النهاية.',
                'rating' => 5,
                'image' => 'testimonials/client5.jpg',
                'is_active' => true,
                'sort_order' => 5
            ]
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}