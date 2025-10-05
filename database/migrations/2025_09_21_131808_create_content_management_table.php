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
        Schema::create('content_management', function (Blueprint $table) {
            $table->id();
            $table->string('page_name'); // اسم الصفحة
            $table->string('section_name'); // اسم القسم
            $table->string('content_type')->default('text'); // نوع المحتوى (text, image, video, gallery)
            $table->string('title_ar')->nullable(); // العنوان بالعربية
            $table->string('title_en')->nullable(); // العنوان بالإنجليزية
            $table->text('content_ar')->nullable(); // المحتوى بالعربية
            $table->text('content_en')->nullable(); // المحتوى بالإنجليزية
            $table->text('description_ar')->nullable(); // الوصف بالعربية
            $table->text('description_en')->nullable(); // الوصف بالإنجليزية
            $table->string('image_path')->nullable(); // مسار الصورة
            $table->json('gallery_images')->nullable(); // معرض الصور
            $table->string('video_url')->nullable(); // رابط الفيديو
            $table->string('button_text_ar')->nullable(); // نص الزر بالعربية
            $table->string('button_text_en')->nullable(); // نص الزر بالإنجليزية
            $table->string('button_url')->nullable(); // رابط الزر
            $table->integer('sort_order')->default(0); // ترتيب العرض
            $table->boolean('is_active')->default(true); // حالة النشاط
            $table->boolean('is_featured')->default(false); // مميز
            $table->json('meta_data')->nullable(); // بيانات إضافية
            $table->timestamps();
            
            // فهارس للبحث السريع
            $table->index(['page_name', 'section_name']);
            $table->index(['content_type', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('content_management');
    }
};
