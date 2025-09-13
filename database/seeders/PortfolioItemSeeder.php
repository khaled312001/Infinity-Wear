<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PortfolioItem;

class PortfolioItemSeeder extends Seeder
{
    public function run(): void
    {
        $portfolioItems = [
            [
                'title' => 'زي مدرسي لمدرسة مكة الدولية',
                'description' => 'تصميم وتنفيذ زي مدرسي كامل لمدرسة مكة الدولية يشمل الزي الرسمي ومكةي',
                'image' => 'images/portfolio/school_uniform_1.jpg',
                'category' => 'زي مدرسي',
                'client_name' => 'مدرسة مكة الدولية',
                'completion_date' => '2023-08-15',
                'is_featured' => true,
                'sort_order' => 1
            ],
            [
                'title' => 'ملابس رياضية لأكاديمية النجوم',
                'description' => 'تصميم وتنفيذ ملابس رياضية كاملة لأكاديمية النجوم لكرة القدم',
                'image' => 'images/portfolio/sports_wear_1.jpg',
                'category' => 'ملابس رياضية',
                'client_name' => 'أكاديمية النجوم',
                'completion_date' => '2023-09-20',
                'is_featured' => true,
                'sort_order' => 2
            ],
            [
                'title' => 'زي موحد لشركة الاتصالات السعودية',
                'description' => 'تصميم وتنفيذ زي موحد لموظفي شركة الاتصالات السعودية',
                'image' => 'images/portfolio/corporate_uniform_1.jpg',
                'category' => 'زي شركات',
                'client_name' => 'شركة الاتصالات السعودية',
                'completion_date' => '2023-10-10',
                'is_featured' => false,
                'sort_order' => 3
            ],
            [
                'title' => 'أطقم كرة قدم لنادي الهلال الشبابي',
                'description' => 'تصميم وتنفيذ أطقم كرة قدم كاملة لفريق نادي الهلال الشبابي',
                'image' => 'images/portfolio/football_kit_1.jpg',
                'category' => 'أطقم رياضية',
                'client_name' => 'نادي الهلال الشبابي',
                'completion_date' => '2023-11-05',
                'is_featured' => true,
                'sort_order' => 4
            ],
            [
                'title' => 'زي طبي لمستشفى المملكة',
                'description' => 'تصميم وتنفيذ زي طبي كامل لمستشفى المملكة',
                'image' => 'images/portfolio/medical_uniform_1.jpg',
                'category' => 'زي طبي',
                'client_name' => 'مستشفى المملكة',
                'completion_date' => '2023-12-01',
                'is_featured' => false,
                'sort_order' => 5
            ]
        ];

        foreach ($portfolioItems as $item) {
            PortfolioItem::create($item);
        }
    }
}