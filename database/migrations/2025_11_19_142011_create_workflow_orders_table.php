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
        // Check if required tables exist
        if (!Schema::hasTable('importers') || !Schema::hasTable('users')) {
            throw new \Exception('Required tables (importers, users) must exist before creating workflow_orders table');
        }

        // Skip if tables already exist
        if (Schema::hasTable('workflow_orders')) {
            return;
        }

        Schema::create('workflow_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->unsignedBigInteger('importer_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
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
            $table->unsignedBigInteger('marketing_user_id')->nullable();
            $table->unsignedBigInteger('sales_user_id')->nullable();
            $table->unsignedBigInteger('design_user_id')->nullable();
            $table->unsignedBigInteger('first_sample_user_id')->nullable();
            $table->unsignedBigInteger('work_approval_user_id')->nullable();
            $table->unsignedBigInteger('manufacturing_user_id')->nullable();
            $table->unsignedBigInteger('shipping_user_id')->nullable();
            $table->unsignedBigInteger('receipt_delivery_user_id')->nullable();
            $table->unsignedBigInteger('collection_user_id')->nullable();
            $table->unsignedBigInteger('after_sales_user_id')->nullable();
            
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

        // Add foreign key constraints after table creation
        Schema::table('workflow_orders', function (Blueprint $table) {
            if (Schema::hasTable('importers')) {
                $table->foreign('importer_id')->references('id')->on('importers')->onDelete('set null');
            }
            if (Schema::hasTable('users')) {
                $table->foreign('customer_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('marketing_user_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('sales_user_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('design_user_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('first_sample_user_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('work_approval_user_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('manufacturing_user_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('shipping_user_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('receipt_delivery_user_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('collection_user_id')->references('id')->on('users')->onDelete('set null');
                $table->foreign('after_sales_user_id')->references('id')->on('users')->onDelete('set null');
            }
        });
        
        // Create workflow_order_stages table for detailed stage tracking
        if (!Schema::hasTable('workflow_order_stages')) {
            Schema::create('workflow_order_stages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('workflow_order_id');
            $table->string('stage_name'); // marketing, sales, design, etc.
            $table->enum('status', ['pending', 'in_progress', 'completed', 'rejected'])->default('pending');
            $table->unsignedBigInteger('assigned_user_id')->nullable();
            $table->text('notes')->nullable();
            $table->json('attachments')->nullable(); // For files/images
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
            
            $table->index(['workflow_order_id', 'stage_name']);
            });

            // Add foreign key constraints for workflow_order_stages
            Schema::table('workflow_order_stages', function (Blueprint $table) {
                // Check if foreign key doesn't already exist
                $connection = Schema::getConnection();
                $databaseName = $connection->getDatabaseName();
                $fkExists = $connection->select(
                    "SELECT COUNT(*) as count FROM information_schema.table_constraints 
                     WHERE constraint_schema = ? AND table_name = 'workflow_order_stages' 
                     AND constraint_name = 'workflow_order_stages_workflow_order_id_foreign'",
                    [$databaseName]
                );
                
                if ($fkExists[0]->count == 0) {
                    $table->foreign('workflow_order_id')->references('id')->on('workflow_orders')->onDelete('cascade');
                }
                
                if (Schema::hasTable('users')) {
                    $fkUserExists = $connection->select(
                        "SELECT COUNT(*) as count FROM information_schema.table_constraints 
                         WHERE constraint_schema = ? AND table_name = 'workflow_order_stages' 
                         AND constraint_name = 'workflow_order_stages_assigned_user_id_foreign'",
                        [$databaseName]
                    );
                    
                    if ($fkUserExists[0]->count == 0) {
                        $table->foreign('assigned_user_id')->references('id')->on('users')->onDelete('set null');
                    }
                }
            });
        }

        // Add foreign key constraints for workflow_orders if they don't exist
        if (Schema::hasTable('workflow_orders')) {
            $connection = Schema::getConnection();
            $databaseName = $connection->getDatabaseName();
            
            Schema::table('workflow_orders', function (Blueprint $table) use ($connection, $databaseName) {
                // Check and add foreign keys only if they don't exist
                $foreignKeys = [
                    'importer_id' => 'workflow_orders_importer_id_foreign',
                    'customer_id' => 'workflow_orders_customer_id_foreign',
                    'marketing_user_id' => 'workflow_orders_marketing_user_id_foreign',
                    'sales_user_id' => 'workflow_orders_sales_user_id_foreign',
                    'design_user_id' => 'workflow_orders_design_user_id_foreign',
                    'first_sample_user_id' => 'workflow_orders_first_sample_user_id_foreign',
                    'work_approval_user_id' => 'workflow_orders_work_approval_user_id_foreign',
                    'manufacturing_user_id' => 'workflow_orders_manufacturing_user_id_foreign',
                    'shipping_user_id' => 'workflow_orders_shipping_user_id_foreign',
                    'receipt_delivery_user_id' => 'workflow_orders_receipt_delivery_user_id_foreign',
                    'collection_user_id' => 'workflow_orders_collection_user_id_foreign',
                    'after_sales_user_id' => 'workflow_orders_after_sales_user_id_foreign',
                ];

                foreach ($foreignKeys as $column => $constraintName) {
                    $fkExists = $connection->select(
                        "SELECT COUNT(*) as count FROM information_schema.table_constraints 
                         WHERE constraint_schema = ? AND table_name = 'workflow_orders' 
                         AND constraint_name = ?",
                        [$databaseName, $constraintName]
                    );
                    
                    if ($fkExists[0]->count == 0) {
                        if ($column === 'importer_id' && Schema::hasTable('importers')) {
                            $table->foreign($column)->references('id')->on('importers')->onDelete('set null');
                        } elseif ($column !== 'importer_id' && Schema::hasTable('users')) {
                            $table->foreign($column)->references('id')->on('users')->onDelete('set null');
                        }
                    }
                }
            });
        }
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
