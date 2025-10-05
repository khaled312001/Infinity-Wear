<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // For SQLite, we need to recreate the table
        if (DB::getDriverName() === 'sqlite') {
            // Create a new table with the updated schema
            Schema::create('users_new', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->enum('user_type', ['customer', 'admin', 'importer'])->default('customer');
                $table->rememberToken();
                $table->timestamps();
            });

            // Copy data from old table to new table
            DB::statement('INSERT INTO users_new SELECT * FROM users');

            // Drop old table and rename new table
            Schema::drop('users');
            Schema::rename('users_new', 'users');
        } else {
            // For MySQL, use the original approach
            Schema::table('users', function (Blueprint $table) {
                $table->string('user_type')->nullable()->change();
            });

            DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('customer', 'admin', 'importer') NOT NULL DEFAULT 'customer'");
        }
    }

    public function down(): void
    {
        // Revert back to the original enum values
        DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('customer', 'admin') NOT NULL DEFAULT 'customer'");
    }
};