<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');
            $table->date('due_date')->nullable();
            $table->foreignId('assigned_to')->nullable()->constrained('admins')->onDelete('set null');
            $table->foreignId('created_by')->constrained('admins')->onDelete('cascade');
            $table->foreignId('importer_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('department', ['admin', 'marketing', 'sales'])->default('admin');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};