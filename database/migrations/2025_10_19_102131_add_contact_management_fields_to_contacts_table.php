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
            if (!Schema::hasColumn('contacts', 'contact_type')) {
                $table->enum('contact_type', ['inquiry', 'custom'])->default('inquiry')->after('user_agent');
            }
            if (!Schema::hasColumn('contacts', 'assigned_to')) {
                $table->enum('assigned_to', ['marketing', 'sales', 'both'])->nullable()->after('contact_type');
            }
            if (!Schema::hasColumn('contacts', 'priority')) {
                $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->after('assigned_to');
            }
            if (!Schema::hasColumn('contacts', 'source')) {
                $table->enum('source', ['website', 'phone', 'email', 'referral'])->default('website')->after('priority');
            }
            if (!Schema::hasColumn('contacts', 'tags')) {
                $table->json('tags')->nullable()->after('source');
            }
            if (!Schema::hasColumn('contacts', 'follow_up_date')) {
                $table->timestamp('follow_up_date')->nullable()->after('tags');
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
            if (!Schema::hasColumn('contacts', 'created_by')) {
                $table->unsignedBigInteger('created_by')->nullable()->after('is_archived');
            }
            if (!Schema::hasColumn('contacts', 'updated_by')) {
                $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            }
            
            // Add indexes for better performance (skip if columns don't exist)
            try {
                if (Schema::hasColumn('contacts', 'contact_type') && Schema::hasColumn('contacts', 'assigned_to')) {
                    $table->index(['contact_type', 'assigned_to']);
                }
                if (Schema::hasColumn('contacts', 'priority') && Schema::hasColumn('contacts', 'status')) {
                    $table->index(['priority', 'status']);
                }
                if (Schema::hasColumn('contacts', 'is_archived') && Schema::hasColumn('contacts', 'created_at')) {
                    $table->index(['is_archived', 'created_at']);
                }
                if (Schema::hasColumn('contacts', 'follow_up_date')) {
                    $table->index('follow_up_date');
                }
            } catch (\Exception $e) {
                // Indexes might already exist, skip silently
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropIndex(['contact_type', 'assigned_to']);
            $table->dropIndex(['priority', 'status']);
            $table->dropIndex(['is_archived', 'created_at']);
            $table->dropIndex('follow_up_date');
            
            $table->dropColumn([
                'contact_type',
                'assigned_to',
                'priority',
                'source',
                'tags',
                'follow_up_date',
                'last_contact_date',
                'contact_count',
                'is_archived',
                'created_by',
                'updated_by'
            ]);
        });
    }
};
