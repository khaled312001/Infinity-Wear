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
        Schema::create('customer_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('added_by')->constrained('admins')->onDelete('cascade');
            $table->enum('note_type', ['marketing', 'sales', 'general'])->default('general');
            $table->string('title');
            $table->text('content');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->enum('status', ['active', 'archived', 'deleted'])->default('active');
            $table->json('tags')->nullable(); // للتصنيفات الإضافية
            $table->timestamp('follow_up_date')->nullable(); // تاريخ المتابعة
            $table->timestamps();
            
            // فهارس لتحسين الأداء
            $table->index(['customer_id', 'note_type']);
            $table->index(['added_by', 'note_type']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_notes');
    }
};
