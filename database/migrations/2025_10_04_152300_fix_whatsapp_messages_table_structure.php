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
        // First, add the missing columns
        Schema::table('whatsapp_messages', function (Blueprint $table) {
            $table->string('message_id')->unique()->nullable()->after('id');
            $table->string('from_number')->nullable()->after('message_id');
            $table->string('to_number')->nullable()->after('from_number');
            $table->string('contact_name')->nullable()->after('to_number');
            $table->text('message_content')->nullable()->after('contact_name');
            $table->enum('message_type', ['text', 'image', 'document', 'audio', 'video'])->default('text')->after('message_content');
            $table->enum('direction', ['inbound', 'outbound'])->nullable()->after('message_type');
            $table->timestamp('delivered_at')->nullable()->after('sent_at');
            $table->timestamp('read_at')->nullable()->after('delivered_at');
            $table->json('media_url')->nullable()->after('read_at');
            $table->foreignId('sent_by')->nullable()->constrained('admins')->onDelete('set null')->after('media_url');
            $table->foreignId('contact_id')->nullable()->constrained('users')->onDelete('set null')->after('sent_by');
            $table->enum('contact_type', ['importer', 'marketing', 'sales', 'customer', 'external'])->default('external')->after('contact_id');
            $table->boolean('is_archived')->default(false)->after('contact_type');
        });

        // Migrate existing data to new structure
        $this->migrateExistingData();

        // Add indexes
        Schema::table('whatsapp_messages', function (Blueprint $table) {
            $table->index(['from_number', 'to_number']);
            $table->index(['contact_type', 'contact_id']);
            $table->index(['sent_by', 'direction']);
            $table->index('sent_at');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('whatsapp_messages', function (Blueprint $table) {
            // Drop indexes
            $table->dropIndex(['from_number', 'to_number']);
            $table->dropIndex(['contact_type', 'contact_id']);
            $table->dropIndex(['sent_by', 'direction']);
            $table->dropIndex(['sent_at']);
            $table->dropIndex(['status']);

            // Drop new columns
            $table->dropColumn([
                'message_id', 'from_number', 'to_number', 'contact_name', 
                'message_content', 'message_type', 'direction',
                'delivered_at', 'read_at', 'media_url', 'sent_by', 
                'contact_id', 'contact_type', 'is_archived'
            ]);
        });
    }

    /**
     * Migrate existing data to new structure
     */
    private function migrateExistingData(): void
    {
        $messages = \DB::table('whatsapp_messages')->get();
        
        foreach ($messages as $message) {
            \DB::table('whatsapp_messages')
                ->where('id', $message->id)
                ->update([
                    'message_id' => 'legacy_' . $message->id,
                    'from_number' => $message->type === 'incoming' ? $message->phone_number : 'system',
                    'to_number' => $message->type === 'outgoing' ? $message->phone_number : 'system',
                    'message_content' => $message->message,
                    'direction' => $message->type === 'incoming' ? 'inbound' : 'outbound',
                    'contact_type' => 'external',
                    'is_archived' => false,
                ]);
        }
    }
};