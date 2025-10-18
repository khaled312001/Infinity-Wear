<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaskBoard;
use App\Models\TaskColumn;
use App\Models\TaskCard;

class AddMoreSampleTasks extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // جلب اللوحة الرئيسية
        $board = TaskBoard::first();
        
        if (!$board) {
            echo "لا توجد لوحة مهام!" . PHP_EOL;
            return;
        }
        
        // جلب الأعمدة
        $columns = $board->columns()->orderBy('sort_order')->get();
        
        if ($columns->count() < 3) {
            echo "لا توجد 3 أعمدة!" . PHP_EOL;
            return;
        }
        
        $todoColumn = $columns[0]; // قائمة المهام
        $inProgressColumn = $columns[1]; // قيد التنفيذ
        $completedColumn = $columns[2]; // مكتملة
        
        // إضافة مهام جديدة لقائمة المهام
        $todoTasks = [
            [
                'title' => 'تصميم واجهة المستخدم',
                'description' => 'إنشاء تصميم احترافي لواجهة إدارة المهام',
                'priority' => 'high',
                'status' => 'pending',
                'department' => 'general',
                'column_status' => 'pending',
                'position' => 1,
                'color' => '#007bff',
                'labels' => json_encode([
                    ['name' => 'تصميم', 'color' => '#007bff'],
                    ['name' => 'واجهة', 'color' => '#28a745']
                ]),
                'attachments' => json_encode([]),
                'checklist' => json_encode([
                    ['text' => 'إنشاء mockups', 'completed' => false],
                    ['text' => 'اختيار الألوان', 'completed' => false],
                    ['text' => 'تطبيق التصميم', 'completed' => false]
                ]),
                'time_logs' => json_encode([]),
                'comments' => json_encode([]),
                'tags' => json_encode(['ui', 'design', 'frontend']),
                'custom_fields' => json_encode([]),
                'is_archived' => false,
                'is_urgent' => false,
                'progress_percentage' => 0,
                'estimated_hours' => 8,
                'actual_hours' => 0
            ],
            [
                'title' => 'تطوير API للمهام',
                'description' => 'إنشاء API endpoints لإدارة المهام',
                'priority' => 'medium',
                'status' => 'pending',
                'department' => 'general',
                'column_status' => 'pending',
                'position' => 2,
                'color' => '#6c757d',
                'labels' => json_encode([
                    ['name' => 'تطوير', 'color' => '#6c757d'],
                    ['name' => 'API', 'color' => '#ffc107']
                ]),
                'attachments' => json_encode([]),
                'checklist' => json_encode([
                    ['text' => 'تصميم endpoints', 'completed' => false],
                    ['text' => 'تطبيق CRUD operations', 'completed' => false],
                    ['text' => 'إضافة validation', 'completed' => false],
                    ['text' => 'كتابة tests', 'completed' => false]
                ]),
                'time_logs' => json_encode([]),
                'comments' => json_encode([]),
                'tags' => json_encode(['api', 'backend', 'development']),
                'custom_fields' => json_encode([]),
                'is_archived' => false,
                'is_urgent' => false,
                'progress_percentage' => 0,
                'estimated_hours' => 12,
                'actual_hours' => 0
            ]
        ];
        
        // إضافة مهام جديدة لقيد التنفيذ
        $inProgressTasks = [
            [
                'title' => 'إعداد قاعدة البيانات',
                'description' => 'إنشاء جداول قاعدة البيانات للمهام',
                'priority' => 'high',
                'status' => 'in_progress',
                'department' => 'general',
                'column_status' => 'in_progress',
                'position' => 1,
                'color' => '#007bff',
                'labels' => json_encode([
                    ['name' => 'قاعدة بيانات', 'color' => '#007bff'],
                    ['name' => 'إعداد', 'color' => '#28a745']
                ]),
                'attachments' => json_encode([]),
                'checklist' => json_encode([
                    ['text' => 'إنشاء migrations', 'completed' => true],
                    ['text' => 'إضافة foreign keys', 'completed' => true],
                    ['text' => 'إنشاء seeders', 'completed' => false],
                    ['text' => 'اختبار البيانات', 'completed' => false]
                ]),
                'time_logs' => json_encode([]),
                'comments' => json_encode([]),
                'tags' => json_encode(['database', 'migration', 'setup']),
                'custom_fields' => json_encode([]),
                'is_archived' => false,
                'is_urgent' => false,
                'progress_percentage' => 50,
                'estimated_hours' => 6,
                'actual_hours' => 3
            ]
        ];
        
        // إضافة مهام جديدة للمكتملة
        $completedTasks = [
            [
                'title' => 'تثبيت Laravel',
                'description' => 'تثبيت Laravel framework للمشروع',
                'priority' => 'low',
                'status' => 'completed',
                'department' => 'general',
                'column_status' => 'completed',
                'position' => 1,
                'color' => '#28a745',
                'labels' => json_encode([
                    ['name' => 'Laravel', 'color' => '#dc3545'],
                    ['name' => 'تثبيت', 'color' => '#28a745']
                ]),
                'attachments' => json_encode([]),
                'checklist' => json_encode([
                    ['text' => 'تحميل Laravel', 'completed' => true],
                    ['text' => 'تثبيت dependencies', 'completed' => true],
                    ['text' => 'إعداد البيئة', 'completed' => true],
                    ['text' => 'اختبار التثبيت', 'completed' => true]
                ]),
                'time_logs' => json_encode([]),
                'comments' => json_encode([]),
                'tags' => json_encode(['laravel', 'setup', 'installation']),
                'custom_fields' => json_encode([]),
                'is_archived' => false,
                'is_urgent' => false,
                'progress_percentage' => 100,
                'estimated_hours' => 2,
                'actual_hours' => 2,
                'completed_at' => now()->subDays(2)
            ]
        ];
        
        // إضافة المهام
        foreach ($todoTasks as $taskData) {
            TaskCard::create(array_merge($taskData, [
                'board_id' => $board->id,
                'column_id' => $todoColumn->id,
                'created_by' => 1,
                'created_by_type' => 'admin'
            ]));
        }
        
        foreach ($inProgressTasks as $taskData) {
            TaskCard::create(array_merge($taskData, [
                'board_id' => $board->id,
                'column_id' => $inProgressColumn->id,
                'created_by' => 1,
                'created_by_type' => 'admin'
            ]));
        }
        
        foreach ($completedTasks as $taskData) {
            TaskCard::create(array_merge($taskData, [
                'board_id' => $board->id,
                'column_id' => $completedColumn->id,
                'created_by' => 1,
                'created_by_type' => 'admin'
            ]));
        }
        
        echo "تم إضافة المهام التجريبية بنجاح!" . PHP_EOL;
    }
}