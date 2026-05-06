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

        return Inertia::render('SafarisPage', [
            'destinations' => $destinations,
        ]);
    }

    /**
     * Display the safari packages listing page.
     */
    public function packagesList()
    {
        $packages = SafariPackage::all();

        return Inertia::render('safaris/SafariPackagesList', [
            'packages' => $packages,
        ]);
    }
}
