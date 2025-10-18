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
        Schema::table('tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('board_id')->nullable()->change();
            $table->unsignedBigInteger('column_id')->nullable()->change();
            $table->unsignedBigInteger('assigned_to')->nullable()->change();
            $table->unsignedBigInteger('created_by')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->bigInteger('board_id')->nullable()->change();
            $table->bigInteger('column_id')->nullable()->change();
            $table->bigInteger('assigned_to')->nullable()->change();
            $table->bigInteger('created_by')->change();
        });
    }
};
