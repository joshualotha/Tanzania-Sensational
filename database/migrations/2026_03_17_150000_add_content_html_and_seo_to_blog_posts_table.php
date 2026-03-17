<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->longText('content_html')->nullable()->after('content');
            $table->string('meta_title')->nullable()->after('title');
            $table->string('meta_description', 500)->nullable()->after('excerpt');
        });
    }

    public function down(): void
    {
        Schema::table('blog_posts', function (Blueprint $table) {
            $table->dropColumn(['content_html', 'meta_title', 'meta_description']);
        });
    }
};

