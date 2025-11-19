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
            if (!Schema::hasColumn('contacts', 'company')) {
                $table->string('company')->nullable()->after('phone');
            }

            // Context/meta fields used by importer contact flow
            if (!Schema::hasColumn('contacts', 'contact_type')) {
                $table->string('contact_type')->nullable()->after('status');
            }
            if (!Schema::hasColumn('contacts', 'assigned_to')) {
                $table->string('assigned_to')->nullable()->after('contact_type');
            }
            if (!Schema::hasColumn('contacts', 'priority')) {
                $table->string('priority')->nullable()->after('assigned_to');
            }
            if (!Schema::hasColumn('contacts', 'source')) {
                $table->string('source')->nullable()->after('priority');
            }
            if (!Schema::hasColumn('contacts', 'tags')) {
                $table->json('tags')->nullable()->after('source');
            }

            // Operational tracking fields
            if (!Schema::hasColumn('contacts', 'follow_up_date')) {
                $table->timestamp('follow_up_date')->nullable()->after('replied_at');
            }
            if (!Schema::hasColumn('contacts', 'last_contact_date')) {
                $table->timestamp('last_contact_date')->nullable()->after('follow_up_date');
            }
            if (!Schema::hasColumn('contacts', 'contact_count')) {
                $table->integer('contact_count')->default(0)->after('last_contact_date');
            }
            if (!Schema::hasColumn('contacts', 'is_archived')) {
                $table->boolean('is_archived')->default(false)->after('contact_count');
            }

            // Request metadata
            if (!Schema::hasColumn('contacts', 'ip_address')) {
                $table->string('ip_address')->nullable()->after('admin_notes');
            }
            if (!Schema::hasColumn('contacts', 'user_agent')) {
                $table->text('user_agent')->nullable()->after('ip_address');
            }

            // Audit
            if (!Schema::hasColumn('contacts', 'created_by')) {
                $table->foreignId('created_by')->nullable()->after('user_agent')->constrained('users')->nullOnDelete();
            }
            if (!Schema::hasColumn('contacts', 'updated_by')) {
                $table->foreignId('updated_by')->nullable()->after('created_by')->constrained('users')->nullOnDelete();
            }
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


