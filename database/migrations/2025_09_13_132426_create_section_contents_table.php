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
        Schema::create('section_contents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('home_section_id')->constrained()->onDelete('cascade');
            $table->string('type'); // card, feature, testimonial, etc.
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('icon')->nullable(); // Font Awesome icon class
            $table->string('icon_color')->default('#3b82f6');
            $table->string('button_text')->nullable();
            $table->string('button_url')->nullable();
            $table->json('extra_data')->nullable(); // بيانات إضافية
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('section_contents');
    }
};