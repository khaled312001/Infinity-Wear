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
            $table->string('title');
            $table->string('subtitle', 500)->nullable();
            $table->text('description')->nullable();
            $table->enum('content_type', ['text', 'image', 'video', 'icon', 'button', 'card', 'testimonial'])->default('card');
            $table->string('image')->nullable();
            $table->string('video_url')->nullable();
            $table->string('icon_class', 100)->nullable();
            $table->string('button_text', 100)->nullable();
            $table->string('button_link', 500)->nullable();
            $table->enum('button_style', ['primary', 'secondary', 'outline', 'link'])->default('primary');
            $table->json('custom_data')->nullable();
            $table->integer('sort_order')->default(0);
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