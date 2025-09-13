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
        Schema::create('home_sections', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم القسم
            $table->string('title'); // العنوان
            $table->text('subtitle')->nullable(); // العنوان الفرعي
            $table->text('description')->nullable(); // الوصف
            $table->string('background_color')->default('#ffffff'); // لون الخلفية
            $table->string('text_color')->default('#333333'); // لون النص
            $table->string('section_type'); // نوع القسم (services, about, contact, etc.)
            $table->json('settings')->nullable(); // إعدادات إضافية
            $table->integer('order')->default(0); // ترتيب القسم
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_sections');
    }
};