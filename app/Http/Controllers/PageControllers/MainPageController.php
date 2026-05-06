<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Inertia\Inertia;

class MainPageController extends Controller
{
    /**
     * Display the homepage.
     */
    public function home()
    {
        $page = Page::where('slug', 'home')->first();

        return Inertia::render('HomePage', [
            'cms' => $page,
        ]);
    }

    /**
     * Display the about page.
     */
    public function about()
    {
        $page = Page::where('slug', 'about')->first();

        return Inertia::render('AboutPage', [
            'cms' => $page,
        ]);
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        $page = Page::where('slug', 'contact')->first();

        return Inertia::render('ContactPage', [
            'cms' => $page,
        ]);
    }
}
