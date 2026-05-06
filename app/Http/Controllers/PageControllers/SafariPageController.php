<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Models\SafariPackage;
use App\Models\Destination;
use Inertia\Inertia;

class SafariPageController extends Controller
{
    /**
     * Display a safari package detail page.
     */
    public function showPackage($packageId)
    {
        $pkg = SafariPackage::findOrFail($packageId);

        return Inertia::render('safaris/SafariPackageDetail', [
            'pkg' => $pkg,
        ]);
    }

    /**
     * Display a destination detail page.
     */
    public function showDestination($id)
    {
        $destination = Destination::findOrFail($id);

        return Inertia::render('safaris/DestinationDetail', [
            'destination' => $destination,
        ]);
    }
}
