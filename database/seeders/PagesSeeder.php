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
                'content' => null,
            ],
            [
                'slug' => 'about',
                'title' => 'About',
                'meta_title' => 'About Us | Tanzania Sensational',
                'meta_description' => 'Learn about our team, our approach, and how we run premium trekking and safari experiences in Tanzania.',
                'og_image' => null,
                'content' => '<p class="cms-note">This page has a dedicated design component. Content is managed through the component code, not the CMS.</p>',
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
                'content' => $this->enhancedHtml('Our Guides', '
                    <p>At Tanzania Sensational, our guides are the heart of every expedition. Each member of our team is a certified professional with extensive local knowledge, advanced wilderness first aid training, and years of experience leading trekkers to the summit of Kilimanjaro and through Tanzania\'s most spectacular safari regions.</p>
                    
                    <h3>Guide Qualifications & Training</h3>
                    <ul>
                        <li><strong>Kilimanjaro National Park Certification:</strong> All guides hold valid KINAPA guiding licenses</li>
                        <li><strong>Wilderness First Responder (WFR) or equivalent:</strong> Advanced medical training for remote environments</li>
                        <li><strong>Altitude Medicine Certification:</strong> Specialized training in altitude sickness recognition and treatment</li>
                        <li><strong>Language Proficiency:</strong> Fluent in English, Swahili, and often additional local languages</li>
                        <li><strong>Minimum 5 Years Experience:</strong> Most guides have 10+ years leading expeditions</li>
                    </ul>
                    
                    <h3>Our Leadership Philosophy</h3>
                    <p>We believe in proactive, transparent leadership. Your guide will:</p>
                    <ul>
                        <li>Conduct daily health checks and altitude assessments</li>
                        <li>Maintain clear communication about daily plans and weather conditions</li>
                        <li>Set a sustainable pace that prioritizes acclimatization</li>
                        <li>Foster a supportive team environment among all expedition members</li>
                        <li>Share cultural and natural history insights throughout your journey</li>
                    </ul>
                    
                    <h3>Meet Some of Our Lead Guides</h3>
                    <div class="guide-profiles">
                        <div class="guide-profile">
                            <h4>Joseph M.</h4>
                            <p><em>Lead Guide & Expedition Manager</em><br>
                            12 years experience, 200+ summits. Specializes in technical routes and altitude medicine.</p>
                        </div>
                        <div class="guide-profile">
                            <h4>Sarah K.</h4>
                            <p><em>Safari Specialist & Cultural Guide</em><br>
                            8 years experience in Northern Circuit parks. Expert in wildlife behavior and photography.</p>
                        </div>
                        <div class="guide-profile">
                            <h4>Michael T.</h4>
                            <p><em>Senior Kilimanjaro Guide</em><br>
                            15 years experience, fluent in 4 languages. Known for exceptional client care and summit success rates.</p>
                        </div>
                    </div>
                '),
            ],
            [
                'slug' => 'company-safety-protocols',
                'title' => 'Safety Protocols',
                'meta_title' => 'Safety Protocols | Tanzania Sensational',
                'meta_description' => 'Our safety standards for trekking and safari operations, including briefings, altitude monitoring, and contingency planning.',
                'og_image' => null,
                'content' => $this->enhancedHtml('Safety Protocols', '
                    <p>Safety is our highest priority. We implement comprehensive protocols developed over decades of experience in high-altitude trekking and wilderness travel. Our systems are designed to prevent issues before they arise and to respond effectively if challenges occur.</p>
                    
                    <h3>Pre-Trek Safety Measures</h3>
                    <ul>
                        <li><strong>Comprehensive Medical Screening:</strong> All participants complete health questionnaires reviewed by our team</li>
                        <li><strong>Detailed Gear Check:</strong> Mandatory inspection of all essential equipment before departure</li>
                        <li><strong>Thorough Briefings:</strong> Day-by-day itinerary review, altitude awareness training, and emergency procedures</li>
                        <li><strong>Weather Monitoring:</strong> Daily consultation with meteorological services and park authorities</li>
                        <li><strong>Equipment Verification:</strong> All group safety equipment (oxygen, medical kits, communications) tested and certified</li>
                    </ul>
                    
                    <h3>On-Mountain Safety Systems</h3>
                    <ul>
                        <li><strong>Daily Health Assessments:</strong> Morning and evening pulse oximetry checks, symptom monitoring</li>
                        <li><strong>Conservative Acclimatization:</strong> "Climb high, sleep low" routing, extra acclimatization days on key routes</li>
                        <li><strong>Guide-to-Client Ratios:</strong> Maximum 1:3 ratio on summit day, 1:4 during regular trekking days</li>
                        <li><strong>Communications Network:</strong> Satellite phones at guide level, VHF radios throughout team</li>
                        <li><strong>Emergency Oxygen:</strong> Carried on all climbs above 4,000m, guides trained in administration</li>
                    </ul>
                    
                    <h3>Emergency Response & Evacuation</h3>
                    <ul>
                        <li><strong>24/7 Operations Center:</strong> Dedicated team monitoring all expeditions</li>
                        <li><strong>Helicopter Evacuation Protocol:</strong> Pre-arranged agreements with emergency services</li>
                        <li><strong>Medical Kits:</strong> Comprehensive wilderness first aid supplies including medications for altitude illness</li>
                        <li><strong>Contingency Planning:</strong> Alternate routes and descent plans for changing conditions</li>
                        <li><strong>Local Hospital Partnerships:</strong> Relationships with facilities in Moshi and Arusha for rapid transfer</li>
                    </ul>
                    
                    <h3>Safari Safety Standards</h3>
                    <ul>
                        <li><strong>Vehicle Safety:</strong> Regularly maintained 4x4 vehicles with safety equipment</li>
                        <li><strong>Wildlife Protocols:</strong> Strict adherence to park regulations and safe viewing distances</li>
                        <li><strong>Guide Training:</strong> Specialized training in animal behavior and emergency response</li>
                        <li><strong>Communication:</strong> Radio contact between vehicles and with park authorities</li>
                        <li><strong>Health Precautions:</strong> Water purification, food safety standards, and malaria prevention guidance</li>
                    </ul>
                '),
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
<h2>{$title}</h2>
<ul>{$li}</ul>
HTML;
    }
}

