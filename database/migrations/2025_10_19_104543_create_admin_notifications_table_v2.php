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
        Schema::create('admin_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان الإشعار
            $table->text('message'); // محتوى الإشعار
            $table->text('email_content')->nullable(); // محتوى الإيميل
            $table->enum('type', ['notification', 'email', 'both'])->default('notification'); // نوع الإرسال
            $table->enum('target_type', ['specific_users', 'user_type', 'all'])->default('specific_users'); // نوع المستهدفين
            $table->json('target_users')->nullable(); // المستخدمين المحددين
            $table->json('target_user_types')->nullable(); // أنواع المستخدمين المستهدفين
            $table->string('priority')->default('normal'); // أولوية الإشعار
            $table->string('category')->nullable(); // فئة الإشعار
            $table->boolean('is_scheduled')->default(false); // هل هو مجدول
            $table->timestamp('scheduled_at')->nullable(); // وقت الإرسال المجدول
            $table->boolean('is_sent')->default(false); // هل تم الإرسال
            $table->timestamp('sent_at')->nullable(); // وقت الإرسال الفعلي
            $table->integer('sent_count')->default(0); // عدد المرسل إليهم
            $table->integer('failed_count')->default(0); // عدد الفاشلين
            $table->json('send_results')->nullable(); // نتائج الإرسال
            $table->unsignedBigInteger('created_by'); // منشئ الإشعار
            $table->timestamps();
            
            $table->index(['type', 'target_type', 'is_sent']);
            $table->index(['scheduled_at', 'is_scheduled']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_notifications');
    }
};