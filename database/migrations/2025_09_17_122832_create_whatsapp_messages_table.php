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
        Schema::create('whatsapp_messages', function (Blueprint $table) {
            $table->id();
            $table->string('message_id')->unique(); // معرف الرسالة من الواتساب
            $table->string('from_number'); // رقم المرسل
            $table->string('to_number'); // رقم المستقبل
            $table->string('contact_name')->nullable(); // اسم جهة الاتصال
            $table->text('message_content'); // محتوى الرسالة
            $table->enum('message_type', ['text', 'image', 'document', 'audio', 'video'])->default('text');
            $table->enum('direction', ['inbound', 'outbound']); // اتجاه الرسالة
            $table->enum('status', ['sent', 'delivered', 'read', 'failed'])->default('sent');
            $table->timestamp('sent_at'); // وقت الإرسال
            $table->timestamp('delivered_at')->nullable(); // وقت التسليم
            $table->timestamp('read_at')->nullable(); // وقت القراءة
            $table->json('media_url')->nullable(); // روابط الملفات المرفقة
            $table->foreignId('sent_by')->nullable()->constrained('admins')->onDelete('set null'); // من أرسل الرسالة
            $table->foreignId('contact_id')->nullable()->constrained('users')->onDelete('set null'); // معرف جهة الاتصال في النظام
            $table->enum('contact_type', ['importer', 'marketing', 'sales', 'customer', 'external'])->default('external');
            $table->boolean('is_archived')->default(false); // هل الرسالة مؤرشفة
            $table->timestamps();
            
            // فهارس لتحسين الأداء
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
        Schema::dropIfExists('whatsapp_messages');
    }
};