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
        // حذف اللوحات المكررة واللوحات الفارغة
        $boards = DB::table('task_boards')->get();
        
        echo "عدد اللوحات قبل التنظيف: " . $boards->count() . PHP_EOL;
        
        // حذف اللوحات الفارغة (بدون أعمدة)
        $emptyBoards = DB::table('task_boards')
            ->whereNotIn('id', function($query) {
                $query->select('board_id')
                    ->from('task_columns');
            })
            ->get();
        
        foreach ($emptyBoards as $board) {
            echo "حذف اللوحة الفارغة: {$board->name}" . PHP_EOL;
            DB::table('task_boards')->where('id', $board->id)->delete();
        }
        
        // حذف اللوحات المكررة (نفس الاسم)
        $duplicateBoards = DB::table('task_boards')
            ->select('name', DB::raw('COUNT(*) as count'))
            ->groupBy('name')
            ->having('count', '>', 1)
            ->get();
        
        foreach ($duplicateBoards as $duplicate) {
            echo "حذف اللوحات المكررة: {$duplicate->name}" . PHP_EOL;
            
            // الاحتفاظ بأحدث لوحة فقط
            $boardsToKeep = DB::table('task_boards')
                ->where('name', $duplicate->name)
                ->orderBy('created_at', 'desc')
                ->first();
            
            // حذف باقي اللوحات المكررة
            $boardsToDelete = DB::table('task_boards')
                ->where('name', $duplicate->name)
                ->where('id', '!=', $boardsToKeep->id)
                ->get();
            
            foreach ($boardsToDelete as $board) {
                // حذف المهام المرتبطة
                DB::table('tasks')->where('board_id', $board->id)->delete();
                
                // حذف الأعمدة المرتبطة
                DB::table('task_columns')->where('board_id', $board->id)->delete();
                
                // حذف اللوحة
                DB::table('task_boards')->where('id', $board->id)->delete();
            }
        }
        
        // التأكد من وجود لوحة واحدة فقط مع 3 أعمدة
        $remainingBoards = DB::table('task_boards')->count();
        echo "عدد اللوحات بعد التنظيف: " . $remainingBoards . PHP_EOL;
        
        if ($remainingBoards == 0) {
            // إنشاء لوحة جديدة مع 3 أعمدة
            $boardId = DB::table('task_boards')->insertGetId([
                'name' => 'لوحة المهام الرئيسية',
                'description' => 'لوحة المهام العامة للمشروع',
                'type' => 'general',
                'created_by' => 1,
                'color' => '#007bff',
                'icon' => 'fas fa-tasks',
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            // إنشاء 3 أعمدة
            $columns = [
                ['name' => 'قائمة المهام', 'description' => 'المهام الجديدة والمعلقة', 'color' => '#6c757d', 'icon' => 'fas fa-list', 'sort_order' => 1],
                ['name' => 'قيد التنفيذ', 'description' => 'المهام قيد العمل', 'color' => '#007bff', 'icon' => 'fas fa-play', 'sort_order' => 2],
                ['name' => 'مكتملة', 'description' => 'المهام المنجزة', 'color' => '#28a745', 'icon' => 'fas fa-check', 'sort_order' => 3]
            ];
            
            foreach ($columns as $column) {
                DB::table('task_columns')->insert(array_merge($column, [
                    'board_id' => $boardId,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now()
                ]));
            }
            
            echo "تم إنشاء لوحة جديدة مع 3 أعمدة" . PHP_EOL;
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // لا يمكن عكس هذا التغيير
    }
};