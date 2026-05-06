<?php
/**
 * Append blog content methods 9-12 and closing brace to BlogPostsSeeder.php
 * Run: php scripts/append_methods_9_12.php
 */

$path = __DIR__ . '/../database/seeders/BlogPostsSeeder.php';

// ===== post9(): The 5 Ecological Zones of Kilimanjaro =====
$post9 = <<<'PHP'

    private function post9(): string
    {
        return <<<'HTML'
<h2>The 5 Ecological Zones of Kilimanjaro: From Rainforest to Arctic Summit</h2>
<p>One of the most remarkable aspects of climbing Kilimanjaro is the journey through five distinct ecological zones. In just a few days, you'll ascend from lush tropical rainforest to an arctic summit landscape — a climatic transition that takes thousands of kilometres horizontally compressed into a 4,000-metre vertical climb.</p>

<h3>Zone 1: Cultivated Zone (800–1,800m)</h3>
<p>Your journey begins in the fertile foothills surrounding Moshi. This zone is dominated by small farms growing coffee, bananas, maize, and beans. The air is warm and humid, and the trails pass through vibrant villages where children wave and farmers tend their plots. This is also where you'll find the Chagga people's traditional banana-beer brewing huts and the iconic <em>shamba</em> (farm) system that has sustained communities for centuries. Most treks begin at the park gate, which sits at the boundary between the cultivated zone and the rainforest.</p>

<h3>Zone 2: Montane Rainforest (1,800–2,800m)</h3>
<p>Entering the rainforest is like stepping into another world. The canopy towers overhead, filtering sunlight into dappled patterns on the forest floor. Giant ferns, moss-draped trees, and strangler figs dominate the vegetation. This zone receives up to 2,000 mm of rainfall annually, creating a lush, humid environment. Keep your eyes open for wildlife: black-and-white colobus monkeys leap through the canopy, blue monkeys forage in the understory, and if you're lucky, you might spot a bushbuck or duiker. The birdlife is extraordinary — look for the colourful Hartlaub's turaco and the distinctive crowned hornbill. The <a href="/trekking/marangu">Marangu Route</a> and <a href="/trekking/machame">Machame Route</a> both begin their first day in this zone.</p>

<h3>Zone 3: Heather and Moorland (2,800–4,000m)</h3>
<p>As the trees thin out, you enter a landscape of giant heather, lobelias, and groundsels. These plants have adapted to the harsh conditions with rosette shapes that protect their growing tips from frost. The temperature drops noticeably, and the air becomes thinner. This is where you'll first feel the altitude — a slight breathlessness on steep sections, a mild headache by evening. The views open up dramatically, with the mountain's bulk looming above and the plains of Tanzania stretching to the horizon below. The trail winds through valleys of volcanic rock and across streams fed by glacial meltwater. The <a href="/trekking/lemosho">Lemosho Route</a> crosses the beautiful Shira Plateau in this zone — a high-altitude desert of volcanic craters and ancient lava flows.</p>

<h3>Zone 4: Alpine Desert (4,000–5,000m)</h3>
<p>Above 4,000 metres, vegetation becomes sparse. The landscape is raw and lunar — volcanic scree, rocky outcrops, and the occasional hardy lichen clinging to boulders. Daytime temperatures can reach 30°C in direct sun, while nights plunge well below freezing. This is the zone where altitude becomes a serious factor. Most trekkers experience significant symptoms here: loss of appetite, disrupted sleep, and persistent headaches. The strategy is "climb high, sleep low" — your daily ascent takes you higher than your sleeping altitude, giving your body time to acclimatise. The Barranco Wall, a steep scramble on the Machame and Lemosho routes, sits at the boundary between moorland and alpine desert.</p>

<h3>Zone 5: Arctic Summit Zone (5,000–5,895m)</h3>
<p>The final zone is a world of ice, rock, and thin air. At 50% of sea-level oxygen, every step requires conscious effort. The landscape is dominated by glaciers — the Furtwängler, Rebmann, and Ratzel glaciers — though they have receded dramatically over the past century. Summit night is a surreal experience: headlamps bobbing in the darkness, the crunch of boots on volcanic scree, and the gradual lightening of the sky as dawn approaches. Reaching Uhuru Peak at sunrise, with the African continent spread at your feet and the glaciers glowing pink in the morning light, is an experience that defies description.</p>

<h3>Why Understanding the Zones Matters</h3>
<p>Knowing what to expect in each zone helps you prepare mentally and physically. Pack for all seasons: a single day on Kilimanjaro can take you from tropical warmth to arctic cold. Layer your clothing, stay hydrated, and pace yourself. Each zone presents different challenges — and different rewards. The transition from rainforest to moorland, from moorland to alpine desert, and finally to the arctic summit is a journey through the world's climatic extremes, all in a single trek.</p>
<p>Ready to experience all five zones? Explore our <a href="/trekking">Kilimanjaro trekking routes</a> and choose the one that takes you through this incredible journey.</p>
HTML;
    }
