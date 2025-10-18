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
        Schema::create('marketing_reports', function (Blueprint $table) {
            $table->id();
            
            // معلومات المندوب
            $table->string('representative_name');
            
            // معلومات الجهة
            $table->string('company_name');
            $table->json('company_images')->nullable(); // صور المكان
            $table->text('company_address'); // عنوان الجهة التفصيلي
            $table->enum('company_activity', [
                'sports_academy',
                'school', 
                'institution_company',
                'wholesale_store',
                'retail_store',
                'other'
            ]); // نشاط الجهة
            
            // معلومات المسئول
            $table->string('responsible_name'); // اسم المسئول
            $table->string('responsible_phone'); // رقم الجوال
            $table->string('responsible_position'); // المنصب
            
            // تفاصيل الزيارة
            $table->enum('visit_type', [
                'office_visit',
                'phone_call', 
                'whatsapp'
            ]); // نوع الزيارة
            
            $table->enum('agreement_status', [
                'agreed',
                'rejected',
                'needs_time'
            ]); // حالة الاتفاق
            
            $table->json('customer_concerns')->nullable(); // مخاوف العميل
            $table->string('target_quantity'); // الكمية المستهدفة
            $table->string('annual_consumption'); // الاستهلاك السنوي
            
            // التوصيات والخطوات
            $table->text('recommendations')->nullable(); // توصيات مقترحة وملاحظات
            $table->text('next_steps')->nullable(); // الخطوات اللاحقة
            
            // معلومات إضافية
            $table->unsignedBigInteger('created_by'); // منشئ التقرير
            $table->enum('status', [
                'pending',
                'approved', 
                'rejected',
                'under_review'
            ])->default('pending'); // حالة التقرير
            $table->text('notes')->nullable(); // ملاحظات إضافية
            
            $table->timestamps();
            $table->softDeletes();
            
            // Foreign keys - commented out for now due to constraint issues
            // $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            
            // Indexes
            $table->index(['representative_name', 'created_at']);
            $table->index(['company_name']);
            $table->index(['agreement_status']);
            $table->index(['visit_type']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marketing_reports');
    }
};
