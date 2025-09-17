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
        // First, update existing customers to be importers
        DB::table('users')->where('user_type', 'customer')->update(['user_type' => 'importer']);
        
        // Then update the enum to include new roles
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('admin', 'importer', 'sales', 'marketing') NOT NULL DEFAULT 'importer'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('customer', 'admin', 'importer') NOT NULL DEFAULT 'customer'");
    }
};