PHP;

// ===== post10(): Why Group Departures Work =====
$post10 = <<<'PHP'

    private function post10(): string
    {
        return <<<'HTML'
<h2>Group Departures vs Private Climbs: Which Kilimanjaro Experience Is Right for You?</h2>
<p>One of the first decisions you'll make when booking a Kilimanjaro trek is whether to join a group departure or book a private climb. Both options have distinct advantages, and the right choice depends on your budget, personality, and trekking goals. Here's an honest comparison to help you decide.</p>

<h3>What Are Group Departures?</h3>
<p>Group departures are fixed-date treks where you join other travellers from around the world. Our <a href="/plan/group-departures">group departure programme</a> runs year-round on all major routes, with groups typically ranging from 4 to 12 trekkers. You share the experience — and the costs — with fellow adventurers.</p>

<h3>Pros of Group Departures</h3>
<ul>
<li><strong>Lower cost:</strong> Sharing guide fees, porter allocations, and park entry fees across a group significantly reduces the per-person price. Group departures are typically 30–40% cheaper than private climbs.</li>
<li><strong>Built-in community:</strong> The shared challenge of Kilimanjaro creates powerful bonds. Many of our trekkers leave with lifelong friendships — and sometimes even trekking partners for future adventures.</li>
<li><strong>Fixed schedule:</strong> If you have limited vacation time, group departures offer certainty. You know exactly when you'll climb and when you'll descend.</li>
<li><strong>Safety in numbers:</strong> Larger groups mean more guides, more support, and better emergency response capability. If someone needs to descend, the group can continue with remaining guides.</li>
<li><strong>Motivation boost:</strong> On summit night, the collective energy of a group pushing toward the same goal is incredibly powerful. When you're struggling, someone else's determination can carry you forward.</li>
</ul>

<h3>Cons of Group Departures</h3>
<ul>
<li><strong>Fixed pace:</strong> You walk at the group's pace, not your own. If you're naturally faster or slower, you may find the pace frustrating.</li>
<li><strong>Less flexibility:</strong> Rest days, meal times, and camp routines follow the group schedule. There's less room for personal preferences.</li>
<li><strong>Mixed fitness levels:</strong> A group is only as fast as its slowest member. If you're a strong hiker, you may spend a lot of time waiting.</li>
</ul>

<h3>Pros of Private Climbs</h3>
<ul>
<li><strong>Your pace, your schedule:</strong> Want to start hiking at 6am instead of 8am? Take an extra rest day? Hike faster or slower? A private climb gives you complete control.</li>
<li><strong>Personalised attention:</strong> Your guides focus entirely on you and your party. This is especially valuable if you have specific fitness concerns, dietary requirements, or medical considerations.</li>
<li><strong>Ideal for families and groups of friends:</strong> If you're already travelling with 4+ people you know, a private climb costs about the same as a group departure — but you get the privacy and flexibility of your own schedule.</li>
<li><strong>Romantic or milestone treks:</strong> Proposals, anniversary celebrations, or personal challenges often benefit from the intimacy of a private experience.</li>
</ul>

<h3>Cons of Private Climbs</h3>
<ul>
<li><strong>Higher cost:</strong> You absorb all guide, porter, and permit costs without sharing. Expect to pay 30–50% more than a group departure.</li>
<li><strong>Less social variety:</strong> You're with the same people every day. For solo travellers, this can feel isolating compared to the social atmosphere of a group.</li>
</ul>

<h3>Which Should You Choose?</h3>
<p><strong>Choose a group departure if:</strong> You're a solo traveller, budget-conscious, or enjoy meeting new people. Group departures are also excellent for first-time trekkers who appreciate the structured support.</p>
<p><strong>Choose a private climb if:</strong> You're travelling with a pre-existing group of 4+, have specific fitness or medical needs, or want complete control over your itinerary. Private climbs are also the right choice for couples celebrating a special occasion.</p>

<h3>Our Recommendation</h3>
<p>For most first-time Kilimanjaro trekkers, we recommend starting with a <a href="/plan/group-departures">group departure</a>. The cost savings are significant, the social experience is enriching, and the safety benefits of a larger group are meaningful. You can always book a private climb on your next visit — and many of our trekkers do exactly that.</p>
HTML;
    }
PHP;

