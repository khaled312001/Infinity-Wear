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
        Schema::table('tasks', function (Blueprint $table) {
            // إضافة الأعمدة المفقودة
            $table->unsignedBigInteger('column_id')->nullable()->after('board_id');
            $table->enum('assigned_to_type', ['admin', 'marketing', 'sales'])->nullable()->after('assigned_to');
            $table->enum('created_by_type', ['admin', 'marketing', 'sales'])->default('admin')->after('created_by');
            $table->integer('sort_order')->default(0)->after('position');
            $table->datetime('start_date')->nullable()->after('due_date');
            $table->json('tags')->nullable()->after('labels');
            $table->integer('progress_percentage')->default(0)->after('actual_hours');
            $table->json('custom_fields')->nullable()->after('progress_percentage');
            $table->boolean('is_urgent')->default(false)->after('is_archived');
            
            // تغيير أنواع الأعمدة
            $table->enum('priority', ['low', 'medium', 'high', 'urgent', 'critical'])->default('medium')->change();
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled', 'on_hold'])->default('pending')->change();
            $table->datetime('due_date')->nullable()->change();
            $table->decimal('estimated_hours', 8, 2)->nullable()->change();
            $table->decimal('actual_hours', 8, 2)->default(0)->change();
            $table->json('labels')->nullable()->change();
            $table->json('attachments')->nullable()->change();
            $table->json('checklist')->nullable()->change();
            $table->json('time_logs')->nullable()->change();
            $table->json('comments')->nullable()->change();
            $table->boolean('is_archived')->default(false)->change();
            
            // إضافة الفهارس
            $table->index(['column_id']);
            $table->index(['assigned_to', 'assigned_to_type']);
            $table->index(['created_by', 'created_by_type']);
            $table->index(['status', 'due_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn(['column_id', 'assigned_to_type', 'created_by_type', 'sort_order', 'start_date', 'tags', 'progress_percentage', 'custom_fields', 'is_urgent']);
            $table->dropIndex(['column_id']);
            $table->dropIndex(['assigned_to', 'assigned_to_type']);
            $table->dropIndex(['created_by', 'created_by_type']);
            $table->dropIndex(['status', 'due_date']);
        });
    }
};
