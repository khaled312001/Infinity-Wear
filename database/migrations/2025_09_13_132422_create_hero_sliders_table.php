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
        Schema::create('hero_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle', 500)->nullable();
            $table->text('description')->nullable();
            $table->string('image');
            $table->string('button_text', 100)->nullable();
            $table->string('button_link', 500)->nullable();
            $table->string('text_color', 7)->default('#ffffff');
            $table->decimal('overlay_opacity', 3, 2)->default(0.5);
            $table->enum('animation_type', ['fade', 'slide', 'zoom'])->default('fade');
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
        Schema::dropIfExists('hero_sliders');
    }
};