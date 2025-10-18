<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Skip this migration if user_type column already exists
        if (Schema::hasColumn('permissions', 'user_type')) {
            return;
        }
        
        Schema::table('permissions', function (Blueprint $table) {
            $table->string('user_type')->nullable()->after('module');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permissions', function (Blueprint $table) {
            $table->dropColumn('user_type');
        });
    }
};
