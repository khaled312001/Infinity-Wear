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
            // إضافة قيم افتراضية للأعمدة المطلوبة
            $table->string('column_status')->default('todo')->change();
            $table->integer('position')->default(0)->change();
            $table->integer('importer_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->string('column_status')->nullable()->change();
            $table->integer('position')->nullable()->change();
            $table->integer('importer_id')->nullable(false)->change();
        });
    }
};