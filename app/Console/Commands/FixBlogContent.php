<?php

namespace App\Console\Commands;

use App\Models\BlogPost;
use Database\Seeders\BlogPostsSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class FixBlogContent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'blog:fix-content';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix blog post content_html to use the unique content from BlogPostsSeeder instead of the generic packing list template';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $seeder = new BlogPostsSeeder();

        // Use reflection to access private post methods
        $reflection = new \ReflectionClass($seeder);

        $postMethods = [];
        for ($i = 1; $i <= 12; $i++) {
            $methodName = "post{$i}";
            if ($reflection->hasMethod($methodName)) {
                $method = $reflection->getMethod($methodName);
                $method->setAccessible(true);
                $postMethods[$i] = $method->invoke($seeder);
            }
        }

        // Map slugs to post method indices
        $slugMap = [
            'kilimanjaro-packing-list-what-actually-matters' => 1,
            'lemosho-vs-machame-choosing-your-route' => 2,
            'altitude-acclimatization-a-practical-guide' => 3,
            'what-a-kilimanjaro-day-looks-like-on-the-mountain' => 4,
            'safari-after-the-summit-best-pairings' => 5,
            'zanzibar-the-perfect-recovery-itinerary' => 6,
            'training-for-kilimanjaro-8-weeks-no-guesswork' => 7,
            'how-to-tip-on-kilimanjaro-simple-breakdown' => 8,
            'the-5-ecological-zones-of-kilimanjaro' => 9,
            'why-group-departures-work-and-when-they-dont' => 10,
            'moshi-arrival-hotels-and-what-to-expect' => 11,
            'common-mistakes-first-time-trekkers-make' => 12,
        ];

        $updated = 0;
        $errors = 0;

        foreach ($slugMap as $slug => $postIndex) {
            $post = BlogPost::where('slug', $slug)->first();

            if (!$post) {
                $this->error("Post not found for slug: {$slug}");
                $errors++;
                continue;
            }

            $correctContent = $postMethods[$postIndex] ?? null;

            if (!$correctContent) {
                $this->error("No content found for post index: {$postIndex}");
                $errors++;
                continue;
            }

            // Check if content is already correct (has the post's unique H2)
            $currentContent = $post->content_html ?? '';

            // Each post has a unique H2 heading - check if it matches
            $expectedHeading = $this->getExpectedHeading($postIndex);
            $hasCorrectContent = $expectedHeading && str_contains($currentContent, $expectedHeading);

            if ($hasCorrectContent) {
                $this->info("✓ Post '{$post->title}' already has correct content. Skipping.");
                continue;
            }

            $post->content_html = $correctContent;
            $post->save();

            $this->info("✓ Updated post '{$post->title}' with correct content (" . strlen($correctContent) . " chars)");
            $updated++;
        }

        $this->newLine();
        $this->info("Done. {$updated} posts updated, {$errors} errors.");

        return Command::SUCCESS;
    }

    /**
     * Get a unique heading from each post to check if content is already correct.
     */
    private function getExpectedHeading(int $postIndex): ?string
    {
        $headings = [
            1 => 'The Layering System',
            2 => 'Lemosho Route Overview',
            3 => 'What Happens to Your Body at Altitude',
            4 => 'Morning: 6:00 AM',
            5 => 'Combine Kilimanjaro with the Ultimate Safari Experience',
            6 => '5-Day Zanzibar Recovery Itinerary',
            7 => '8-Week Training Plan for Kilimanjaro',
            8 => 'Why Tipping Matters',
            9 => 'The 5 Ecological Zones of Kilimanjaro',
            10 => 'Group Departures vs Private Climbs',
            11 => 'Getting to Moshi',
            12 => '10 Common Mistakes First-Time Kilimanjaro Trekkers Make',
        ];

        return $headings[$postIndex] ?? null;
    }
}
