<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create businesses table
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('business_name');
            $table->string('business_type');
            $table->string('business_type_other')->nullable();
            $table->text('address');
            $table->string('city');
            $table->string('country');
            $table->string('website')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Create designs table
        Schema::create('designs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('business_id');
            $table->string('design_option');
            $table->string('business_type');
            $table->json('clothing_pieces');
            $table->json('sizes');
            $table->json('colors');
            $table->json('patterns')->nullable();
            $table->json('logos')->nullable();
            $table->json('texts')->nullable();
            $table->text('design_notes')->nullable();
            $table->enum('priority', ['normal', 'high', 'urgent'])->default('normal');
            $table->enum('delivery_preference', ['standard', 'fast', 'express'])->default('standard');
            $table->json('requirements')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();
            
            $table->foreign('business_id')->references('id')->on('businesses')->onDelete('cascade');
        });

        // Create design_3d_data table
        Schema::create('design_3d_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('design_id');
            $table->json('model_data')->nullable();
            $table->json('camera_position')->nullable();
            $table->json('lighting_settings')->nullable();
            $table->json('render_settings')->nullable();
            $table->timestamps();
            
            $table->foreign('design_id')->references('id')->on('designs')->onDelete('cascade');
        });

        // Create design_files table
        Schema::create('design_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('design_id');
            $table->enum('file_type', ['logo', 'license', 'additional']);
            $table->string('file_path');
            $table->string('original_name');
            $table->bigInteger('file_size');
            $table->string('mime_type');
            $table->timestamps();
            
            $table->foreign('design_id')->references('id')->on('designs')->onDelete('cascade');
        });

        // Create order_summaries table
        Schema::create('order_summaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('design_id');
            $table->integer('total_pieces');
            $table->integer('total_varieties');
            $table->decimal('estimated_cost', 10, 2);
            $table->integer('estimated_delivery_days');
            $table->timestamps();
            
            $table->foreign('design_id')->references('id')->on('designs')->onDelete('cascade');
        });

        // Create design_metadata table
        Schema::create('design_metadata', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('design_id');
            $table->timestamp('created_at_timestamp');
            $table->text('user_agent');
            $table->string('screen_resolution');
            $table->string('form_version');
            $table->boolean('design_complete');
            $table->boolean('notes_complete');
            $table->timestamps();
            
            $table->foreign('design_id')->references('id')->on('designs')->onDelete('cascade');
        });

        // Create design_progress table for tracking progress
        Schema::create('design_progress', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('design_id');
            $table->string('step');
            $table->text('notes')->nullable();
            $table->json('data')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
            
            $table->foreign('design_id')->references('id')->on('designs')->onDelete('cascade');
        });

        // Create design_communications table for messages
        Schema::create('design_communications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('design_id');
            $table->enum('type', ['message', 'update', 'question', 'response']);
            $table->text('content');
            $table->string('sender_type')->default('user'); // user, admin, system
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->boolean('is_read')->default(false);
            $table->timestamps();
            
            $table->foreign('design_id')->references('id')->on('designs')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('design_communications');
        Schema::dropIfExists('design_progress');
        Schema::dropIfExists('design_metadata');
        Schema::dropIfExists('order_summaries');
        Schema::dropIfExists('design_files');
        Schema::dropIfExists('design_3d_data');
        Schema::dropIfExists('designs');
        Schema::dropIfExists('businesses');
    }
};
