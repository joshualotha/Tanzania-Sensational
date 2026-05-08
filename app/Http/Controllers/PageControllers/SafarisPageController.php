<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\SafariPackage;
use Inertia\Inertia;

class SafarisPageController extends Controller
{
    /**
     * Display the safaris listing page with all destinations.
     */
    public function index()
    {
        $destinations = Destination::all();
        $appUrl = rtrim((string)config('app.url', url('/')), '/');

        $breadcrumbs = $this->buildBreadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Safaris', 'url' => '/safaris'],
        ]);

        return Inertia::render('SafarisPage', [
            'destinations' => $destinations,
            'meta' => [
                'title' => 'Tanzania Safaris | Wildlife Tours & Safari Packages | Tanzania Sensational',
                'description' => 'Explore Tanzania\'s best safari destinations — Serengeti, Ngorongoro Crater, Tarangire, Lake Manyara & more. Book your Tanzania safari adventure with expert guides.',
                'og_title' => 'Tanzania Safaris | Wildlife Tours & Safari Packages',
                'og_description' => 'Explore Tanzania\'s best safari destinations with Tanzania Sensational.',
                'og_image' => null,
                'canonical' => $appUrl . '/safaris',
                'schema' => [$breadcrumbs],
            ],
        ]);
    }

    /**
     * Display the safari packages listing page.
     */
    public function packagesList()
    {
        $packages = SafariPackage::all();
        $appUrl = rtrim((string)config('app.url', url('/')), '/');

        $breadcrumbs = $this->buildBreadcrumbs([
            ['label' => 'Home', 'url' => '/'],
            ['label' => 'Safaris', 'url' => '/safaris'],
            ['label' => 'Packages', 'url' => '/safaris/packages'],
        ]);

        return Inertia::render('safaris/SafariPackagesList', [
            'packages' => $packages,
            'meta' => [
                'title' => 'Tanzania Safari Packages | Serengeti & Zanzibar Tours | Tanzania Sensational',
                'description' => 'Browse our Tanzania safari packages — from 7-day budget safaris to 14-day luxury adventures including Serengeti, Ngorongoro, and Zanzibar. Book your dream safari.',
                'og_title' => 'Tanzania Safari Packages | Serengeti & Zanzibar Tours',
                'og_description' => 'Browse Tanzania safari packages from Tanzania Sensational.',
                'og_image' => null,
                'canonical' => $appUrl . '/safaris/packages',
                'schema' => [$breadcrumbs],
            ],
        ]);
    }
}
