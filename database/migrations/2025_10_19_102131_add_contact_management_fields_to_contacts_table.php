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
            $table->enum('contact_type', ['inquiry', 'custom'])->default('inquiry')->after('user_agent');
            $table->enum('assigned_to', ['marketing', 'sales', 'both'])->nullable()->after('contact_type');
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium')->after('assigned_to');
            $table->enum('source', ['website', 'phone', 'email', 'referral'])->default('website')->after('priority');
            $table->json('tags')->nullable()->after('source');
            $table->timestamp('follow_up_date')->nullable()->after('tags');
            $table->timestamp('last_contact_date')->nullable()->after('follow_up_date');
            $table->integer('contact_count')->default(0)->after('last_contact_date');
            $table->boolean('is_archived')->default(false)->after('contact_count');
            $table->unsignedBigInteger('created_by')->nullable()->after('is_archived');
            $table->unsignedBigInteger('updated_by')->nullable()->after('created_by');
            
            // Add indexes for better performance
            $table->index(['contact_type', 'assigned_to']);
            $table->index(['priority', 'status']);
            $table->index(['is_archived', 'created_at']);
            $table->index('follow_up_date');
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
