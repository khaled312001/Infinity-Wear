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
        // Set the database timezone to Asia/Riyadh (+03:00)
        DB::statement("SET time_zone = '+03:00'");
        
        // Update all timestamp fields in all tables to use the new timezone
        $tables = [
            'users' => ['created_at', 'updated_at', 'email_verified_at'],
            'password_reset_tokens' => ['created_at'],
            'admins' => ['created_at', 'updated_at', 'email_verified_at'],
            'orders' => ['created_at', 'updated_at'],
            'order_items' => ['created_at', 'updated_at'],
            'categories' => ['created_at', 'updated_at'],
            'settings' => ['created_at', 'updated_at'],
            'importers' => ['created_at', 'updated_at'],
            'marketing_team' => ['created_at', 'updated_at'],
            'sales_team' => ['created_at', 'updated_at'],
            'tasks' => ['created_at', 'updated_at'],
            'importer_orders' => ['created_at', 'updated_at'],
            'portfolio_items' => ['created_at', 'updated_at'],
            'testimonials' => ['created_at', 'updated_at'],
            'hero_sliders' => ['created_at', 'updated_at'],
            'home_sections' => ['created_at', 'updated_at'],
            'section_contents' => ['created_at', 'updated_at'],
            'transactions' => ['created_at', 'updated_at'],
            'company_plans' => ['created_at', 'updated_at'],
            'user_type_permissions' => ['created_at', 'updated_at'],
            'task_boards' => ['created_at', 'updated_at'],
            'customer_notes' => ['created_at', 'updated_at'],
            'whatsapp_messages' => ['created_at', 'updated_at', 'sent_at', 'delivered_at', 'read_at'],
            'contacts' => ['created_at', 'updated_at'],
            'roles' => ['created_at', 'updated_at'],
            'permissions' => ['created_at', 'updated_at'],
            'employees' => ['created_at', 'updated_at'],
            'role_permissions' => ['created_at', 'updated_at'],
            'user_roles' => ['created_at', 'updated_at'],
            'user_permissions' => ['created_at', 'updated_at'],
            'admin_roles' => ['created_at', 'updated_at'],
            'admin_permissions' => ['created_at', 'updated_at'],
            'employee_roles' => ['created_at', 'updated_at'],
            'employee_permissions' => ['created_at', 'updated_at'],
            'content_management' => ['created_at', 'updated_at'],
            'notifications' => ['created_at', 'updated_at', 'read_at', 'archived_at'],
            'services' => ['created_at', 'updated_at'],
        ];

        foreach ($tables as $table => $columns) {
            if (Schema::hasTable($table)) {
                foreach ($columns as $column) {
                    if (Schema::hasColumn($table, $column)) {
                        // Convert existing timestamps from UTC to Asia/Riyadh timezone
                        DB::statement("
                            UPDATE {$table} 
                            SET {$column} = CONVERT_TZ({$column}, '+00:00', '+03:00') 
                            WHERE {$column} IS NOT NULL
                        ");
                    }
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Set the database timezone back to UTC
        DB::statement("SET time_zone = '+00:00'");
        
        // Convert all timestamps back from Asia/Riyadh to UTC
        $tables = [
            'users' => ['created_at', 'updated_at', 'email_verified_at'],
            'password_reset_tokens' => ['created_at'],
            'admins' => ['created_at', 'updated_at', 'email_verified_at'],
            'orders' => ['created_at', 'updated_at'],
            'order_items' => ['created_at', 'updated_at'],
            'categories' => ['created_at', 'updated_at'],
            'settings' => ['created_at', 'updated_at'],
            'importers' => ['created_at', 'updated_at'],
            'marketing_team' => ['created_at', 'updated_at'],
            'sales_team' => ['created_at', 'updated_at'],
            'tasks' => ['created_at', 'updated_at'],
            'importer_orders' => ['created_at', 'updated_at'],
            'portfolio_items' => ['created_at', 'updated_at'],
            'testimonials' => ['created_at', 'updated_at'],
            'hero_sliders' => ['created_at', 'updated_at'],
            'home_sections' => ['created_at', 'updated_at'],
            'section_contents' => ['created_at', 'updated_at'],
            'transactions' => ['created_at', 'updated_at'],
            'company_plans' => ['created_at', 'updated_at'],
            'user_type_permissions' => ['created_at', 'updated_at'],
            'task_boards' => ['created_at', 'updated_at'],
            'customer_notes' => ['created_at', 'updated_at'],
            'whatsapp_messages' => ['created_at', 'updated_at', 'sent_at', 'delivered_at', 'read_at'],
            'contacts' => ['created_at', 'updated_at'],
            'roles' => ['created_at', 'updated_at'],
            'permissions' => ['created_at', 'updated_at'],
            'employees' => ['created_at', 'updated_at'],
            'role_permissions' => ['created_at', 'updated_at'],
            'user_roles' => ['created_at', 'updated_at'],
            'user_permissions' => ['created_at', 'updated_at'],
            'admin_roles' => ['created_at', 'updated_at'],
            'admin_permissions' => ['created_at', 'updated_at'],
            'employee_roles' => ['created_at', 'updated_at'],
            'employee_permissions' => ['created_at', 'updated_at'],
            'content_management' => ['created_at', 'updated_at'],
            'notifications' => ['created_at', 'updated_at', 'read_at', 'archived_at'],
            'services' => ['created_at', 'updated_at'],
        ];

        foreach ($tables as $table => $columns) {
            if (Schema::hasTable($table)) {
                foreach ($columns as $column) {
                    if (Schema::hasColumn($table, $column)) {
                        // Convert existing timestamps from Asia/Riyadh back to UTC
                        DB::statement("
                            UPDATE {$table} 
                            SET {$column} = CONVERT_TZ({$column}, '+03:00', '+00:00') 
                            WHERE {$column} IS NOT NULL
                        ");
                    }
                }
            }
        }
    }
};
