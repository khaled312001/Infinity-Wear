<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // Add new columns for Trello-like functionality (only if they don't exist)
            if (!Schema::hasColumn('tasks', 'board_id')) {
                $table->unsignedBigInteger('board_id')->nullable()->after('id');
            }
            if (!Schema::hasColumn('tasks', 'column_status')) {
                $table->string('column_status')->default('todo')->after('status');
            }
            if (!Schema::hasColumn('tasks', 'position')) {
                $table->integer('position')->default(0)->after('column_status');
            }
            if (!Schema::hasColumn('tasks', 'labels')) {
                $table->json('labels')->nullable()->after('position');
            }
            if (!Schema::hasColumn('tasks', 'attachments')) {
                $table->json('attachments')->nullable()->after('labels');
            }
            if (!Schema::hasColumn('tasks', 'checklist')) {
                $table->json('checklist')->nullable()->after('attachments');
            }
            if (!Schema::hasColumn('tasks', 'estimated_hours')) {
                $table->integer('estimated_hours')->nullable()->after('checklist');
            }
            if (!Schema::hasColumn('tasks', 'actual_hours')) {
                $table->integer('actual_hours')->nullable()->after('estimated_hours');
            }
            if (!Schema::hasColumn('tasks', 'started_at')) {
                $table->timestamp('started_at')->nullable()->after('actual_hours');
            }
            if (!Schema::hasColumn('tasks', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('started_at');
            }
            if (!Schema::hasColumn('tasks', 'time_logs')) {
                $table->json('time_logs')->nullable()->after('completed_at');
            }
            if (!Schema::hasColumn('tasks', 'comments')) {
                $table->json('comments')->nullable()->after('time_logs');
            }
            if (!Schema::hasColumn('tasks', 'color')) {
                $table->string('color')->default('#007bff')->after('comments');
            }
            if (!Schema::hasColumn('tasks', 'is_archived')) {
                $table->boolean('is_archived')->default(false)->after('color');
            }
        });

        // Add foreign key constraint and indexes separately
        Schema::table('tasks', function (Blueprint $table) {
            if (!Schema::hasColumn('tasks', 'board_id')) {
                $table->foreign('board_id')->references('id')->on('task_boards')->onDelete('set null');
            }
            
            // Check if index doesn't exist before adding
            $indexExists = false;
            try {
                DB::select("SHOW INDEX FROM tasks WHERE Key_name = 'tasks_board_id_column_status_position_index'");
                $indexExists = true;
            } catch (\Exception $e) {
                $indexExists = false;
            }
            
            if (!$indexExists) {
                $table->index(['board_id', 'column_status', 'position']);
            }
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