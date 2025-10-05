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
        Schema::table('task_boards', function (Blueprint $table) {
            $table->enum('type', ['marketing', 'sales', 'general'])->default('general')->after('description');
            $table->integer('sort_order')->default(0)->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('task_boards', function (Blueprint $table) {
            $table->dropColumn(['type', 'sort_order']);
        });
    }
};
