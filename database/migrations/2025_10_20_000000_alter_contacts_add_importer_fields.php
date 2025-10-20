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
        Schema::table('contacts', function (Blueprint $table) {
            // Basic additional info
            $table->string('company')->nullable()->after('phone');

            // Context/meta fields used by importer contact flow
            $table->string('contact_type')->nullable()->after('status');
            $table->string('assigned_to')->nullable()->after('contact_type');
            $table->string('priority')->nullable()->after('assigned_to');
            $table->string('source')->nullable()->after('priority');
            $table->json('tags')->nullable()->after('source');

            // Operational tracking fields
            $table->timestamp('follow_up_date')->nullable()->after('replied_at');
            $table->timestamp('last_contact_date')->nullable()->after('follow_up_date');
            $table->integer('contact_count')->default(0)->after('last_contact_date');
            $table->boolean('is_archived')->default(false)->after('contact_count');

            // Request metadata
            $table->string('ip_address')->nullable()->after('admin_notes');
            $table->text('user_agent')->nullable()->after('ip_address');

            // Audit
            $table->foreignId('created_by')->nullable()->after('user_agent')->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->after('created_by')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            // Drop in reverse order of creation to satisfy FKs
            $table->dropConstrainedForeignId('updated_by');
            $table->dropConstrainedForeignId('created_by');

            $table->dropColumn([
                'user_agent',
                'ip_address',
                'is_archived',
                'contact_count',
                'last_contact_date',
                'follow_up_date',
                'tags',
                'source',
                'priority',
                'assigned_to',
                'contact_type',
                'company',
            ]);
        });
    }
};


