<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Tanzania Sensational
|--------------------------------------------------------------------------
| Inertia.js routes for converted pages, legacy CSR catch-all for others.
*/

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TrekkingRouteController;
use App\Http\Controllers\Api\DepartureController;
use App\Http\Controllers\Api\SafariPackageController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\SiteSettingsController;
use App\Http\Controllers\Api\AdminUsersController;
use App\Http\Controllers\Api\VisualAssetController;
use App\Http\Controllers\Api\GearRentalRequestController;
use App\Http\Controllers\Api\PagesController;
use App\Http\Controllers\Api\UploadController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\PricingRuleController;
use App\Http\Controllers\Api\AdminNotificationsController;
use App\Http\Controllers\PageControllers\BlogPageController;
use App\Http\Controllers\PageControllers\SafariPageController;
use App\Http\Controllers\PageControllers\ContentPageController;
use App\Http\Controllers\PageControllers\MainPageController;
use App\Http\Controllers\PageControllers\SafarisPageController;
use App\Http\Controllers\PageControllers\TrekkingPageController;
use App\Http\Controllers\PageControllers\BookingPageController;
use App\Http\Controllers\PageControllers\PlanPageController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Page;
use App\Models\BlogPost;
use App\Models\TrekkingRoute;
use App\Models\SafariPackage;
use App\Models\Destination;

// Invalidate predictable admin entrypoints (no redirects).
Route::any('/admin/{any?}', function () {
    abort(404);
})->where('any', '.*');

Route::prefix('api')->middleware(['web'])->group(function() {
    // Auth
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::post('/logout', [AuthController::class, 'logout']);
    
    // Protected Admin Routes
    Route::middleware(['auth', 'can:access-dashboard'])->group(function () {
        Route::get('/user', [AuthController::class, 'user']);
        Route::get('/stats', [\App\Http\Controllers\Api\StatsController::class, 'index']);
        Route::get('/admin/bookings', [BookingController::class, 'index']);
        Route::put('/admin/bookings/{id}', [BookingController::class, 'update']);
        Route::delete('/admin/bookings/{id}', [BookingController::class, 'destroy']);
        Route::post('/admin/bookings/{id}/reply', [BookingController::class, 'reply']);
        
        Route::apiResource('admin/trekking-routes', TrekkingRouteController::class)->except(['index', 'show']);
        Route::apiResource('admin/departures', DepartureController::class)->except(['index', 'show']);
        Route::apiResource('admin/safari-packages', SafariPackageController::class)->except(['index', 'show']);
        Route::apiResource('admin/destinations', DestinationController::class)->except(['index', 'show']);
        Route::apiResource('admin/blog', \App\Http\Controllers\Api\BlogController::class)->except(['index', 'show']);
        Route::get('/admin/blog', [BlogController::class, 'adminIndex']);
        // Visual assets (key-based)
        Route::get('/admin/visual-assets', [VisualAssetController::class, 'index']);
        Route::post('/admin/visual-assets', [VisualAssetController::class, 'store'])->middleware(['can:manage-settings']);
        Route::get('/admin/visual-assets/{key}', [VisualAssetController::class, 'show']);
        Route::put('/admin/visual-assets/{key}', [VisualAssetController::class, 'update'])->middleware(['can:manage-settings']);
        Route::delete('/admin/visual-assets/{key}', [VisualAssetController::class, 'destroy'])->middleware(['can:manage-settings']);
        
        Route::get('/admin/inquiries', [\App\Http\Controllers\Api\ContactController::class, 'index']);
        Route::delete('/admin/inquiries/{id}', [\App\Http\Controllers\Api\ContactController::class, 'destroy']);

        // Site configuration (admin-only)
        Route::get('/admin/settings', [SiteSettingsController::class, 'index'])->middleware(['can:manage-settings']);
        Route::put('/admin/settings', [SiteSettingsController::class, 'upsert'])->middleware(['can:manage-settings']);

        // User management (admin-only)
        Route::get('/admin/users', [AdminUsersController::class, 'index'])->middleware(['can:manage-users']);
        Route::post('/admin/users', [AdminUsersController::class, 'store'])->middleware(['can:manage-users']);
        Route::put('/admin/users/{id}', [AdminUsersController::class, 'update'])->middleware(['can:manage-users']);

        // Gear rental requests (admin)
        Route::get('/admin/gear-rental-requests', [GearRentalRequestController::class, 'index']);
        Route::put('/admin/gear-rental-requests/{id}', [GearRentalRequestController::class, 'update']);

        // CMS Pages (admin)
        Route::get('/admin/pages', [PagesController::class, 'index']);
        Route::post('/admin/pages', [PagesController::class, 'store']);
        Route::put('/admin/pages/{slug}', [PagesController::class, 'update']);

        // Pricing rules (admin)
        Route::get('/admin/pricing-rules', [PricingRuleController::class, 'index']);
        Route::post('/admin/pricing-rules', [PricingRuleController::class, 'store']);
        Route::put('/admin/pricing-rules/{id}', [PricingRuleController::class, 'update']);
        Route::delete('/admin/pricing-rules/{id}', [PricingRuleController::class, 'destroy']);

        // Uploads (admin)
        Route::post('/admin/uploads', [UploadController::class, 'store'])->middleware(['can:manage-settings']);

        // Notifications (admin)
        Route::get('/admin/notifications', [AdminNotificationsController::class, 'index']);
        Route::post('/admin/notifications/{id}/read', [AdminNotificationsController::class, 'markRead']);
        Route::post('/admin/notifications/read-all', [AdminNotificationsController::class, 'markAllRead']);
    });
});

