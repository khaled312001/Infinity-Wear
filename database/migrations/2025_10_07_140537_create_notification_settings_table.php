<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            
            // إعدادات البريد الإلكتروني العامة
            $table->boolean('email_notifications_enabled')->default(true);
            $table->string('smtp_host')->nullable();
            $table->integer('smtp_port')->default(587);
            $table->string('smtp_username')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('smtp_encryption')->default('tls'); // tls, ssl, null
            $table->string('from_email')->nullable();
            $table->string('from_name')->default('Infinity Wear');
            $table->string('admin_email')->nullable();
            
            // إعدادات الإشعارات حسب النوع
            $table->boolean('notify_new_orders')->default(true);
            $table->boolean('notify_contact_messages')->default(true);
            $table->boolean('notify_whatsapp_messages')->default(true);
            $table->boolean('notify_importer_orders')->default(true);
            $table->boolean('notify_system_updates')->default(true);
            
            // إعدادات إضافية
            $table->boolean('email_verification_enabled')->default(true);
            $table->integer('email_rate_limit')->default(60); // عدد الإيميلات في الدقيقة
            $table->boolean('email_queue_enabled')->default(true);
            $table->text('email_template_customization')->nullable(); // JSON للقوالب المخصصة
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};
