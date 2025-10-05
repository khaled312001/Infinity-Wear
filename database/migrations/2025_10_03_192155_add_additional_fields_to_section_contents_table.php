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
        Schema::table('section_contents', function (Blueprint $table) {
            if (!Schema::hasColumn('section_contents', 'icon_class')) {
                $table->string('icon_class')->nullable()->after('content');
            }
            if (!Schema::hasColumn('section_contents', 'button_text')) {
                $table->string('button_text')->nullable()->after('icon_class');
            }
            if (!Schema::hasColumn('section_contents', 'button_link')) {
                $table->string('button_link')->nullable()->after('button_text');
            }
            if (!Schema::hasColumn('section_contents', 'link_text')) {
                $table->string('link_text')->nullable()->after('button_link');
            }
            if (!Schema::hasColumn('section_contents', 'link_url')) {
                $table->string('link_url')->nullable()->after('link_text');
            }
            if (!Schema::hasColumn('section_contents', 'custom_data')) {
                $table->text('custom_data')->nullable()->after('link_url');
            }
            if (!Schema::hasColumn('section_contents', 'content_type')) {
                $table->string('content_type')->nullable()->after('custom_data');
            }
            if (!Schema::hasColumn('section_contents', 'button_style')) {
                $table->string('button_style')->nullable()->after('content_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('section_contents', function (Blueprint $table) {
            $table->dropColumn(['icon_class', 'button_text', 'button_link', 'link_text', 'link_url', 'custom_data', 'content_type', 'button_style']);
        });
    }
};