Route::get('/sitemap.xml', function () {
    $base = rtrim((string)config('app.url', url('/')), '/');
    $now = now()->toAtomString();

    // Static pages with fixed priorities
    $staticPages = collect([
        ['path' => '/', 'priority' => '1.0', 'changefreq' => 'weekly'],
        ['path' => '/about', 'priority' => '0.7', 'changefreq' => 'monthly'],
        ['path' => '/contact', 'priority' => '0.6', 'changefreq' => 'monthly'],
        ['path' => '/safaris', 'priority' => '0.9', 'changefreq' => 'weekly'],
        ['path' => '/blog', 'priority' => '0.8', 'changefreq' => 'weekly'],
        ['path' => '/group-departures', 'priority' => '0.7', 'changefreq' => 'weekly'],
        ['path' => '/gear-checklist', 'priority' => '0.6', 'changefreq' => 'monthly'],
    ]);

    // Trekking routes — high priority, commercial pages
    $routePages = TrekkingRoute::query()->select('slug', 'updated_at')->get()->map(fn ($r) => [
        'path' => '/trekking/kilimanjaro/' . $r->slug,
        'priority' => '0.9',
        'changefreq' => 'weekly',
        'lastmod' => $r->updated_at->toAtomString(),
    ]);

    // Blog posts — medium priority, content pages
    $blogPages = BlogPost::query()
        ->whereNotNull('published_at')
        ->select('slug', 'updated_at')
        ->get()
        ->map(fn ($p) => [
            'path' => '/blog/' . $p->slug,
            'priority' => '0.7',
            'changefreq' => 'monthly',
            'lastmod' => $p->updated_at->toAtomString(),
        ]);

    // Destinations — high priority
    $destinationPages = Destination::query()->select('slug', 'updated_at')->get()->map(fn ($d) => [
        'path' => '/safaris/destinations/' . $d->slug,
        'priority' => '0.8',
        'changefreq' => 'monthly',
        'lastmod' => $d->updated_at->toAtomString(),
    ]);

    // Safari packages — high priority, commercial
    $safariPages = SafariPackage::query()->select('slug', 'updated_at')->get()->map(fn ($p) => [
        'path' => '/safaris/packages/' . $p->slug,
        'priority' => '0.9',
        'changefreq' => 'weekly',
        'lastmod' => $p->updated_at->toAtomString(),
    ]);

    // Company pages — medium priority
    $companyPages = Page::query()
        ->select('slug', 'updated_at')
        ->where('slug', 'like', 'company-%')
        ->get()
        ->map(fn ($p) => [
            'path' => '/company/' . substr($p->slug, strlen('company-')),
            'priority' => '0.6',
            'changefreq' => 'monthly',
            'lastmod' => $p->updated_at->toAtomString(),
        ]);

    // Safari guide pages — low priority (thin content)
    $guidePages = Page::query()
        ->select('slug', 'updated_at')
        ->where('slug', 'like', 'safari-guide-%')
        ->get()
        ->map(fn ($p) => [
            'path' => '/safari-guide/' . substr($p->slug, strlen('safari-guide-')),
            'priority' => '0.5',
            'changefreq' => 'monthly',
            'lastmod' => $p->updated_at->toAtomString(),
        ]);

    $allPages = $staticPages
        ->concat($routePages)
        ->concat($blogPages)
        ->concat($destinationPages)
        ->concat($safariPages)
        ->concat($companyPages)
        ->concat($guidePages);

    $urls = $allPages
        ->unique('path')
        ->values()
        ->map(fn ($item) => [
            'loc' => $base . ($item['path'] === '/' ? '' : $item['path']),
            'lastmod' => $item['lastmod'] ?? $now,
            'changefreq' => $item['changefreq'],
            'priority' => $item['priority'],
        ]);

    $xml = view('sitemap', ['urls' => $urls]);
    return response($xml, 200)->header('Content-Type', 'application/xml');
});

