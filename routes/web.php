<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Tanzania Sensational
|--------------------------------------------------------------------------
| All non-API routes serve the React SPA via the Blade template.
| API routes are defined in routes/api.php.
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
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Page;
use App\Models\BlogPost;
use App\Models\TrekkingRoute;
use App\Models\SafariPackage;
use App\Models\Destination;

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
        Route::delete('/admin/users/{id}', [AdminUsersController::class, 'destroy'])->middleware(['can:manage-users']);

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

    $paths = collect([
        '/',
        '/about',
        '/contact',
        '/safaris',
        '/blog',
        '/group-departures',
        '/gear-checklist',
    ]);

    $paths = $paths->merge(
        TrekkingRoute::query()->select('slug')->get()->map(fn ($r) => '/trekking/kilimanjaro/' . $r->slug)
    );

    $paths = $paths->merge(
        BlogPost::query()->whereNotNull('published_at')->select('slug')->get()->map(fn ($p) => '/blog/' . $p->slug)
    );

    $paths = $paths->merge(
        Destination::query()->select('id')->get()->map(fn ($d) => '/safaris/destinations/' . $d->id)
    );

    $paths = $paths->merge(
        SafariPackage::query()->select('id')->get()->map(fn ($p) => '/safaris/packages/' . $p->id)
    );

    $paths = $paths->merge(
        Page::query()
            ->select('slug')
            ->where('slug', 'like', 'company-%')
            ->get()
            ->map(fn ($p) => '/company/' . substr($p->slug, strlen('company-')))
    );

    $paths = $paths->merge(
        Page::query()
            ->select('slug')
            ->where('slug', 'like', 'safari-guide-%')
            ->get()
            ->map(fn ($p) => '/safari-guide/' . substr($p->slug, strlen('safari-guide-')))
    );

    $urls = $paths
        ->unique()
        ->values()
        ->map(fn ($path) => ['loc' => $base . ($path === '/' ? '' : $path)]);

    $xml = view('sitemap', ['urls' => $urls]);
    return response($xml, 200)->header('Content-Type', 'application/xml');
});

Route::get('/{any}', function (Request $request) {
    $appUrl = rtrim((string)config('app.url', url('/')), '/');
    $path = '/' . ltrim($request->path(), '/');
    if ($path === '/.') $path = '/';
    if ($path === '//') $path = '/';

    $meta = [
        'title' => 'Tanzania Sensational — Kilimanjaro & Meru Trekking',
        'description' => 'Premium Kilimanjaro & Meru trekking expeditions, Tanzania safaris, and Zanzibar beach extensions. Expert-led adventures since 2010.',
        'og_title' => 'Tanzania Sensational — Kilimanjaro & Meru Trekking',
        'og_description' => 'Premium Kilimanjaro & Meru trekking expeditions, Tanzania safaris, and Zanzibar beach extensions.',
        'og_image' => null,
        'canonical' => $appUrl . ($path === '/' ? '' : $path),
        'schema' => null,
    ];

    // CMS pages
    $pageSlug = match ($path) {
        '/' => 'home',
        '/about' => 'about',
        '/contact' => 'contact',
        default => null,
    };

    if (!$pageSlug && str_starts_with($path, '/company/')) {
        $tail = trim(substr($path, strlen('/company/')), '/');
        if ($tail !== '') $pageSlug = 'company-' . $tail;
    }

    if (!$pageSlug && str_starts_with($path, '/safari-guide/')) {
        $tail = trim(substr($path, strlen('/safari-guide/')), '/');
        if ($tail !== '') $pageSlug = 'safari-guide-' . $tail;
    }

    if ($pageSlug) {
        $page = Page::where('slug', $pageSlug)->first();
        if ($page) {
            $meta['title'] = $page->meta_title ?: ($page->title ?: $meta['title']);
            $meta['description'] = $page->meta_description ?: $meta['description'];
            $meta['og_title'] = $meta['title'];
            $meta['og_description'] = $meta['description'];
            $meta['og_image'] = $page->og_image ?: null;
            $meta['schema'] = [
                '@context' => 'https://schema.org',
                '@type' => 'WebPage',
                'name' => $meta['title'],
                'description' => $meta['description'],
                'url' => $meta['canonical'],
            ];
        }
    }

    // Blog posts
    if (str_starts_with($path, '/blog/')) {
        $slug = trim(substr($path, strlen('/blog/')), '/');
        $post = BlogPost::where('slug', $slug)->whereNotNull('published_at')->first();
        if ($post) {
            $meta['title'] = $post->meta_title ?: ($post->title ?: $meta['title']);
            $meta['description'] = $post->meta_description ?: $meta['description'];
            $meta['og_title'] = $meta['title'];
            $meta['og_description'] = $meta['description'];
            $meta['og_image'] = $post->hero_image ?: null;
            $meta['schema'] = [
                '@context' => 'https://schema.org',
                '@type' => 'BlogPosting',
                'headline' => $post->title,
                'datePublished' => optional($post->published_at)->toAtomString(),
                'mainEntityOfPage' => $meta['canonical'],
            ];
        }
    }

    // Trekking routes
    if (str_starts_with($path, '/trekking/kilimanjaro/')) {
        $slug = trim(substr($path, strlen('/trekking/kilimanjaro/')), '/');
        $route = TrekkingRoute::where('slug', $slug)->first();
        if ($route) {
            $meta['title'] = $route->meta_title ?: ($route->name . ' Route — Kilimanjaro');
            $meta['description'] = $route->meta_description ?: Str::of((string)$route->description)->stripTags()->limit(160)->toString();
            $meta['og_title'] = $meta['title'];
            $meta['og_description'] = $meta['description'];
            $meta['og_image'] = $route->hero_image ?: null;
            $meta['schema'] = [
                '@context' => 'https://schema.org',
                '@type' => 'TouristTrip',
                'name' => $route->name . ' Route',
                'description' => $meta['description'],
                'url' => $meta['canonical'],
            ];
        }
    }

    $orgSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'Organization',
        'name' => config('app.name'),
        'url' => $appUrl,
    ];

    return view('app', [
        'meta' => $meta,
        'orgSchema' => $orgSchema,
    ]);
})->where('any', '.*');
