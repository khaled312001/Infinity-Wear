<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;
use App\Models\Admin;
use App\Models\Importer;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        // الحصول على المسؤولين والمستوردين
        $admins = Admin::all();
        $importers = Importer::all();
        
        if ($admins->count() > 0 && $importers->count() > 0) {
            // مهمة لفريق المبيعات
            Task::create([
                'title' => 'التواصل مع مستورد جديد',
                'description' => 'التواصل مع المستورد الجديد لمناقشة احتياجاته',
                'priority' => 'high',
                'status' => 'pending',
                'due_date' => now()->addDays(2),
                'assigned_to' => $admins->where('email', 'sales.manager@infinitywear.sa')->first()->id ?? $admins->first()->id,
                'created_by' => $admins->where('email', 'admin@infinitywear.sa')->first()->id ?? $admins->first()->id,
                'importer_id' => $importers->first()->id,
                'department' => 'sales'
            ]);
            
            // مهمة لفريق التسويق
            Task::create([
                'title' => 'إنشاء حملة تسويقية',
                'description' => 'إنشاء حملة تسويقية للمنتجات الجديدة',
                'priority' => 'medium',
                'status' => 'pending',
                'due_date' => now()->addDays(5),
                'assigned_to' => $admins->where('email', 'marketing.manager@infinitywear.sa')->first()->id ?? $admins->first()->id,
                'created_by' => $admins->where('email', 'admin@infinitywear.sa')->first()->id ?? $admins->first()->id,
                'department' => 'marketing'
            ]);
            
            // مهمة أخرى لفريق المبيعات
            Task::create([
                'title' => 'متابعة طلب مستورد',
                'description' => 'متابعة طلب المستورد وتحديث حالته',
                'priority' => 'medium',
                'status' => 'in_progress',
                'due_date' => now()->addDays(1),
                'assigned_to' => $admins->where('email', 'sales.rep@infinitywear.sa')->first()->id ?? $admins->first()->id,
                'created_by' => $admins->where('email', 'sales.manager@infinitywear.sa')->first()->id ?? $admins->first()->id,
                'importer_id' => $importers->skip(1)->first()->id ?? $importers->first()->id,
                'department' => 'sales'
            ]);
        }
    }
}