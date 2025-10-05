<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ContentManagement;

class ContentManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // الصفحة الرئيسية
        ContentManagement::create([
            'page_name' => 'home',
            'section_name' => 'hero',
            'content_type' => 'mixed',
            'title_ar' => 'مرحباً بك في Infinity Wear',
            'title_en' => 'Welcome to Infinity Wear',
            'content_ar' => 'نحن مؤسسة الزي اللامحدود - رائدون في تصميم وتصنيع الملابس المخصصة عالية الجودة. نقدم حلولاً شاملة لجميع احتياجاتك من الأزياء.',
            'content_en' => 'We are Infinity Wear - leaders in designing and manufacturing high-quality custom clothing. We provide comprehensive solutions for all your fashion needs.',
            'description_ar' => 'مؤسسة متخصصة في تصميم وتصنيع الملابس المخصصة بأعلى معايير الجودة',
            'description_en' => 'A specialized institution in designing and manufacturing custom clothing with the highest quality standards',
            'button_text_ar' => 'اكتشف خدماتنا',
            'button_text_en' => 'Discover Our Services',
            'button_url' => '/services',
            'sort_order' => 1,
            'is_active' => true,
            'is_featured' => true,
        ]);

        ContentManagement::create([
            'page_name' => 'home',
            'section_name' => 'about',
            'content_type' => 'text',
            'title_ar' => 'من نحن',
            'title_en' => 'About Us',
            'content_ar' => 'تأسست مؤسسة Infinity Wear عام 2020 بهدف تقديم أفضل الحلول في مجال تصميم وتصنيع الملابس المخصصة. نحن نؤمن بأن كل عميل يستحق الحصول على ملابس تعكس شخصيته وأسلوبه الفريد.',
            'content_en' => 'Infinity Wear was established in 2020 with the aim of providing the best solutions in the field of custom clothing design and manufacturing. We believe that every customer deserves to get clothes that reflect their personality and unique style.',
            'description_ar' => 'مؤسسة رائدة في مجال الأزياء المخصصة مع أكثر من 3 سنوات من الخبرة',
            'description_en' => 'A leading institution in custom fashion with more than 3 years of experience',
            'sort_order' => 2,
            'is_active' => true,
            'is_featured' => false,
        ]);

        ContentManagement::create([
            'page_name' => 'home',
            'section_name' => 'services',
            'content_type' => 'mixed',
            'title_ar' => 'خدماتنا المتميزة',
            'title_en' => 'Our Distinguished Services',
            'content_ar' => 'نقدم مجموعة شاملة من الخدمات في مجال الأزياء والملابس المخصصة، بدءاً من التصميم وحتى التصنيع والتسليم.',
            'content_en' => 'We provide a comprehensive range of services in the field of fashion and custom clothing, from design to manufacturing and delivery.',
            'description_ar' => 'خدمات متكاملة تشمل التصميم والتصنيع والتسليم',
            'description_en' => 'Integrated services including design, manufacturing and delivery',
            'button_text_ar' => 'عرض جميع الخدمات',
            'button_text_en' => 'View All Services',
            'button_url' => '/services',
            'sort_order' => 3,
            'is_active' => true,
            'is_featured' => true,
        ]);
    }
}
