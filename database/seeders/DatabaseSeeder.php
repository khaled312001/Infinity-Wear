<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // تنفيذ البذور الشاملة
        $this->call([
            ComprehensiveDataSeeder::class,
            HomePageSeeder::class,
            MarketingSalesUsersSeeder::class,
            UserTypePermissionsSeeder::class,
        ]);
    }
}
