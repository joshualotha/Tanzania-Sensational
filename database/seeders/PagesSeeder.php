<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'slug' => 'home',
                'title' => 'Home',
                'meta_title' => 'Tanzania Sensational — Kilimanjaro, Safari & Zanzibar',
                'meta_description' => 'Premium Kilimanjaro & Meru trekking expeditions, Tanzania safaris, and Zanzibar beach extensions. Submit a booking request and we’ll confirm by email.',
                'og_image' => null,
                'content' => '<p>Welcome to Tanzania Sensational. You can edit this homepage introduction in the dashboard CMS.</p>',
            ],
            [
                'slug' => 'about',
                'title' => 'About',
                'meta_title' => 'About Us | Tanzania Sensational',
                'meta_description' => 'Learn about our team, our approach, and how we run premium trekking and safari experiences in Tanzania.',
                'og_image' => null,
                'content' => '<p>About page content can be managed in the dashboard CMS.</p>',
            ],
            [
                'slug' => 'contact',
                'title' => 'Contact',
                'meta_title' => 'Contact | Tanzania Sensational',
                'meta_description' => 'Send an inquiry or booking request. We’ll reply by email to confirm details and arrange payment offline.',
                'og_image' => null,
                'content' => '<p>Contact page content can be managed in the dashboard CMS.</p>',
            ],
            [
                'slug' => 'routes-overview',
                'title' => 'Routes Overview',
                'meta_title' => 'Routes Overview | Tanzania Sensational',
                'meta_description' => 'Explore Kilimanjaro route options and choose the right trek for your schedule and experience level.',
                'og_image' => null,
                'content' => '<p>This is a CMS-managed page intended for a routes overview or landing page.</p>',
            ],
            [
                'slug' => 'company-our-guides',
                'title' => 'Our Guides',
                'meta_title' => 'Our Guides | Tanzania Sensational',
                'meta_description' => 'Meet the mountain and safari professionals behind Tanzania Sensational. Experienced, safety-first, and deeply local.',
                'og_image' => null,
                'content' => $this->html('Our Guides', [
                    'Deep local knowledge and professional training',
                    'Safety-first leadership on every departure',
                    'Clear communication before, during, and after your trip',
                ]),
            ],
            [
                'slug' => 'company-safety-protocols',
                'title' => 'Safety Protocols',
                'meta_title' => 'Safety Protocols | Tanzania Sensational',
                'meta_description' => 'Our safety standards for trekking and safari operations, including briefings, altitude monitoring, and contingency planning.',
                'og_image' => null,
                'content' => $this->html('Safety Protocols', [
                    'Pre-trek briefings and gear checks',
                    'Altitude awareness and conservative pacing',
                    'Reliable communications and evacuation planning',
                ]),
            ],
            [
                'slug' => 'safari-guide-local-custom',
                'title' => 'Local Custom',
                'meta_title' => 'Safari Guide: Local Custom | Tanzania Sensational',
                'meta_description' => 'Helpful cultural notes and etiquette for traveling in Tanzania—simple, respectful, and practical.',
                'og_image' => null,
                'content' => $this->html('Local Custom', [
                    'Greetings and respectful interaction',
                    'Photography etiquette',
                    'Tipping norms and expectations',
                ]),
            ],
            [
                'slug' => 'safari-guide-what-to-wear',
                'title' => 'What to Wear',
                'meta_title' => 'Safari Guide: What to Wear | Tanzania Sensational',
                'meta_description' => 'What to wear on safari for comfort, style, and practicality—from game drives to lodges.',
                'og_image' => null,
                'content' => $this->html('What to Wear', [
                    'Light layers and neutral colors',
                    'A warm layer for early mornings',
                    'Comfortable shoes and sun protection',
                ]),
            ],
            [
                'slug' => 'safari-guide-packing-guide',
                'title' => 'Packing Guide',
                'meta_title' => 'Safari Guide: Packing Guide | Tanzania Sensational',
                'meta_description' => 'A clear safari packing checklist—what to bring, what to skip, and how to pack efficiently.',
                'og_image' => null,
                'content' => $this->html('Packing Guide', [
                    'Daypack essentials',
                    'Camera and charging basics',
                    'Documents and travel insurance',
                ]),
            ],
            [
                'slug' => 'safari-guide-accommodation-style',
                'title' => 'Accommodation Style',
                'meta_title' => 'Safari Guide: Accommodation Style | Tanzania Sensational',
                'meta_description' => 'Understand safari accommodation types—from lodges to camps—so you can choose the right comfort level.',
                'og_image' => null,
                'content' => $this->html('Accommodation Style', [
                    'Lodges vs tented camps',
                    'What “mid-range” and “luxury” typically mean',
                    'Power, hot water, and Wi‑Fi expectations',
                ]),
            ],
            [
                'slug' => 'safari-guide-visa-guide',
                'title' => 'Visa Guide',
                'meta_title' => 'Safari Guide: Visa Guide | Tanzania Sensational',
                'meta_description' => 'Visa basics for Tanzania: what you’ll need and how to prepare before arrival.',
                'og_image' => null,
                'content' => $this->html('Visa Guide', [
                    'Passport validity requirements',
                    'Entry visa overview',
                    'Arrival timing and common checkpoints',
                ]),
            ],
            [
                'slug' => 'safari-guide-health-and-safety',
                'title' => 'Health and Safety',
                'meta_title' => 'Safari Guide: Health and Safety | Tanzania Sensational',
                'meta_description' => 'Health and safety guidance for safari travel, including hydration, sun care, and general precautions.',
                'og_image' => null,
                'content' => $this->html('Health and Safety', [
                    'Sun protection and hydration',
                    'Insect bite prevention',
                    'Basic travel health preparation',
                ]),
            ],
        ];

        foreach ($pages as $p) {
            Page::updateOrCreate(
                ['slug' => $p['slug']],
                [
                    'title' => $p['title'],
                    'content' => $p['content'],
                    'meta_title' => $p['meta_title'],
                    'meta_description' => $p['meta_description'],
                    'og_image' => $p['og_image'],
                ]
            );
        }
    }

    private function html(string $h1, array $bullets): string
    {
        $li = implode('', array_map(fn ($b) => '<li>' . e($b) . '</li>', $bullets));
        $title = e($h1);

        return <<<HTML
<p>Use this page as a starting point. You can fully edit this content in the dashboard CMS.</p>
<h2>{$title}</h2>
<ul>{$li}</ul>
HTML;
    }
}

