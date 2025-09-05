<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name_ar' => 'ملابس رياضية',
                'name_en' => 'Sports Wear',
                'description_ar' => 'ملابس رياضية عالية الجودة للأكاديميات والفرق الرياضية',
                'description_en' => 'High quality sports wear for academies and sports teams',
                'slug' => 'sports-wear',
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'name_ar' => 'زي مدرسي',
                'name_en' => 'School Uniform',
                'description_ar' => 'زي موحد أنيق ومريح للمدارس والأكاديميات',
                'description_en' => 'Elegant and comfortable uniform for schools and academies',
                'slug' => 'school-uniform',
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'name_ar' => 'زي شركات',
                'name_en' => 'Corporate Uniform',
                'description_ar' => 'زي موحد احترافي للشركات والمؤسسات',
                'description_en' => 'Professional uniform for companies and institutions',
                'slug' => 'corporate-uniform',
                'is_active' => true,
                'sort_order' => 3
            ],
            [
                'name_ar' => 'ملابس كرة القدم',
                'name_en' => 'Football Kit',
                'description_ar' => 'ملابس متخصصة لكرة القدم مع إمكانية التخصيص',
                'description_en' => 'Specialized football kit with customization options',
                'slug' => 'football-kit',
                'is_active' => true,
                'sort_order' => 4
            ],
            [
                'name_ar' => 'إكسسوارات رياضية',
                'name_en' => 'Sports Accessories',
                'description_ar' => 'إكسسوارات رياضية متنوعة مثل القبعات والجوارب',
                'description_en' => 'Various sports accessories like caps and socks',
                'slug' => 'sports-accessories',
                'is_active' => true,
                'sort_order' => 5
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
} 