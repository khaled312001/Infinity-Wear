<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // إضافة صلاحية إدارة الإشعارات المخصصة للأدمن
        Permission::create([
            'name' => 'admin_notifications',
            'display_name' => 'إدارة الإشعارات المخصصة',
            'description' => 'إمكانية إرسال وإدارة الإشعارات والإيميلات للمستخدمين',
            'user_type' => 'admin',
            'module' => 'notifications',
            'is_active' => true
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::where('name', 'admin_notifications')->delete();
    }
};