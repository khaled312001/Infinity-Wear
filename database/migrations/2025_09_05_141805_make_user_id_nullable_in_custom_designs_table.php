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
        if (Schema::hasTable('custom_designs')) {
            Schema::table('custom_designs', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->foreignId('user_id')->nullable()->change()->constrained()->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('custom_designs')) {
            Schema::table('custom_designs', function (Blueprint $table) {
                $table->dropForeign(['user_id']);
                $table->foreignId('user_id')->nullable(false)->change()->constrained()->onDelete('cascade');
            });
        }
    }
};
