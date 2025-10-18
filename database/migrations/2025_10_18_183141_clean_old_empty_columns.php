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
        // حذف الأعمدة الفارغة القديمة وترك آخر 3 أعمدة فقط
        $boards = DB::table('task_boards')->get();
        
        foreach ($boards as $board) {
            // جلب جميع أعمدة اللوحة مرتبة حسب sort_order
            $columns = DB::table('task_columns')
                ->where('board_id', $board->id)
                ->orderBy('sort_order')
                ->get();
            
            echo "لوحة: {$board->name} - عدد الأعمدة: " . $columns->count() . PHP_EOL;
            
            if ($columns->count() > 3) {
                // حذف الأعمدة القديمة وترك آخر 3
                $columnsToDelete = $columns->take($columns->count() - 3);
                
                foreach ($columnsToDelete as $column) {
                    echo "حذف العمود: {$column->name}" . PHP_EOL;
                    
                    // حذف المهام المرتبطة بالعمود
                    DB::table('tasks')->where('column_id', $column->id)->delete();
                    
                    // حذف العمود
                    DB::table('task_columns')->where('id', $column->id)->delete();
                }
                
                // إعادة ترقيم الأعمدة المتبقية
                $remainingColumns = DB::table('task_columns')
                    ->where('board_id', $board->id)
                    ->orderBy('sort_order')
                    ->get();
                
                foreach ($remainingColumns as $index => $column) {
                    DB::table('task_columns')
                        ->where('id', $column->id)
                        ->update(['sort_order' => $index + 1]);
                }
            }
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