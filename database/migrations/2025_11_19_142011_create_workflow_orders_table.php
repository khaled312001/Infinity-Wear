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
        Schema::create('workflow_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('importer_id')->nullable()->constrained('importers')->onDelete('set null');
            $table->foreignId('customer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->text('customer_address')->nullable();
            
            // Order Details
            $table->text('requirements')->nullable();
            $table->integer('quantity')->default(1);
            $table->json('design_details')->nullable();
            $table->decimal('estimated_cost', 12, 2)->nullable();
            $table->decimal('final_cost', 12, 2)->nullable();
            
            // Stage Statuses
            $table->enum('marketing_status', ['pending', 'in_progress', 'completed', 'rejected'])->default('pending');
            $table->enum('sales_status', ['pending', 'in_progress', 'completed', 'rejected'])->default('pending');
            $table->enum('design_status', ['pending', 'in_progress', 'completed', 'rejected'])->default('pending');
            $table->enum('first_sample_status', ['pending', 'in_progress', 'completed', 'rejected'])->default('pending');
            $table->enum('work_approval_status', ['pending', 'in_progress', 'approved', 'rejected'])->default('pending');
            $table->enum('manufacturing_status', ['pending', 'in_progress', 'completed', 'rejected'])->default('pending');
            $table->enum('shipping_status', ['pending', 'in_progress', 'completed', 'rejected'])->default('pending');
            $table->enum('receipt_delivery_status', ['pending', 'in_progress', 'completed', 'rejected'])->default('pending');
            $table->enum('collection_status', ['pending', 'in_progress', 'completed', 'rejected'])->default('pending');
            $table->enum('after_sales_status', ['pending', 'in_progress', 'completed', 'rejected'])->default('pending');
            
            // Assigned Users for each stage
            $table->foreignId('marketing_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('sales_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('design_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('first_sample_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('work_approval_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('manufacturing_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('shipping_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('receipt_delivery_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('collection_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('after_sales_user_id')->nullable()->constrained('users')->onDelete('set null');
            
            // Stage Dates
            $table->timestamp('marketing_started_at')->nullable();
            $table->timestamp('marketing_completed_at')->nullable();
            $table->timestamp('sales_started_at')->nullable();
            $table->timestamp('sales_completed_at')->nullable();
            $table->timestamp('design_started_at')->nullable();
            $table->timestamp('design_completed_at')->nullable();
            $table->timestamp('first_sample_started_at')->nullable();
            $table->timestamp('first_sample_completed_at')->nullable();
            $table->timestamp('work_approval_started_at')->nullable();
            $table->timestamp('work_approval_completed_at')->nullable();
            $table->timestamp('manufacturing_started_at')->nullable();
            $table->timestamp('manufacturing_completed_at')->nullable();
            $table->timestamp('shipping_started_at')->nullable();
            $table->timestamp('shipping_completed_at')->nullable();
            $table->timestamp('receipt_delivery_started_at')->nullable();
            $table->timestamp('receipt_delivery_completed_at')->nullable();
            $table->timestamp('collection_started_at')->nullable();
            $table->timestamp('collection_completed_at')->nullable();
            $table->timestamp('after_sales_started_at')->nullable();
            $table->timestamp('after_sales_completed_at')->nullable();
            
            // General
            $table->enum('overall_status', ['new', 'in_progress', 'completed', 'cancelled'])->default('new');
            $table->text('notes')->nullable();
            $table->date('expected_delivery_date')->nullable();
            $table->date('actual_delivery_date')->nullable();
            $table->string('tracking_number')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
        
        // Create workflow_order_stages table for detailed stage tracking
        Schema::create('workflow_order_stages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workflow_order_id')->constrained()->onDelete('cascade');
            $table->string('stage_name'); // marketing, sales, design, etc.
            $table->enum('status', ['pending', 'in_progress', 'completed', 'rejected'])->default('pending');
            $table->foreignId('assigned_user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->text('notes')->nullable();
            $table->json('attachments')->nullable(); // For files/images
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            
            $table->index(['workflow_order_id', 'stage_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_order_stages');
        Schema::dropIfExists('workflow_orders');
    }
};