// ===== post11(): Moshi: Arrival, Hotels, and Pre-Climb Preparation =====
$post11 = <<<'PHP'

    private function post11(): string
    {
        return <<<'HTML'
<h2>Moshi: Arrival, Hotels, and Pre-Climb Preparation Guide</h2>
<p>Moshi is the gateway to Kilimanjaro. This vibrant town at the foot of the mountain is where your adventure begins — and where you'll return after your summit triumph. Knowing what to expect on arrival, where to stay, and how to prepare will set you up for a smooth and successful trek.</p>

<h3>Getting to Moshi</h3>
<p>Most international trekkers fly into Kilimanjaro International Airport (JRO), located about 45 minutes from Moshi. Direct flights arrive from Amsterdam (KLM), Doha (Qatar Airways), Istanbul (Turkish Airlines), and Nairobi (Kenya Airways). From the airport, pre-arranged transfers cost $30–$50 per vehicle. Alternatively, you can fly into Dar es Salaam or Nairobi and take a connecting flight or bus to Moshi. We recommend arriving at least one full day before your trek starts to recover from jet lag and complete final preparations.</p>

<h3>Best Hotels in Moshi</h3>
<ul>
<li><strong>Parkview Inn:</strong> A mid-range favourite with clean rooms, reliable Wi-Fi, and a garden restaurant. Popular with trekkers. Rooms from $60–$90 per night.</li>
<li><strong>Kilimanjaro Wonders Hotel:</strong> Upscale option with a pool, spa, and mountain views. Excellent for pre-trek relaxation. Rooms from $120–$180 per night.</li>
<li><strong>Moshi Hostel:</strong> Budget-friendly dormitory and private rooms. Great for solo travellers and backpackers. Dorms from $15, private rooms from $40.</li>
<li><strong>Springlands Hotel:</strong> A well-established trekker hotel with a lively bar, good food, and easy gear rental. Rooms from $50–$80 per night.</li>
</ul>

<h3>Pre-Climb Preparation Checklist</h3>
<p><strong>Gear rental:</strong> If you're missing any equipment, Moshi has numerous gear rental shops. Quality varies, so inspect items carefully. We recommend bringing your own boots, but you can rent sleeping bags (rated to -10°C), trekking poles, gaiters, and waterproof jackets locally. Expect to pay $5–$15 per item for the duration of your trek.</p>
<p><strong>Cash:</strong> ATMs in Moshi dispense Tanzanian shillings, but US dollars are widely accepted. Bring $400–$500 in small US bills for tips, souvenirs, and incidentals. Credit cards are accepted at larger hotels but not at gear shops or local restaurants.</p>
<p><strong>SIM card:</strong> Buy a local SIM card from Vodacom or Airtel at the airport or in town. 10 GB of data costs about $10. Coverage is excellent in Moshi and on the lower slopes of the mountain.</p>
<p><strong>Medication:</strong> Visit a pharmacy in Moshi for any last-minute supplies: Diamox (acetazolamide) for altitude, ibuprofen for headaches, and anti-nausea tablets. Pharmacies are well-stocked and prices are lower than in Western countries.</p>
<p><strong>Hydration:</strong> Start hydrating 48 hours before your trek. Aim for 3–4 litres of water per day. Avoid alcohol entirely in the 24 hours before your climb.</p>

<h3>Pre-Trek Briefing</h3>
<p>Your head guide will meet you at your hotel the evening before departure. This briefing covers: final gear check, route overview, daily schedule, safety procedures, and tipping guidelines. Bring all your gear to this meeting — your guide will help you eliminate unnecessary items and ensure you're properly equipped. This is also your chance to ask any last-minute questions about the trek ahead.</p>

<h3>What to Do in Moshi</h3>
<p>If you have an extra day, explore Moshi's markets (the Maasai Market on Saturdays is excellent for souvenirs), visit a local coffee plantation, or take a short hike to the Materuni Waterfalls. The town has a relaxed, friendly atmosphere — perfect for settling your nerves before the mountain.</p>
<p>Ready to start your Kilimanjaro adventure? Browse our <a href="/trekking">trekking routes</a> and <a href="/plan/group-departures">group departure dates</a> to find your perfect climb.</p>
HTML;
    }
PHP;

