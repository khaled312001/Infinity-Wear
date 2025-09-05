<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::create([
            'name' => 'مدير النظام',
            'email' => 'admin@infinitywear.sa',
            'password' => Hash::make('admin123'),
            'phone' => '+966501234567',
            'is_active' => true,
        ]);
    }
} 