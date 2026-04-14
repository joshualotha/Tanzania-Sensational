<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogPostsSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Kilimanjaro Packing List: What Actually Matters',
                'category' => 'Preparation',
                'hero_image' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1600&q=80',
            ],
            [
                'title' => 'Lemosho vs Machame: Choosing Your Route',
                'category' => 'Routes',
                'hero_image' => 'https://images.unsplash.com/photo-1542362567-b07e54358753?auto=format&fit=crop&w=1600&q=80',
            ],
            [
                'title' => 'Altitude Acclimatization: A Practical Guide',
                'category' => 'Health & Safety',
                'hero_image' => 'https://images.unsplash.com/photo-1469474968028-56623f02e42e?auto=format&fit=crop&w=1600&q=80',
            ],
            [
                'title' => 'What a Kilimanjaro Day Looks Like on the Mountain',
                'category' => 'On the Trek',
                'hero_image' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1600&q=80',
            ],
            [
                'title' => 'Safari After the Summit: Best Pairings',
                'category' => 'Safari',
                'hero_image' => 'https://images.unsplash.com/photo-1508672019048-805c876b67e2?auto=format&fit=crop&w=1600&q=80',
            ],
            [
                'title' => 'Zanzibar: The Perfect Recovery Itinerary',
                'category' => 'Zanzibar',
                'hero_image' => 'https://images.unsplash.com/photo-1500375592092-40eb2168fd21?auto=format&fit=crop&w=1600&q=80',
            ],
            [
                'title' => 'Training for Kilimanjaro: 8 Weeks, No Guesswork',
                'category' => 'Preparation',
                'hero_image' => 'https://images.unsplash.com/photo-1517836357463-d25dfeac3438?auto=format&fit=crop&w=1600&q=80',
            ],
            [
                'title' => 'How to Tip on Kilimanjaro (Simple Breakdown)',
                'category' => 'Preparation',
                'hero_image' => 'https://images.unsplash.com/photo-1520975958225-3f61d2c4ca0b?auto=format&fit=crop&w=1600&q=80',
            ],
            [
                'title' => 'The 5 Ecological Zones of Kilimanjaro',
                'category' => 'Kilimanjaro',
                'hero_image' => 'https://images.unsplash.com/photo-1501785888041-af3ef285b470?auto=format&fit=crop&w=1600&q=80',
            ],
            [
                'title' => 'Why Group Departures Work (and When They Don’t)',
                'category' => 'Planning',
                'hero_image' => 'https://images.unsplash.com/photo-1488646953014-85cb44e25828?auto=format&fit=crop&w=1600&q=80',
            ],
            [
                'title' => 'Moshi: Arrival, Hotels, and What to Expect',
                'category' => 'Planning',
                'hero_image' => 'https://images.unsplash.com/photo-1528127269322-539801943592?auto=format&fit=crop&w=1600&q=80',
            ],
            [
                'title' => 'Common Mistakes First-Time Trekkers Make',
                'category' => 'Health & Safety',
                'hero_image' => 'https://images.unsplash.com/photo-1470071459604-3b5ec3a7fe05?auto=format&fit=crop&w=1600&q=80',
            ],
        ];

        foreach ($posts as $p) {
            $slug = Str::slug($p['title']);

            BlogPost::updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $p['title'],
                    'meta_title' => $p['title'] . ' | Tanzania Sensational',
                    'excerpt' => 'A practical, field-tested guide from our team in Tanzania, designed to help you plan with confidence.',
                    'meta_description' => 'Read expert trekking and safari guidance from Tanzania Sensational. Planning tips, route insights, and on-the-ground advice.',
                    'author' => 'Tanzania Sensational',
                    'category' => $p['category'],
                    'hero_image' => $p['hero_image'],
                    'content_html' => $this->sampleHtml($p['title']),
                    'published_at' => now()->subDays(rand(1, 180)),
                ]
            );
        }
    }

    private function sampleHtml(string $title): string
    {
        return <<<HTML
<p><strong>{$title}</strong> is one of the most common topics we’re asked about. This guide focuses on the practical choices that affect comfort, safety, and summit success.</p>
<h2>Quick takeaways</h2>
<ul>
  <li>Plan for changing conditions: sun, rain, wind, and cold can happen in one day.</li>
  <li>Prioritize fit and layering over brand names.</li>
  <li>Slow is smooth, smooth is fast, acclimatization is everything.</li>
</ul>
<h2>What we recommend</h2>
<p>Use a simple system: moisture-wicking base layers, an insulating mid-layer, and a weather shell. Bring the essentials, skip the clutter, and keep your daypack organized.</p>
<blockquote>“If you’re warm, hydrated, and moving at the right pace, Kilimanjaro becomes a joy instead of a grind.”</blockquote>
<p>If you’d like help choosing a route and date, send a booking request, we’ll confirm details and arrange payment offline by email.</p>
HTML;
    }
}

