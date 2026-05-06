<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContentPageController extends Controller
{
    /**
     * Display a CMS-managed content page.
     * 
     * Routes:
     *   /company/{page}        -> fixedSection='company'
     *   /safari-guide/{page}   -> fixedSection='safari-guide'
     */
    public function show(Request $request, $page)
    {
        $fixedSection = $request->route()->defaults('fixedSection', '');
        
        $slug = $fixedSection 
            ? $fixedSection . '-' . $page
            : $page;

        $pageModel = Page::where('slug', $slug)->firstOrFail();

        return Inertia::render('content/ContentPage', [
            'data' => $pageModel,
            'fixedSection' => $fixedSection,
        ]);
    }
}
