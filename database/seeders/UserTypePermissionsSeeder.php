<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTypePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing permissions
        DB::table('user_type_permissions')->truncate();

        // Define permissions for each user type based on actual sidebar pages
        $permissions = [
            'admin' => [
                'dashboard', 'notifications', 'contacts', 'whatsapp',
                'services_management', 'portfolio_management', 'testimonials_management',
                'importers_management', 'importers_orders', 'tasks_management',
                'finance_dashboard', 'finance_transactions', 'finance_reports',
                'marketing_team_management', 'sales_team_management', 'customer_notes',
                'marketing_reports', 'reports', 'settings', 'permissions_management', 'admins_management', 'profile'
            ],
            'importer' => [
                'dashboard', 'orders', 'tracking', 'invoices',
                'profile', 'payment_methods', 'notifications',
                'help', 'support', 'contact'
            ],
            'sales' => [
                'dashboard', 'orders', 'importer_orders', 'importers',
                'tasks', 'contacts', 'reports', 'profile'
            ],
            'marketing' => [
                'dashboard', 'portfolio', 'testimonials', 'tasks',
                'contacts', 'profile'
            ]
        ];

        // Insert permissions
        foreach ($permissions as $userType => $userPermissions) {
            foreach ($userPermissions as $permission) {
                DB::table('user_type_permissions')->insert([
                    'user_type' => $userType,
                    'permission' => $permission,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        $this->command->info('User type permissions seeded successfully!');
    }
}