// ===== post12(): Common Mistakes First-Time Trekkers Make =====
$post12 = <<<'PHP'

    private function post12(): string
    {
        return <<<'HTML'
<h2>10 Common Mistakes First-Time Kilimanjaro Trekkers Make (And How to Avoid Them)</h2>
<p>Kilimanjaro is a challenging but achievable goal — thousands of people summit successfully every year. However, first-time trekkers often make predictable mistakes that reduce their chances of success or diminish their enjoyment. Learn from others' errors and set yourself up for a triumphant summit.</p>

<h3>1. Overpacking</h3>
<p>The most common mistake. First-time trekkers bring too many clothes, too many gadgets, and too much "just in case" gear. Your porter carries a maximum of 15 kg — and you'll carry 5–7 kg in your daypack. Pack only what you'll actually use. Leave the novel, the deck of cards, and the extra pair of jeans at the hotel. Every unnecessary gram is energy wasted.</p>

<h3>2. Poor Pacing on Summit Night</h3>
<p>Summit night is a marathon, not a sprint. The biggest mistake is starting too fast, driven by adrenaline and excitement. By the time you reach Stella Point (5,756m), you'll be exhausted. The key is "pole pole" (slowly, slowly) — a pace so slow it feels frustrating. If you can maintain a conversation without gasping, you're at the right speed. Let faster trekkers pass. Your goal is to reach the summit, not to be first.</p>

<h3>3. Wearing Wrong Footwear</h3>
<p>New, unbroken boots are a recipe for disaster. Blisters on day one can end your trek by day three. Break in your boots for at least 4–6 weeks before your climb. Wear them on long walks, on hills, and in wet conditions. Also: don't wear cotton socks. Use merino wool or synthetic hiking socks, and bring a spare pair to change into at lunch stops. Wet socks cause blisters faster than anything else.</p>

<h3>4. Ignoring Altitude Symptoms</h3>
<p>Altitude sickness is unpredictable — fitness, age, and prior experience don't guarantee immunity. The mistake is ignoring early symptoms: persistent headache, nausea, loss of appetite, and difficulty sleeping. These are your body telling you to slow down. If symptoms worsen (vomiting, confusion, loss of coordination), you must descend immediately. No summit is worth your life. Our guides are trained to recognise severe altitude sickness — trust their judgment.</p>

<h3>5. Underestimating Hydration</h3>
<p>At altitude, your body loses water through respiration at twice the rate at sea level. Dehydration accelerates altitude sickness and saps your energy. Aim for 4–5 litres of water per day. Use electrolyte tablets to replenish salts. Start hydrating 48 hours before your trek. And yes — this means you'll need to urinate frequently during the night. That's normal and healthy.</p>

<h3>6. Skipping the Training</h3>
<p>"I'll get fit on the mountain" is a dangerous mindset. Kilimanjaro demands cardiovascular endurance, leg strength, and mental resilience. Our <a href="/plan/training-guide">8-week training plan</a> is designed to prepare you for the specific demands of the climb. Don't skip it. The trekkers who train consistently are the ones who reach the summit smiling.</p>

<h3>7. Not Layering Properly</h3>
<p>Kilimanjaro's temperature swings from 30°C at midday to -15°C at night. The mistake is wearing a heavy jacket while hiking — you'll sweat, then freeze when you stop. The solution is layers: a moisture-wicking base layer, an insulating mid-layer (fleece or down), and a waterproof shell. Add or remove layers as your activity level and the temperature change. On summit night, you'll wear all your layers at once.</p>

<h3>8. Forgetting Sun Protection</h3>
<p>At 5,000 metres, UV radiation is intense — you can sunburn in minutes, even through cloud cover. Sunscreen (SPF 50+), lip balm with SPF, and UV-protective sunglasses are essential. Reapply sunscreen every two hours. The most painful sunburns we see are on the underside of the nose and the back of the neck — areas trekkers forget to protect.</p>

<h3>9. Not Bringing Enough Cash for Tips</h3>
<p>As covered in our <a href="/blog/how-to-tip-on-kilimanjaro">tipping guide</a>, your crew relies on tips as a significant part of their income. Running out of cash is embarrassing and unfair to the people who supported you. Bring $400–$500 in small US bills. ATMs in Moshi are unreliable. Don't skimp on this.</p>

<h3>10. Neglecting Mental Preparation</h3>
<p>The physical challenge of Kilimanjaro is real, but the mental challenge is often harder. Summit night is long, cold, and uncomfortable. You will want to quit. The trekkers who succeed are the ones who have prepared mentally: they've visualised the struggle, practised positive self-talk, and committed to the goal before they started. When your body says stop, your mind has to say go.</p>

<h3>Final Advice</h3>
<p>Kilimanjaro is the adventure of a lifetime. Prepare properly, listen to your guides, and embrace the challenge. Every step — even the hard ones — is part of an experience you'll remember forever. Ready to start? Explore our <a href="/trekking">Kilimanjaro trekking routes</a> and book your adventure today.</p>
HTML;
    }
PHP;

// Append methods 9-12
$content = $post9 . $post10 . $post11 . $post12;
file_put_contents($path, $content, FILE_APPEND);

// Append closing brace
file_put_contents($path, "\n}\n", FILE_APPEND);

$size = filesize($path);
echo "Appended methods 9-12 and closing brace. File now {$size} bytes\n";
