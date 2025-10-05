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
        \DB::statement('ALTER TABLE whatsapp_messages CHANGE status_new status ENUM("sent", "delivered", "read", "failed") NOT NULL DEFAULT "sent"');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \DB::statement('ALTER TABLE whatsapp_messages CHANGE status status_new ENUM("sent", "delivered", "read", "failed") NOT NULL DEFAULT "sent"');
    }
};