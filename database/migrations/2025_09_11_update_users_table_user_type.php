<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // First, modify the column to allow NULL values temporarily
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_type')->nullable()->change();
        });

        // Then update the enum values using a raw SQL statement
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('customer', 'admin', 'importer') NOT NULL DEFAULT 'customer'");
    }

    public function down(): void
    {
        // Revert back to the original enum values
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('customer', 'admin') NOT NULL DEFAULT 'customer'");
    }
};