<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Clean up junk rows from blog_posts table that were imported
     * with column misalignment. These rows contain departure data,
     * gear item data, and visual asset data in blog post columns.
     *
     * Root cause: The MySQL-to-SQLite import script had column ordering
     * issues because SQLite ignores ->after() in migrations and appends
     * columns at the end. The fix-blog-posts-import.php script was supposed
     * to correct this but apparently wasn't run or didn't catch all rows.
     *
     * Real blog posts: IDs 1-12 (seeded content)
     * Junk rows: IDs 13+ (departure data, gear items, visual assets, etc.)
     * Test posts: IDs 154, 199, 268 (slug "1", "2", "3" — test data)
     */
    public function up(): void
    {
        // Delete rows where published_at contains non-date data
        // These are departure rows where "Kilimanjaro International Airport (JRO)"
        // ended up in the published_at column
        DB::table('blog_posts')
            ->where('published_at', 'LIKE', 'Kilimanjaro%')
            ->delete();

        // Delete rows where created_at contains non-date data (the "June/July" strings)
        DB::table('blog_posts')
            ->where('created_at', 'LIKE', 'June%')
            ->orWhere('created_at', 'LIKE', 'July%')
            ->delete();

        // Delete rows where slug is a single digit or two digits (departure IDs that became slugs)
        // Matches slugs like "7", "8", "9", "11", "12", "13", "14", "15", "16"
        DB::table('blog_posts')
            ->where('id', '>', 12)
            ->where('slug', 'NOT LIKE', '%-%')
            ->where('slug', 'NOT LIKE', '%.%')
            ->where('slug', 'NOT LIKE', '%\_%')
            ->delete();

        // Delete rows where slug contains dots (visual asset paths like "trekking.routes.umbweEditorial")
        DB::table('blog_posts')
            ->where('slug', 'LIKE', '%.%')
            ->delete();

        // Delete rows where slug contains underscores (migration names, gear item slugs)
        DB::table('blog_posts')
            ->where('slug', 'LIKE', '%\_%')
            ->where('id', '>', 12)
            ->delete();

        // Delete remaining test posts (IDs 154, 199, 268)
        DB::table('blog_posts')
            ->whereIn('id', [154, 199, 268])
            ->delete();

        // Delete any remaining rows with NULL published_at that aren't real posts
        // (gear items, visual assets all have NULL published_at)
        DB::table('blog_posts')
            ->whereNull('published_at')
            ->where('id', '>', 12)
            ->delete();
    }

    /**
     * Reverse the cleanup (restore from backup if needed).
     * Note: This is destructive and data loss is expected.
     * A full re-import from the MySQL dump would be needed to restore.
     */
    public function down(): void
    {
        // No reversal possible — data was junk anyway
        // Re-import from database_dump.sql if needed
    }
};
