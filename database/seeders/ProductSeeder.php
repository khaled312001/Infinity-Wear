<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        
        $products = [
            [
                'name_ar' => 'قميص رياضي أزرق',
                'name_en' => 'Blue Sports T-Shirt',
                'description_ar' => 'قميص رياضي عالي الجودة باللون الأزرق مناسب للأكاديميات مكةية',
                'description_en' => 'High quality blue sports t-shirt suitable for sports academies',
                'category_id' => $categories->where('slug', 'sports-wear')->first()->id ?? 1,
                'price' => 85.00,
                'sale_price' => 75.00,
                'sku' => 'SPT-001',
                'slug' => 'blue-sports-tshirt',
                'stock_quantity' => 100,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name_ar' => 'شورت رياضي أسود',
                'name_en' => 'Black Sports Shorts',
                'description_ar' => 'شورت رياضي مريح باللون الأسود مصنوع من أفضل الخامات',
                'description_en' => 'Comfortable black sports shorts made from the finest materials',
                'category_id' => $categories->where('slug', 'sports-wear')->first()->id ?? 1,
                'price' => 65.00,
                'sku' => 'SPT-002',
                'slug' => 'black-sports-shorts',
                'stock_quantity' => 80,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name_ar' => 'قميص مدرسي أبيض',
                'name_en' => 'White School Shirt',
                'description_ar' => 'قميص مدرسي كلاسيكي باللون الأبيض مناسب لجميع المراحل الدراسية',
                'description_en' => 'Classic white school shirt suitable for all educational levels',
                'category_id' => $categories->where('slug', 'school-uniform')->first()->id ?? 2,
                'price' => 55.00,
                'sku' => 'SCH-001',
                'slug' => 'white-school-shirt',
                'stock_quantity' => 150,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name_ar' => 'بنطلون مدرسي كحلي',
                'name_en' => 'Navy School Trousers',
                'description_ar' => 'بنطلون مدرسي باللون الكحلي مصنوع من قماش عالي الجودة',
                'description_en' => 'Navy school trousers made from high quality fabric',
                'category_id' => $categories->where('slug', 'school-uniform')->first()->id ?? 2,
                'price' => 95.00,
                'sku' => 'SCH-002',
                'slug' => 'navy-school-trousers',
                'stock_quantity' => 120,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name_ar' => 'قميص شركة رسمي',
                'name_en' => 'Formal Corporate Shirt',
                'description_ar' => 'قميص رسمي للشركات والمؤسسات بتصميم أنيق ومهني',
                'description_en' => 'Formal corporate shirt with elegant and professional design',
                'category_id' => $categories->where('slug', 'corporate-uniform')->first()->id ?? 3,
                'price' => 120.00,
                'sku' => 'CRP-001',
                'slug' => 'formal-corporate-shirt',
                'stock_quantity' => 75,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name_ar' => 'طقم كرة قدم كامل',
                'name_en' => 'Complete Football Kit',
                'description_ar' => 'طقم كرة قدم كامل يشمل القميص والشورت والجوارب',
                'description_en' => 'Complete football kit including shirt, shorts and socks',
                'category_id' => $categories->where('slug', 'football-kit')->first()->id ?? 4,
                'price' => 180.00,
                'sale_price' => 160.00,
                'sku' => 'FTB-001',
                'slug' => 'complete-football-kit',
                'stock_quantity' => 50,
                'is_active' => true,
                'is_featured' => true,
            ],
            [
                'name_ar' => 'قبعة رياضية',
                'name_en' => 'Sports Cap',
                'description_ar' => 'قبعة رياضية أنيقة مناسبة لجميع الأنشطة مكةية',
                'description_en' => 'Elegant sports cap suitable for all sports activities',
                'category_id' => $categories->where('slug', 'sports-accessories')->first()->id ?? 5,
                'price' => 35.00,
                'sku' => 'ACC-001',
                'slug' => 'sports-cap',
                'stock_quantity' => 200,
                'is_active' => true,
                'is_featured' => false,
            ],
            [
                'name_ar' => 'جوارب رياضية',
                'name_en' => 'Sports Socks',
                'description_ar' => 'جوارب رياضية مريحة ومتينة مناسبة لجميع مكةات',
                'description_en' => 'Comfortable and durable sports socks suitable for all sports',
                'category_id' => $categories->where('slug', 'sports-accessories')->first()->id ?? 5,
                'price' => 25.00,
                'sku' => 'ACC-002',
                'slug' => 'sports-socks',
                'stock_quantity' => 300,
                'is_active' => true,
                'is_featured' => false,
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
} 