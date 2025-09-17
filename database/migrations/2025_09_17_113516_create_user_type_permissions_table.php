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
        Schema::create('user_type_permissions', function (Blueprint $table) {
            $table->id();
            $table->enum('user_type', ['admin', 'importer', 'sales', 'marketing']);
            $table->string('permission');
            $table->timestamps();
            
            $table->unique(['user_type', 'permission']);
            $table->index('user_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_type_permissions');
    }
};