/*
|--------------------------------------------------------------------------
| Admin Panel (CSR SPA via Inertia)
|--------------------------------------------------------------------------
| The admin panel is a client-side rendered SPA using React Router.
| It's served as a single Inertia page that bootstraps the full admin app.
*/
Route::get('/ops-7f3d/{any?}', function () {
    return Inertia\Inertia::render('admin/AdminApp');
})->where('any', '.*');

Route::get('/ops-7f3d', function () {
    return Inertia\Inertia::render('admin/AdminApp');
});

/*
|--------------------------------------------------------------------------
| Inertia.js Routes (Converted Pages)
|--------------------------------------------------------------------------
| These pages use Inertia.js — data is fetched server-side and passed
| directly to React components as props. No API calls needed.
*/

// Blog routes
Route::get('/blog', [BlogPageController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogPageController::class, 'show'])->name('blog.show');

// Safari package detail
Route::get('/safaris/packages/{packageId}', [SafariPageController::class, 'showPackage'])->name('safaris.packages.show');

// Destination detail
Route::get('/safaris/destinations/{id}', [SafariPageController::class, 'showDestination'])->name('safaris.destinations.show');

// Content pages (company, safari-guide)
Route::get('/company/{page}', [ContentPageController::class, 'show'])->name('content.company')->defaults('fixedSection', 'company');
Route::get('/safari-guide/{page}', [ContentPageController::class, 'show'])->name('content.safari-guide')->defaults('fixedSection', 'safari-guide');

// Main pages (home, about, contact)
Route::get('/', [MainPageController::class, 'home'])->name('home');
Route::get('/about', [MainPageController::class, 'about'])->name('about');
Route::get('/contact', [MainPageController::class, 'contact'])->name('contact');

// Safaris listing
Route::get('/safaris', [SafarisPageController::class, 'index'])->name('safaris.index');
Route::get('/safaris/tanzania', [SafarisPageController::class, 'index']);
Route::get('/safaris/kenya', [SafarisPageController::class, 'index']);
Route::get('/safaris/uganda', [SafarisPageController::class, 'index']);
Route::get('/safaris/rwanda', [SafarisPageController::class, 'index']);

// Safari packages listing (filter variants)
Route::get('/safaris/packages', [SafarisPageController::class, 'packagesList'])->name('safaris.packages.list');
Route::get('/safaris/family', [SafarisPageController::class, 'packagesList']);
Route::get('/safaris/honeymoon', [SafarisPageController::class, 'packagesList']);
Route::get('/safaris/luxury', [SafarisPageController::class, 'packagesList']);
Route::get('/safaris/photographic', [SafarisPageController::class, 'packagesList']);
Route::get('/safaris/group-joining', [SafarisPageController::class, 'packagesList']);

// Zanzibar page
Route::get('/zanzibar', function () {
    return Inertia\Inertia::render('ZanzibarPage');
})->name('zanzibar');

// Trekking routes — single parameterized route (slug extracted from URL)
Route::get('/trekking/kilimanjaro/{slug}', [TrekkingPageController::class, 'showRoute'])->name('trekking.routes.show');

// Trekking package detail (must be after the single slug route to avoid conflict)
Route::get('/trekking/kilimanjaro/{routeId}/{packageId}', [TrekkingPageController::class, 'showPackage'])->name('trekking.packages.show');
Route::get('/trekking/meru/{slug}', [TrekkingPageController::class, 'showMeruPackage'])->name('trekking.meru.show');

// Booking pages
Route::get('/booking', [BookingPageController::class, 'show'])->name('booking');
Route::get('/booking/departure/{departureId}', [BookingPageController::class, 'show'])->name('booking.departure');
Route::get('/booking/safari/{packageId}', [BookingPageController::class, 'show'])->name('booking.safari');

