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
        Schema::create('company_plans', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان الخطة
            $table->text('description')->nullable(); // وصف الخطة
            $table->enum('type', ['quarterly', 'semi_annual', 'annual']); // نوع الخطة
            $table->enum('status', ['draft', 'active', 'completed', 'cancelled'])->default('draft'); // حالة الخطة
            $table->date('start_date'); // تاريخ البداية
            $table->date('end_date'); // تاريخ النهاية
            $table->json('objectives'); // الأهداف (JSON)
            $table->json('strengths'); // نقاط القوة (JSON)
            $table->json('weaknesses'); // نقاط الضعف (JSON)
            $table->json('opportunities'); // الفرص (JSON)
            $table->json('threats'); // التهديدات (JSON)
            $table->json('strategies'); // الاستراتيجيات (JSON)
            $table->json('action_items'); // عناصر العمل (JSON)
            $table->decimal('budget', 15, 2)->nullable(); // الميزانية
            $table->decimal('actual_cost', 15, 2)->nullable(); // التكلفة الفعلية
            $table->integer('progress_percentage')->default(0); // نسبة التقدم
            $table->text('notes')->nullable(); // ملاحظات
            $table->foreignId('created_by')->constrained('admins'); // منشئ الخطة
            $table->foreignId('assigned_to')->nullable()->constrained('admins'); // المسؤول عن الخطة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_plans');
    }
};
