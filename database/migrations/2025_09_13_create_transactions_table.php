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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['income', 'expense'])->comment('نوع المعاملة: إيراد أو مصروف');
            $table->string('category')->comment('فئة المعاملة');
            $table->decimal('amount', 10, 2)->comment('المبلغ');
            $table->text('description')->comment('وصف المعاملة');
            $table->unsignedBigInteger('reference_id')->nullable()->comment('معرف المرجع');
            $table->string('reference_type')->nullable()->comment('نوع المرجع');
            $table->string('payment_method')->nullable()->comment('طريقة الدفع');
            $table->datetime('transaction_date')->comment('تاريخ المعاملة');
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending')->comment('حالة المعاملة');
            $table->unsignedBigInteger('created_by')->nullable()->comment('أنشئت بواسطة');
            $table->text('notes')->nullable()->comment('ملاحظات');
            $table->timestamps();

            // الفهارس
            $table->index(['type', 'status']);
            $table->index(['category', 'type']);
            $table->index(['transaction_date', 'type']);
            $table->index(['reference_id', 'reference_type']);
            
            // المفاتيح الخارجية
            $table->foreign('created_by')->references('id')->on('admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};