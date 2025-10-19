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
        // Add VAPID keys to notification_settings table
        Schema::table('notification_settings', function (Blueprint $table) {
            $table->text('vapid_public_key')->nullable()->after('email_template_customization');
            $table->text('vapid_private_key')->nullable()->after('vapid_public_key');
            $table->string('vapid_subject')->default('mailto:admin@infinitywear.com')->after('vapid_private_key');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notification_settings', function (Blueprint $table) {
            $table->dropColumn(['vapid_public_key', 'vapid_private_key', 'vapid_subject']);
        });
    }
};