// Plan Your Trip pages
Route::get('/group-departures', [PlanPageController::class, 'groupDepartures'])->name('group-departures');
Route::get('/group-departures/{departureId}', [PlanPageController::class, 'departureDetail'])->name('group-departures.show');

// Static Plan Your Trip / Safari Guide pages (no API data needed, just render component)
Route::get('/gear-checklist', fn() => Inertia\Inertia::render('plan/GearChecklist'))->name('gear-checklist');
Route::get('/training-guide', fn() => Inertia\Inertia::render('plan/TrainingGuide'))->name('training-guide');
Route::get('/faq', fn() => Inertia\Inertia::render('plan/FAQ'))->name('faq');
Route::get('/safari-addons', fn() => Inertia\Inertia::render('plan/SafariAddons'))->name('safari-addons');
Route::get('/trekking/health/vaccinations', fn() => Inertia\Inertia::render('trekking/health/Vaccinations'))->name('vaccinations');
Route::get('/trekking/health/altitude-sickness', fn() => Inertia\Inertia::render('trekking/health/AltitudeSickness'))->name('altitude-sickness');
Route::get('/trekking/health/diamox', fn() => Inertia\Inertia::render('trekking/health/Diamox'))->name('diamox');
Route::get('/trekking/health/oxygen', fn() => Inertia\Inertia::render('trekking/health/Oxygen'))->name('oxygen');
Route::get('/trekking/prep/best-routes', fn() => Inertia\Inertia::render('trekking/prep/BestRoutes'))->name('best-routes');
Route::get('/trekking/prep/best-time', fn() => Inertia\Inertia::render('trekking/prep/BestTime'))->name('best-time');
Route::get('/trekking/prep/why-us', fn() => Inertia\Inertia::render('trekking/prep/WhyUs'))->name('why-us');
Route::get('/trekking/prep/tipping-guide', fn() => Inertia\Inertia::render('trekking/prep/TippingGuide'))->name('tipping-guide');
Route::get('/trekking/prep/toilets', fn() => Inertia\Inertia::render('trekking/prep/Toilets'))->name('toilets');
Route::get('/trekking/prep/park-fees', fn() => Inertia\Inertia::render('trekking/prep/ParkFees'))->name('park-fees');
Route::get('/trekking/after/training', fn() => Inertia\Inertia::render('trekking/after/Training'))->name('training');
Route::get('/trekking/after/gear-list', fn() => Inertia\Inertia::render('trekking/after/GearList'))->name('gear-list');
Route::get('/trekking/after/getting-there', fn() => Inertia\Inertia::render('trekking/after/GettingThere'))->name('getting-there');
Route::get('/trekking/after/visa', fn() => Inertia\Inertia::render('trekking/after/Visa'))->name('visa');
Route::get('/trekking/during/daily-routine', fn() => Inertia\Inertia::render('trekking/during/DailyRoutine'))->name('daily-routine');
Route::get('/trekking/during/food-and-drinks', fn() => Inertia\Inertia::render('trekking/during/FoodAndDrinks'))->name('food-and-drinks');
Route::get('/trekking/during/pack-your-daypack', fn() => Inertia\Inertia::render('trekking/during/PackYourDaypack'))->name('pack-your-daypack');
Route::get('/trekking/during/connectivity', fn() => Inertia\Inertia::render('trekking/during/Connectivity'))->name('connectivity');
Route::get('/safari-guide/what-to-wear', fn() => Inertia\Inertia::render('safari/WhatToWear'))->name('what-to-wear');
Route::get('/safari-guide/packing-guide', fn() => Inertia\Inertia::render('safari/PackingList'))->name('packing-guide');
Route::get('/safari-guide/packing-list', fn() => Inertia\Inertia::render('safari/PackingList'));
Route::get('/safari-guide/health-and-safety', fn() => Inertia\Inertia::render('safari/HealthAndSafety'))->name('health-and-safety');
Route::get('/safari-guide/local-customs', fn() => Inertia\Inertia::render('safari/SafariEtiquette'))->name('local-customs');
Route::get('/safari-guide/local-custom', fn() => Inertia\Inertia::render('safari/SafariEtiquette'));

/*
|--------------------------------------------------------------------------
| Fallback Route (404)
|--------------------------------------------------------------------------
| All public pages are now rendered via Inertia. Unknown paths return a
| 404 Inertia response, which the React app can handle gracefully.
|
| Uses a controller method (not a closure) so route:cache can serialize it.
*/
Route::fallback([MainPageController::class, 'notFound']);
