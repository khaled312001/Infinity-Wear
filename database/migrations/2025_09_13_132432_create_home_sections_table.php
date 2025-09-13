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
            $table->string('name');
            $table->string('title')->nullable();
            $table->string('subtitle', 500)->nullable();
            $table->text('description')->nullable();
            $table->enum('section_type', ['hero', 'services', 'features', 'about', 'portfolio', 'testimonials', 'contact', 'custom'])->default('custom');
            $table->enum('layout_type', ['full_width', 'container', 'grid_2', 'grid_3', 'grid_4', 'carousel'])->default('container');
            $table->string('background_color', 7)->nullable();
            $table->string('background_image')->nullable();
            $table->string('text_color', 7)->nullable();
            $table->text('custom_css')->nullable();
            $table->text('custom_js')->nullable();
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
        Schema::dropIfExists('home_sections');
    }
};