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
        // Add missing columns that the model expects
        Schema::table('content_management', function (Blueprint $table) {
            $table->string('page_name')->nullable()->after('id');
            $table->string('section_name')->nullable()->after('page_name');
            $table->string('content_type')->default('text')->after('section_name');
            $table->string('title_ar')->nullable()->after('content_type');
            $table->string('title_en')->nullable()->after('title_ar');
            $table->text('content_ar')->nullable()->after('title_en');
            $table->text('content_en')->nullable()->after('content_ar');
            $table->text('description_ar')->nullable()->after('content_en');
            $table->text('description_en')->nullable()->after('description_ar');
            $table->string('image_path')->nullable()->after('description_en');
            $table->json('gallery_images')->nullable()->after('image_path');
            $table->string('video_url')->nullable()->after('gallery_images');
            $table->string('button_text_ar')->nullable()->after('video_url');
            $table->string('button_text_en')->nullable()->after('button_text_ar');
            $table->string('button_url')->nullable()->after('button_text_en');
            $table->integer('sort_order')->default(0)->after('button_url');
            $table->boolean('is_active')->default(true)->after('sort_order');
            $table->boolean('is_featured')->default(false)->after('is_active');
        });

        // Migrate existing data to new structure
        $this->migrateExistingData();

        // Add indexes
        Schema::table('content_management', function (Blueprint $table) {
            $table->index(['page_name', 'section_name']);
            $table->index(['content_type', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('content_management', function (Blueprint $table) {
            // Drop indexes
            $table->dropIndex(['page_name', 'section_name']);
            $table->dropIndex(['content_type', 'is_active']);

            // Drop new columns
            $table->dropColumn([
                'page_name', 'section_name', 'content_type', 'title_ar', 'title_en',
                'content_ar', 'content_en', 'description_ar', 'description_en',
                'image_path', 'gallery_images', 'video_url', 'button_text_ar',
                'button_text_en', 'button_url', 'sort_order', 'is_active', 'is_featured'
            ]);
        });
    }

    /**
     * Migrate existing data to new structure
     */
    private function migrateExistingData(): void
    {
        $contents = \DB::table('content_management')->get();
        
        foreach ($contents as $content) {
            \DB::table('content_management')
                ->where('id', $content->id)
                ->update([
                    'page_name' => 'legacy',
                    'section_name' => 'general',
                    'content_type' => $content->type ?? 'text',
                    'title_ar' => $content->title,
                    'title_en' => $content->title,
                    'content_ar' => $content->content,
                    'content_en' => $content->content,
                    'is_active' => $content->status === 'active' ? true : false,
                    'sort_order' => 0,
                ]);
        }
    }
};