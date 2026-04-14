import { visualsData } from './visualsData.js';

export const destinationsData = [
    {
        id: "serengeti",
        name: "Serengeti",
        subtitle: "The Infinite Plains",
        tag: "THE GREAT MIGRATION",
        shortDesc: "Witness the greatest wildlife spectacle on Earth—two million wildebeest thundering across golden savannahs under an endless sky. It is a primal, breathtaking theatre of survival.",
        overview: "The Serengeti is arguably the most famous wildlife sanctuary in the world, unequalled in its natural beauty and scientific value. Encompassing over 14,000 square kilometers, it is a vast, seemingly endless ocean of golden grasses, dotted with acacia trees and dramatic rocky outcrops known as kopjes. Here, the ancient rhythm of the Great Migration dictates life, as millions of hooves pound the earth in a relentless search for fresh grazing.",
        overviewQuote: "Walking through this landscape is like reading a forgotten manuscript of the earth—every shadow tells a secret, and every sunrise is a revelation.",
        experience: {
            atmosphere: "The air in the Serengeti is charged with a raw, ancient energy. In the early morning, a golden mist clings to the plains, and the only sound is the distance roar of a pride or the rhythmic thrum of millions of hooves. It is a place that makes you feel both incredibly small and profoundly connected to the pulse of the planet.",
            wildlife: "Beyond the legendary migration, the Serengeti is a sanctuary for the Big Five. Apex predators—lions, leopards, and cheetahs—patrol the vast horizons with an intensity that is palpable. Every turn of the trail offers a new masterclass in survival, from the silent calculation of a hunt to the protective grace of an elephant matriarch.",
            impact: "A journey here is more than a safari; it is a pilgrimage to the soul of the wild. The scale of the landscape and the sheer volume of life instill a sense of awe that remains long after the dust has settled on your boots."
        },
        atmosphereVitals: [
            { label: "Sensory Vibe", text: "Charged with raw, ancient energy." },
            { label: "Audio Profile", text: "Distant predator calls & thrum of millions of hooves." },
            { label: "Visibility", text: "Endless horizons with golden morning mist." },
            { label: "Ambient Temp", text: "Crisp 14°C at dawn to 28°C at meridian." }
        ],
        atmosphereFooter: "A place that makes you feel both small and connected.",
        wildlifeVitals: [
            { label: "Predator Stat", text: "Highest density of lions and cheetahs in Africa." },
            { label: "Key Species", text: "The Big Five + 2 Million migrating ungulates." },
            { label: "Bio Profile", text: "Primal theatre of masterclass survival." },
            { label: "Encounter Prob", text: "95.8% (Historical Data Archive)" }
        ],
        wildlifeFooter: "Satellite GPS integration for active pride tracking.",
        encounterRate: "95.8%",
        expeditionTier: "Prestige Tier 01",
        trackingMethod: "Satellite GPS Tracking",
        heroImg: visualsData.destinations.serengetiHero,
        coordinates: "2.3333° S, 34.8333° E",
        elevation: "920m – 1,850m",
        highlights: ["The Great Migration", "River Crossings", "Big Five Territory", "Endless Horizons", "Hot Air Ballooning"],
        duration: "3–5 Days",
        bestTime: "June to October (River Crossings) / Jan to March (Calving)",
        wildlifeList: ["Wildebeest", "Lion", "Leopard", "Cheetah", "Elephant", "Giraffe"],
        gallery: visualsData.destinations.serengetiGallery
    },
    {
        id: "ngorongoro",
        name: "Ngorongoro Crater",
        subtitle: "The Lost World",
        tag: "UNESCO CALDERA",
        shortDesc: "Descend into an ancient, unbroken volcanic caldera. This self-contained ecosystem is a sanctuary where endangered black rhinos, apex predators, and flamingos coexist in staggering density.",
        overview: "Often referred to as the 'Eighth Wonder of the World,' the Ngorongoro Crater is a breathtaking natural amphitheater. Formed millions of years ago when a giant volcano exploded and collapsed on itself, the 600-meter deep caldera now harbors a unique microclimate and an incredibly dense population of wildlife.",
        overviewQuote: "To stand on the rim and gaze into the depths is to witness nature's most perfect amphitheater—a world enclosed, eternal, and utterly alive.",
        experience: {
            atmosphere: "Descending into the crater floor feels like stepping back into a prehistoric era. The high walls create a literal world apart, where the morning fog dissolves to reveal a shimmering floor of salt pans, lush forests, and teeming grasslands. The silence here is heavy and sacred.",
            wildlife: "The concentration of wildlife is unparalleled. Within a single day, you can encounter the rare black rhino, witness lions stalking buffalo in the tall grass, and watch thousands of flamingos paint Lake Magadi in shades of pink. It is a self-contained Eden where the drama of life plays out in high definition.",
            impact: "Standing on the rim and looking into the depths of the caldera is a humbling experience. It serves as a powerful reminder of nature's architectural genius and its resilience when protected."
        },
        atmosphereVitals: [
            { label: "Sensory Vibe", text: "Prehistoric calm within volcanic walls." },
            { label: "Audio Profile", text: "Sacred silence broken by flamingo calls." },
            { label: "Visibility", text: "600m deep caldera with panoramic rim views." },
            { label: "Ambient Temp", text: "Cool 10°C at rim to 24°C on crater floor." }
        ],
        atmosphereFooter: "A world apart, enclosed and eternal.",
        wildlifeVitals: [
            { label: "Predator Stat", text: "Highest lion density per square km in Africa." },
            { label: "Key Species", text: "Big Five including critically endangered black rhino." },
            { label: "Bio Profile", text: "Self-contained Eden, a microcosm of East Africa." },
            { label: "Encounter Prob", text: "98.2% (Enclosed ecosystem)" }
        ],
        wildlifeFooter: "UNESCO World Heritage Site, protected since 1979.",
        encounterRate: "98.2%",
        expeditionTier: "Prestige Tier 01",
        trackingMethod: "Crater Floor GPS Grid",
        heroImg: visualsData.destinations.ngorongoroHero,
        coordinates: "3.2000° S, 35.5000° E",
        elevation: "2,286m (Rim)",
        highlights: ["Endangered Black Rhino", "Crater Floor Drives", "Maasai Coexistence", "Dense Lion Population", "Lake Magadi Flamingos"],
        duration: "1–2 Days",
        bestTime: "Year-Round (Wildlife does not migrate out)",
        wildlifeList: ["Black Rhino", "Lion", "Elephant", "Buffalo", "Hyena", "Flamingo"],
        gallery: visualsData.destinations.ngorongoroGallery
    },
    {
        id: "tarangire",
        name: "Tarangire",
        subtitle: "Land of Giants",
        tag: "ELEPHANT REALM",
        shortDesc: "Walk in the shadow of ancient baobab trees and encounter the largest elephant herds in Tanzania. The park is a quiet, stunningly beautiful landscape carved by the Tarangire River.",
        overview: "Tarangire is the quiet giant of the northern circuit. Dominated by the serpentine path of the Tarangire River and punctuated by massive, ancient baobab trees, the landscape feels primal and untouched. During the dry season, it becomes a crucial refuge for wildlife.",
        overviewQuote: "In the shade of a thousand-year baobab, with the river whispering below and elephants drifting like grey clouds—this is Africa at its most honest.",
        experience: {
            atmosphere: "Tarangire possesses a rugged, silvery beauty unlike any other park. The massive baobab trees look like ancient upside-down guardians of the savanna. The atmosphere is one of profound tranquility and untamed space, where the pace of life feels dictated more by the river's flow than the clock.",
            wildlife: "Famous for its enormous elephant families, Tarangire offers intimate encounters with these intelligent giants. You'll see them gathered at the riverbanks or seeking shade under the great trees. It is also a haven for unique birdlife and tree-climbing pythons, offering a more nuanced wildlife experience.",
            impact: "Tarangire is the perfect destination for the traveler seeking depth over spectacle. It rewards the patient observer with moments of quiet beauty and a deep sense of peace that is increasingly rare in the world."
        },
        atmosphereVitals: [
            { label: "Sensory Vibe", text: "Rugged tranquility beneath ancient baobabs." },
            { label: "Audio Profile", text: "Elephant rumbles and 550+ bird species." },
            { label: "Visibility", text: "Silvery landscapes cut by the winding river." },
            { label: "Ambient Temp", text: "Warm 18°C mornings to 32°C at midday." }
        ],
        atmosphereFooter: "Where the pace of life follows the river's flow.",
        wildlifeVitals: [
            { label: "Predator Stat", text: "Tree-climbing lions and leopards in residence." },
            { label: "Key Species", text: "Largest elephant herds in Tanzania (3,000+)." },
            { label: "Bio Profile", text: "Dry season refuge, extraordinary animal concentration." },
            { label: "Encounter Prob", text: "94.5% (Dry Season Peak)" }
        ],
        wildlifeFooter: "Home to over 550 bird species, a birder's paradise.",
        encounterRate: "94.5%",
        expeditionTier: "Heritage Tier 02",
        trackingMethod: "River System GPS Tracking",
        heroImg: visualsData.destinations.tarangireHero,
        coordinates: "3.8500° S, 36.0000° E",
        elevation: "1,100m",
        highlights: ["Massive Elephant Herds", "Ancient Baobabs", "Silvery Landscapes", "Tree-Climbing Pythons", "Incredible Birding"],
        duration: "2–3 Days",
        bestTime: "July to October (Dry Season Congregation)",
        wildlifeList: ["Elephant", "Lion", "Leopard", "Zebra", "Giraffe", "Ostrich"],
        gallery: visualsData.destinations.tarangireGallery
    }
];
