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
        Schema::create('push_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // يمكن أن يكون للمدير أو المستخدم
            $table->string('user_type')->default('admin'); // admin, customer, importer, etc.
            $table->string('endpoint'); // Push subscription endpoint
            $table->string('p256dh_key'); // Public key for encryption
            $table->string('auth_key'); // Auth key for encryption
            $table->string('user_agent')->nullable(); // Browser/device info
            $table->string('device_type')->nullable(); // mobile, desktop, tablet
            $table->boolean('is_active')->default(true); // تفعيل/إلغاء الاشتراك
            $table->timestamp('last_used_at')->nullable(); // آخر استخدام
            $table->integer('notification_count')->default(0); // عدد الإشعارات المرسلة
            $table->timestamps();
            
            $table->index(['user_id', 'user_type']);
            $table->index('endpoint');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('push_subscriptions');
    }
};
