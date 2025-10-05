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
            // Add board_id column
            $table->unsignedBigInteger('board_id')->nullable()->after('id');
            
            // Add other missing columns for Trello-like functionality
            $table->string('column_status')->default('todo')->after('status');
            $table->integer('position')->default(0)->after('column_status');
            $table->json('labels')->nullable()->after('position');
            $table->json('attachments')->nullable()->after('labels');
            $table->json('checklist')->nullable()->after('attachments');
            $table->integer('estimated_hours')->nullable()->after('checklist');
            $table->integer('actual_hours')->nullable()->after('estimated_hours');
            $table->timestamp('started_at')->nullable()->after('actual_hours');
            $table->timestamp('completed_at')->nullable()->after('started_at');
            $table->json('time_logs')->nullable()->after('completed_at');
            $table->json('comments')->nullable()->after('time_logs');
            $table->string('color')->default('#007bff')->after('comments');
            $table->boolean('is_archived')->default(false)->after('color');
        });

        // Add foreign key constraint and indexes
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreign('board_id')->references('id')->on('task_boards')->onDelete('set null');
            $table->index(['board_id', 'column_status', 'position']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['board_id']);
            $table->dropIndex(['board_id', 'column_status', 'position']);
            
            $table->dropColumn([
                'board_id', 'column_status', 'position', 'labels', 'attachments',
                'checklist', 'estimated_hours', 'actual_hours', 'started_at',
                'completed_at', 'time_logs', 'comments', 'color', 'is_archived'
            ]);
        });
    }
};
