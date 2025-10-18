<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaskBoard;
use App\Models\TaskColumn;
use App\Models\TaskCard;

class TaskBoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // إنشاء لوحة المهام الرئيسية
        $board = TaskBoard::create([
            'name' => 'لوحة المهام الرئيسية',
            'description' => 'لوحة المهام العامة للمشروع',
            'type' => 'general',
            'created_by' => 1,
            'color' => '#007bff',
            'icon' => 'fas fa-tasks',
            'is_active' => true,
            'sort_order' => 1
        ]);

        // إنشاء الأعمدة
        $columns = [
            [
                'name' => 'قائمة المهام',
                'description' => 'المهام الجديدة والمعلقة',
                'color' => '#6c757d',
                'icon' => 'fas fa-list',
                'sort_order' => 1
            ],
            [
                'name' => 'قيد التنفيذ',
                'description' => 'المهام قيد العمل',
                'color' => '#007bff',
                'icon' => 'fas fa-play',
                'sort_order' => 2
            ],
            [
                'name' => 'مكتملة',
                'description' => 'المهام المنجزة',
                'color' => '#28a745',
                'icon' => 'fas fa-check',
                'sort_order' => 3
            ]
        ];

        foreach ($columns as $columnData) {
            $column = TaskColumn::create(array_merge($columnData, [
                'board_id' => $board->id,
                'is_active' => true
            ]));

            // إضافة بعض المهام التجريبية
            if ($column->name === 'قائمة المهام') {
                TaskCard::create([
                    'title' => 'مهمة تجريبية 1',
                    'description' => 'هذه مهمة تجريبية للاختبار',
                    'board_id' => $board->id,
                    'column_id' => $column->id,
                    'priority' => 'high',
                    'status' => 'pending',
                    'created_by' => 1,
                    'created_by_type' => 'admin',
                    'sort_order' => 1,
                    'department' => 'general',
                    'column_status' => 'pending',
                    'position' => 1
                ]);
            } elseif ($column->name === 'قيد التنفيذ') {
                TaskCard::create([
                    'title' => 'مهمة تجريبية 2',
                    'description' => 'هذه مهمة قيد التنفيذ',
                    'board_id' => $board->id,
                    'column_id' => $column->id,
                    'priority' => 'medium',
                    'status' => 'in_progress',
                    'created_by' => 1,
                    'created_by_type' => 'admin',
                    'sort_order' => 1,
                    'department' => 'general',
                    'column_status' => 'in_progress',
                    'position' => 1
                ]);
            } elseif ($column->name === 'مكتملة') {
                TaskCard::create([
                    'title' => 'مهمة تجريبية 3',
                    'description' => 'هذه مهمة مكتملة',
                    'board_id' => $board->id,
                    'column_id' => $column->id,
                    'priority' => 'low',
                    'status' => 'completed',
                    'created_by' => 1,
                    'created_by_type' => 'admin',
                    'sort_order' => 1,
                    'department' => 'general',
                    'column_status' => 'completed',
                    'position' => 1
                ]);
            }
        }
    }
}