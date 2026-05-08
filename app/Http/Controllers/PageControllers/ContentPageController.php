<?php

namespace App\Http\Controllers\PageControllers;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class ContentPageController extends Controller
{
    /**
     * Build page-specific meta array from a CMS Page model.
     */
    private function buildMeta(Page $page, string $section): array
    {
        $appUrl = rtrim((string)config('app.url', url('/')), '/');
        $path = '/' . str_replace('-', '/', $section . '-' . $page->slug);

        // Build breadcrumbs based on section
        $crumbs = [['label' => 'Home', 'url' => '/']];
        if ($section === 'company') {
            $crumbs[] = ['label' => 'Company', 'url' => '/company'];
            $crumbs[] = ['label' => $page->title, 'url' => $path];
        } elseif ($section === 'safari-guide') {
            $crumbs[] = ['label' => 'Safari Guide', 'url' => '/safari-guide'];
            $crumbs[] = ['label' => $page->title, 'url' => $path];
        }
        $breadcrumbs = $this->buildBreadcrumbs($crumbs);

        return [
            'title' => $page->meta_title ?? $page->title . ' | Tanzania Sensational',
            'description' => $page->meta_description ?? strip_tags(Str::limit($page->content ?? '', 155)),
            'og_title' => $page->meta_title ?? $page->title . ' | Tanzania Sensational',
            'og_description' => $page->meta_description ?? strip_tags(Str::limit($page->content ?? '', 155)),
            'og_image' => null,
            'canonical' => $appUrl . $path,
            'schema' => [$breadcrumbs],
        ];
    }

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
            'meta' => $this->buildMeta($pageModel, $fixedSection),
        ]);
    }
}
