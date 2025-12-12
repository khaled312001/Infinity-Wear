<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultSettings = [
            // General Settings
            'site_name' => 'Infinity Wear',
            'site_tagline' => 'مؤسسة الزي اللامحدود',
            'site_description' => 'مؤسسة متخصصة في تصنيع وتوريد الملابس والزي الرسمي للشركات والمؤسسات',
            'default_language' => 'ar',
            'default_currency' => 'SAR',
            'timezone' => 'Asia/Riyadh',
            
            // Contact Information
            'contact_email' => 'info@infinitywear.com',
            'contact_phone' => '+966500982394',
            'whatsapp_number' => '+966500982394',
            'support_email' => 'support@infinitywear.com',
            'address' => 'المملكة العربية السعودية، مكة',
            'business_hours' => 'الأحد - الخميس: 8:00 ص - 6:00 م',
            'emergency_contact' => '+966 50 987 6543',
            
            // Social Media
            'facebook_url' => 'https://facebook.com/infinitywear',
            'twitter_url' => 'https://twitter.com/infinitywear',
            'instagram_url' => 'https://instagram.com/infinitywear',
            'linkedin_url' => 'https://linkedin.com/company/infinitywear',
            'youtube_url' => 'https://youtube.com/c/infinitywear',
            'tiktok_url' => '',
            
            // System Settings
            'enable_registration' => '1',
            'email_verification' => '1',
            'maintenance_mode' => '0',
            'debug_mode' => '0',
            'backup_frequency' => 'daily',
            'log_level' => 'warning',
            'session_timeout' => '120',
        ];

        foreach ($defaultSettings as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }
    }
}
