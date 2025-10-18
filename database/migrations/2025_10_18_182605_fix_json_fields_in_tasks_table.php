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
        // إصلاح البيانات الموجودة في جدول tasks
        $tasks = DB::table('tasks')->get();
        
        foreach ($tasks as $task) {
            $updates = [];
            
            // إصلاح checklist
            if ($task->checklist && is_string($task->checklist)) {
                $checklist = json_decode($task->checklist, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $updates['checklist'] = json_encode($checklist);
                } else {
                    $updates['checklist'] = json_encode([]);
                }
            }
            
            // إصلاح labels
            if ($task->labels && is_string($task->labels)) {
                $labels = json_decode($task->labels, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $updates['labels'] = json_encode($labels);
                } else {
                    $updates['labels'] = json_encode([]);
                }
            }
            
            // إصلاح attachments
            if ($task->attachments && is_string($task->attachments)) {
                $attachments = json_decode($task->attachments, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $updates['attachments'] = json_encode($attachments);
                } else {
                    $updates['attachments'] = json_encode([]);
                }
            }
            
            // إصلاح time_logs
            if ($task->time_logs && is_string($task->time_logs)) {
                $timeLogs = json_decode($task->time_logs, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $updates['time_logs'] = json_encode($timeLogs);
                } else {
                    $updates['time_logs'] = json_encode([]);
                }
            }
            
            // إصلاح comments
            if ($task->comments && is_string($task->comments)) {
                $comments = json_decode($task->comments, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $updates['comments'] = json_encode($comments);
                } else {
                    $updates['comments'] = json_encode([]);
                }
            }
            
            // إصلاح tags
            if ($task->tags && is_string($task->tags)) {
                $tags = json_decode($task->tags, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $updates['tags'] = json_encode($tags);
                } else {
                    $updates['tags'] = json_encode([]);
                }
            }
            
            // إصلاح custom_fields
            if ($task->custom_fields && is_string($task->custom_fields)) {
                $customFields = json_decode($task->custom_fields, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $updates['custom_fields'] = json_encode($customFields);
                } else {
                    $updates['custom_fields'] = json_encode([]);
                }
            }
            
            // تحديث السجل إذا كان هناك تغييرات
            if (!empty($updates)) {
                DB::table('tasks')->where('id', $task->id)->update($updates);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // لا حاجة لعكس هذا التغيير
    }
};