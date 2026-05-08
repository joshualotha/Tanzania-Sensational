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
                'meta_title' => 'Tanzania Safari & Kilimanjaro Trekking | Tanzania Sensational',
                'meta_description' => 'Premium Kilimanjaro & Meru trekking expeditions, Tanzania safaris, and Zanzibar beach extensions. Submit a booking request and we\'ll confirm by email.',
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
                'meta_description' => 'Send an inquiry or booking request. We\'ll reply by email to confirm details and arrange payment offline.',
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
                'content' => $this->enhancedHtml('Local Custom', '
                    <p>Tanzania is a country of profound cultural richness, home to over 120 ethnic groups living together in harmony. Understanding and respecting local customs will transform your visit from a simple holiday into a meaningful cultural exchange. This guide covers the essential etiquette every traveler should know.</p>
                    
                    <h3>Greetings — The Foundation of Respect</h3>
                    <p>In Tanzanian culture, greetings are not a quick formality — they are a ritual of recognition and respect. When you meet someone, always take time to exchange pleasantries before discussing business or asking questions. A proper greeting includes asking about the other person\'s health, family, and day. Common phrases include "Jambo" (hello), "Habari" (how are you?), and "Mzuri" (fine). Handshakes are the standard greeting, but use a gentle grip — a firm handshake can be perceived as aggressive.</p>
                    
                    <h3>Photography Etiquette</h3>
                    <p>Always ask permission before photographing people, their homes, or their property. A smile and a gesture toward your camera is universally understood. Many locals, particularly in rural areas, believe that having their photo taken captures a part of their spirit. Offer to show them the photo afterward — this builds trust and creates a positive interaction. Never photograph government buildings, military installations, or border crossings. When photographing wildlife, respect the animals\' space and never use flash at night.</p>
                    
                    <h3>Tipping Norms</h3>
                    <p>Tipping is an essential part of the Tanzanian tourism economy. Your guides, drivers, cooks, and camp staff rely on tips for a significant portion of their income. Standard tipping guidelines: safari guides $15-25 per guest per day, drivers $10-15 per guest per day, camp staff $5-10 per guest per day (pooled). For Kilimanjaro treks, budget $200-300 total for your support team. Tips are best given in USD using crisp bills dated after 2009 — older bills are often rejected by banks.</p>
                    
                    <h3>Dress Code & Modesty</h3>
                    <p>Tanzania is a conservative country with significant Muslim and Christian populations. Outside of beach resorts and safari lodges, modest dress is expected. Women should cover shoulders and knees in villages and towns. Swimwear is acceptable only at pools and beaches. Remove shoes when entering homes or mosques. In Stone Town, Zanzibar, dress particularly conservatively — long skirts or pants for women, long pants for men.</p>
                    
                    <h3>Dining Etiquette</h3>
                    <p>If invited to a Tanzanian home, it is customary to bring a small gift such as fruit, sugar, or soft drinks. Never refuse food or drink offered by a host — it is considered a grave insult. Accept at least a sip or a bite. Use your right hand for eating and passing items; the left hand is considered unclean. Wait for the host to begin eating before you start. Compliment the food — Tanzanian hospitality is deeply connected to sharing meals.</p>
                    
                    <h3>Language & Communication</h3>
                    <p>While English is widely spoken in tourist areas, learning a few Swahili phrases will be greatly appreciated. "Asante sana" (thank you very much), "Karibu" (welcome), and "Pole pole" (slowly, slowly) are essential. Tanzanians communicate indirectly — avoid confrontational language or showing anger in public. Patience is a virtue; things move at their own pace, and frustration is counterproductive.</p>
                '),
            ],
            [
                'slug' => 'safari-guide-what-to-wear',
                'title' => 'What to Wear',
                'meta_title' => 'Safari Guide: What to Wear | Tanzania Sensational',
                'meta_description' => 'What to wear on safari for comfort, style, and practicality—from game drives to lodges.',
                'og_image' => null,
                'content' => $this->enhancedHtml('What to Wear', '
                    <p>Your safari wardrobe is your first line of defense against the African sun, morning chill, biting insects, and dust. The key is layering — a single day on safari can swing from near-freezing at dawn to 35°C by midday. This guide covers exactly what to pack and why each item matters.</p>
                    
                    <h3>The Layering System</h3>
                    <p>Master the art of layering and you will be comfortable in any condition. Start with a moisture-wicking base layer (merino wool or synthetic — never cotton against your skin). Add a mid-layer like a lightweight fleece or long-sleeve shirt. Top with a windproof and water-resistant outer shell. This system lets you adapt as the temperature swings throughout the day. Early morning game drives at 5°C require all three layers; by noon you will likely be down to your base layer.</p>
                    
                    <h3>Colors That Work</h3>
                    <p>Neutral earth tones are the gold standard for safari attire. Khaki, olive, tan, beige, and muted greens blend with the landscape and do not attract tsetse flies (which are drawn to bright and dark colors). Avoid white — it gets dirty instantly and stands out to wildlife. Avoid bright colors like red, yellow, and neon — they startle animals and mark you as a tourist. Camouflage is prohibited in Tanzania (it is reserved for military use).</p>
                    
                    <h3>Footwear</h3>
                    <p>Comfortable, broken-in walking shoes or light hiking boots are essential for game drives (you may get out for bush walks) and camp transfers. Closed-toe shoes protect against snakes, scorpions, and thorns. Pack camp sandals or flip-flops for relaxing at the lodge. If your itinerary includes walking safaris, sturdy boots with ankle support are non-negotiable. Never wear new shoes on safari — blisters will ruin your experience.</p>
                    
                    <h3>Sun Protection</h3>
                    <p>The equatorial sun is intense. A wide-brimmed sun hat is essential — baseball caps leave your ears and neck exposed. Polarized sunglasses with UV protection reduce glare and protect your eyes. SPF 50+ broad-spectrum sunscreen should be applied every two hours. A lightweight long-sleeve shirt with UPF rating provides the best protection without requiring constant reapplication. Lip balm with SPF is often overlooked but essential.</p>
                    
                    <h3>Evening & Lodge Wear</h3>
                    <p>Evenings at safari lodges cool down significantly. A fleece or light down jacket is essential for sundowners and dinner. Many lodges have a "smart casual" dress code for dinner — collared shirts for men, nice blouses or sundresses for women. Closed-toe shoes are appreciated at dinner. A light scarf or pashmina is versatile for cool evenings and dusty game drives.</p>
                '),
            ],
            [
                'slug' => 'safari-guide-packing-guide',
                'title' => 'Packing Guide',
                'meta_title' => 'Safari Guide: Packing Guide | Tanzania Sensational',
                'meta_description' => 'A clear safari packing checklist—what to bring, what to skip, and how to pack efficiently.',
                'og_image' => null,
                'content' => $this->enhancedHtml('Packing Guide', '
                    <p>Packing for a safari requires a different mindset than any other trip. Weight limits on bush flights (typically 15kg in soft duffel bags), dust, heat, and limited laundry facilities all factor into what you bring. This comprehensive checklist covers everything you need — and nothing you don\'t.</p>
                    
                    <h3>The Golden Rule: Soft Bags Only</h3>
                    <p>Most safari camps are accessed by small Cessna-style aircraft with strict weight limits and cargo holds that cannot accommodate hard-shell suitcases. Invest in a quality soft-sided duffel bag (60-80 liters is ideal). A small daypack (20-30 liters) is essential for game drives to carry camera gear, water, sunscreen, and layers. Leave the hard-shell suitcase at home — it will either be refused or cause logistical problems.</p>
                    
                    <h3>Essential Documents</h3>
                    <p>Your passport must be valid for at least six months beyond your travel dates and have at least two blank pages. Carry a printed copy of your e-Visa confirmation (or obtain a visa on arrival at major airports — $50 USD for single entry). Your Yellow Fever vaccination certificate is mandatory and will be checked at immigration. Travel insurance documents covering medical evacuation are strongly recommended. Keep photocopies of all documents separate from originals.</p>
                    
                    <h3>Camera & Electronics</h3>
                    <p>A DSLR or mirrorless camera with a zoom lens (200-400mm is ideal for wildlife) will capture the experience. Bring at least two spare batteries — cold mornings drain battery life quickly. A 64GB+ SD card is the minimum; 128GB+ is better for serious photographers. A universal power adapter (Type G, UK-style plug) is essential. A 20,000mAh+ power bank keeps devices charged during long game drives. Binoculars (8x42 magnification recommended) are as important as your camera.</p>
                    
                    <h3>Health & Medical Kit</h3>
                    <p>SPF 50+ sunscreen, DEET-based insect repellent (30%+ concentration), and anti-malaria prophylaxis (consult your doctor 4-6 weeks before travel) are non-negotiable. Pack a basic first-aid kit with bandages, antiseptic wipes, pain relievers, antihistamines, and oral rehydration salts. Hand sanitizer and wet wipes are invaluable. Any personal prescription medications should be in their original packaging with a copy of the prescription.</p>
                    
                    <h3>What NOT to Bring</h3>
                    <p>Leave expensive jewelry, designer handbags, and flashy accessories at home — they attract unwanted attention and are impractical in the bush. High heels, formal wear, and excessive clothing will go unused. Drones are heavily regulated in Tanzania and require permits that are difficult to obtain. Selfie sticks are banned in many parks. Heavy books are better replaced with an e-reader or tablet.</p>
                '),
            ],
            [
                'slug' => 'safari-guide-accommodation-style',
                'title' => 'Accommodation Style',
                'meta_title' => 'Safari Guide: Accommodation Style | Tanzania Sensational',
                'meta_description' => 'Understand safari accommodation types—from lodges to camps—so you can choose the right comfort level.',
                'og_image' => null,
                'content' => $this->enhancedHtml('Accommodation Style', '
                    <p>Choosing the right accommodation is one of the most important decisions you will make for your safari. Tanzania offers a spectrum of options — from permanent luxury lodges to mobile tented camps that move with the seasons. Understanding the differences will help you choose the experience that matches your comfort level, budget, and travel style.</p>
                    
                    <h3>Permanent Lodges</h3>
                    <p>Permanent lodges are fixed structures built in prime wildlife locations. They offer the highest level of comfort with en-suite bathrooms, hot showers, electricity, restaurants, and often swimming pools. Lodges range from mid-range (comfortable but basic) to luxury (five-star amenities in the wilderness). The advantage is consistent quality and reliability. The trade-off is that you are in a fixed location — wildlife comes to you, not the other way around. Popular examples include Serengeti Serena Lodge and Ngorongoro Sopa Lodge.</p>
                    
                    <h3>Tented Camps</h3>
                    <p>Tented camps offer a more immersive safari experience. You sleep in spacious canvas tents on raised platforms, often with en-suite bathrooms and hot water. The sounds of the bush — lions roaring, hyenas whooping, hippos grunting — are your nighttime soundtrack. Tented camps range from basic (shared bathrooms, solar lighting) to luxury (king-sized beds, copper bathtubs, private verandas). Seasonal tented camps move with the wildlife, ensuring you are always in the best game-viewing areas.</p>
                    
                    <h3>Mid-Range vs Luxury — What to Expect</h3>
                    <p>Mid-range accommodations offer comfortable rooms or tents with en-suite bathrooms, reliable hot water, electricity (often solar), and good food. You will have a comfortable bed, mosquito net, and basic amenities. Luxury accommodations add private plunge pools, gourmet dining, premium wines, personal butler service, and exceptional design. Both provide excellent game-viewing experiences — the difference is in the details of your downtime. For most travelers, mid-range offers the best value without sacrificing the safari experience.</p>
                    
                    <h3>Power, Water & Connectivity</h3>
                    <p>In remote areas, electricity is typically solar-powered with limited capacity. Most camps have charging stations in common areas but may restrict high-wattage devices like hair dryers. Hot water is usually available but may be scheduled (morning and evening). Wi-Fi is increasingly common in lodges and premium camps, but connection speeds are limited and may only be available in common areas. Embrace the digital detox — being offline is part of the safari experience. Bring a power bank and a universal adapter as backup.</p>
                    
                    <h3>How to Choose</h3>
                    <p>Consider your priorities: wildlife proximity, comfort level, budget, and travel style. If you want guaranteed hot showers and reliable Wi-Fi, choose a permanent lodge. If you want to fall asleep to the sounds of the bush and wake up to wildlife outside your tent, choose a tented camp. For the best of both worlds, consider a split itinerary — a few nights in a lodge followed by a few nights in a mobile camp. Your tour operator can recommend specific properties based on your preferences and the season.</p>
                '),
            ],
            [
                'slug' => 'safari-guide-visa-guide',
                'title' => 'Visa Guide',
                'meta_title' => 'Safari Guide: Visa Guide | Tanzania Sensational',
                'meta_description' => 'Visa basics for Tanzania: what you\'ll need and how to prepare before arrival.',
                'og_image' => null,
                'content' => $this->enhancedHtml('Visa Guide', '
                    <p>Understanding Tanzania\'s visa requirements is essential for a smooth arrival. The process is straightforward for most nationalities, but preparation is key. This guide covers everything you need to know about obtaining your Tanzania visa, from eligibility to entry requirements.</p>
                    
                    <h3>Visa on Arrival vs E-Visa</h3>
                    <p>Most travelers can obtain a visa on arrival at Julius Nyerere International Airport (Dar es Salaam), Kilimanjaro International Airport (JRO), and other major entry points. The visa on arrival costs $50 USD for single entry (most nationalities) and $100 USD for multiple entry. You must have a printed copy of your return flight ticket and proof of accommodation. Alternatively, you can apply for an e-Visa online before travel through the official Tanzania immigration website. The e-Visa costs the same but saves time at the airport — you skip the visa queue and proceed directly to immigration. Processing takes 3-10 business days, so apply at least two weeks before departure.</p>
                    
                    <h3>Passport Requirements</h3>
                    <p>Your passport must be valid for at least six months beyond your intended departure date from Tanzania. It must have at least two consecutive blank pages for the visa sticker and entry/exit stamps. If your passport is damaged, has less than six months validity, or lacks blank pages, you will be denied entry. Check your passport well in advance and renew if necessary.</p>
                    
                    <h3>Visa-Free & Visa-on-Arrival Countries</h3>
                    <p>Citizens of most Commonwealth countries, the United States, Canada, Australia, New Zealand, and most European Union countries can obtain a visa on arrival or apply for an e-Visa. Citizens of certain African countries (including Kenya, Uganda, Rwanda, Burundi, Zambia, Zimbabwe, and others) may be exempt from visa requirements under regional agreements. Citizens of some countries require a visa obtained in advance from a Tanzanian embassy — check with the nearest Tanzanian diplomatic mission if you are unsure.</p>
                    
                    <h3>Yellow Fever Vaccination</h3>
                    <p>The Yellow Fever vaccination certificate is mandatory for all travelers entering Tanzania. You will be asked to present your certificate at immigration. If you are traveling from or through a Yellow Fever endemic country, the requirement is strictly enforced. If you do not have the certificate, you may be required to be vaccinated at the airport (at your own expense) or denied entry. The vaccination must be administered at least 10 days before travel and is valid for life.</p>
                    
                    <h3>Arrival Process</h3>
                    <p>Upon arrival at Kilimanjaro International Airport (JRO) or other entry points, proceed to immigration after collecting your baggage. Have your passport, visa (or visa application form and cash), return flight ticket, and Yellow Fever certificate ready. The process typically takes 15-30 minutes for e-Visa holders and 30-60 minutes for visa-on-arrival applicants. After immigration, you will collect your checked luggage and proceed through customs. Declare any items of value (cameras, laptops, drones) on the customs form to avoid issues on departure.</p>
                '),
            ],
            [
                'slug' => 'safari-guide-health-and-safety',
                'title' => 'Health and Safety',
                'meta_title' => 'Safari Guide: Health and Safety | Tanzania Sensational',
                'meta_description' => 'Health and safety guidance for safari travel, including hydration, sun care, and general precautions.',
                'og_image' => null,
                'content' => $this->enhancedHtml('Health and Safety', '
                    <p>Your health and safety during a Tanzanian safari is largely in your hands. The vast majority of health issues are preventable with proper preparation and common sense. This guide covers the essential precautions every traveler should take before and during their safari.</p>
                    
                    <h3>Pre-Travel Health Preparation</h3>
                    <p>Consult a travel medicine specialist 4-6 weeks before your trip. Discuss recommended vaccinations including Yellow Fever (mandatory), Hepatitis A, Typhoid, and Tetanus. Your doctor will also prescribe anti-malaria prophylaxis — the choice of medication depends on your health history and the regions you are visiting. Schedule a dental check-up before departure — a tooth infection in the bush is a serious problem. If you have pre-existing medical conditions, carry a letter from your doctor describing your condition and medications.</p>
                    
                    <h3>Sun Protection — Non-Negotiable</h3>
                    <p>The equatorial sun at Tanzania\'s latitude is intense year-round. UV index regularly reaches 11+ (extreme). Apply SPF 50+ broad-spectrum sunscreen to all exposed skin 20 minutes before going outside and reapply every two hours. A wide-brimmed hat is essential — baseball caps leave your ears, neck, and the top of your head exposed. Polarized sunglasses with UV400 protection prevent eye damage. Lightweight long-sleeve shirts and pants with UPF rating provide the best protection. The sun is strongest between 10 AM and 4 PM — plan game drives accordingly.</p>
                    
                    <h3>Hydration & Food Safety</h3>
                    <p>Never drink tap water in Tanzania. Stick to sealed bottled water or purified water provided by your lodge or camp. Avoid ice cubes unless you are certain they were made from purified water. Dehydration is the most common health issue on safari — drink at least 3 liters of water per day in the heat. Eat only thoroughly cooked food, peeled fruits, and vegetables you have washed yourself. Avoid street food and raw salads from unknown sources. Oral rehydration salts are a smart addition to your medical kit.</p>
                    
                    <h3>Insect Bite Prevention</h3>
                    <p>Tanzania is a high-risk malaria zone. Use DEET-based insect repellent (30%+ concentration) on all exposed skin, especially during dawn and dusk when mosquitoes are most active. Sleep under treated mosquito nets provided by your accommodation. Wear long sleeves and pants after sunset. Consider permethrin-treated clothing for additional protection. If you develop fever, chills, or flu-like symptoms during or after your trip, seek medical attention immediately and mention your travel history — malaria is treatable but can be fatal if delayed.</p>
                    
                    <h3>Wildlife Safety</h3>
                    <p>Wild animals are unpredictable and dangerous when approached. Your guide\'s instructions are absolute law. Never stand up or make sudden movements in an open vehicle during game drives. Keep arms and legs inside the vehicle at all times. Speak quietly during wildlife sightings. Never exit the vehicle unless your guide explicitly says it is safe. At camp, never walk alone at night — always request an escort. Store food securely in your tent to avoid attracting animals. Respect the wildlife — you are a visitor in their home.</p>
                    
                    <h3>Emergency Contacts</h3>
                    <p>Save these numbers before you travel: AMREF Flying Doctors (emergency air evacuation) — +255 20 732 2612. Tanzania Tourist Police — +255 20 219 1311. Your country\'s embassy in Dar es Salaam. Your travel insurance provider\'s 24-hour emergency line. Your safari operator\'s emergency contact. Most reputable camps and lodges have satellite phones and emergency evacuation plans — confirm these details upon arrival.</p>
                '),
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
<h1>{$title}</h1>
<ul>{$li}</ul>
HTML;
    }

    private function enhancedHtml(string $title, string $content): string
    {
        $escapedTitle = e($title);
        // Trim any extra whitespace from the content
        $trimmedContent = trim($content);
        
        return <<<HTML
<h1>{$escapedTitle}</h1>
{$trimmedContent}
HTML;
    }
}
