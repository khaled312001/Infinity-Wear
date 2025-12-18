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
        // Update the user_type enum to include employee
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('customer', 'admin', 'importer', 'sales', 'marketing', 'employee') NOT NULL DEFAULT 'customer'");
        } elseif (DB::getDriverName() === 'sqlite') {
            // For SQLite, we need to recreate the table
            Schema::create('users_new', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->string('phone')->nullable();
                $table->text('address')->nullable();
                $table->string('city')->nullable();
                $table->enum('user_type', ['customer', 'admin', 'importer', 'sales', 'marketing', 'employee'])->default('customer');
                $table->boolean('is_active')->default(true);
                $table->string('avatar')->nullable();
                $table->text('bio')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });

            // Copy data from old table to new table
            DB::statement('INSERT INTO users_new SELECT * FROM users');

            // Drop old table and rename new table
            Schema::drop('users');
            Schema::rename('users_new', 'users');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE users MODIFY COLUMN user_type ENUM('customer', 'admin', 'importer', 'sales', 'marketing') NOT NULL DEFAULT 'customer'");
        }
        // For SQLite, we can't easily revert this change
    }
};
