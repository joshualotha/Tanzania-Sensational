# SSR Architecture Plan — Tanzania Sensational

## 1. Problem Statement

The site is a **pure Client-Side Rendering (CSR)** React SPA. Every page load requires:

1. Download & parse ~1.3 MB JS bundle (main + vendor + motion + icons + charts)
2. Execute React to mount the app
3. Fire API calls from 3 context providers (Auth, Settings, Visuals)
4. Fire additional API calls from page components
5. Finally render content

This causes:
- **Slow perceived load**: blank screen while JS parses, then "Loading…" text
- **SEO indexability risk**: Google *may* render JS but doesn't always wait for API waterfalls
- **Poor Core Web Vitals**: LCP is delayed until API responses return

## 2. Approach Comparison

| Approach | Effort | SEO Fix | Performance Fix | Maintainability |
|----------|--------|---------|-----------------|-----------------|
| **Inertia.js** (recommended) | Medium | ✅ Full | ✅ Full | ✅ Single codebase |
| **Laravel SSR with Vite** | High | ✅ Full | ✅ Full | ⚠️ Complex tooling |
| **Node SSR middleware** | Very High | ✅ Full | ✅ Full | ❌ Two runtimes |
| **Static Site Generation** | High | ✅ Full | ✅ Best | ⚠️ Dynamic content hard |

## 3. Recommended Approach: Inertia.js

### Why Inertia.js?

- **Laravel-native**: built by the Laravel ecosystem, first-class support
- **No API duplication**: controllers return data directly to React components — no need for separate API routes for public pages
- **SSR built-in**: Inertia v2 has official SSR support via Node
- **Incremental migration**: you can migrate page-by-page, keeping existing React components mostly intact
- **Same React components**: your existing `BlogDetail.jsx`, `BlogList.jsx`, etc. work with minimal changes
- **No Vue needed**: Inertia supports React as a first-class adapter

### Architecture Overview

```
┌─────────────────────────────────────────────────────────┐
│                      Browser                             │
│  ┌──────────────────────────────────────────────────┐   │
│  │  Inertia React App (hydrated)                     │   │
│  │  - Navbar, Footer, Layout (same as now)           │   │
│  │  - Page components (same as now, minor tweaks)    │   │
│  │  - No more axios API calls for public pages       │   │
│  └──────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
                          ↕ Inertia protocol (JSON)
┌─────────────────────────────────────────────────────────┐
│                   Laravel Server                         │
│  ┌──────────────────────────────────────────────────┐   │
│  │  Inertia Middleware                               │   │
│  │  ┌─────────────┐  ┌──────────────────────────┐   │   │
│  │  │ SSR Renderer │  │ Inertia Controllers      │   │   │
│  │  │ (Node)       │  │ - Return props to React  │   │   │
│  │  └─────────────┘  │ - No JSON API needed      │   │   │
│  │                    └──────────────────────────┘   │   │
│  └──────────────────────────────────────────────────┘   │
└─────────────────────────────────────────────────────────┘
```

### Data Flow (Before vs After)

**Current (CSR):**
```
Browser → Laravel (Blade shell) → Browser renders empty #root
  → JS downloads & parses → React mounts
    → axios.get('/api/settings') → wait → render settings
    → axios.get('/api/visual-assets') → wait → render visuals
    → axios.get('/api/blog/some-slug') → wait → render blog
```

**With Inertia SSR:**
```
Browser → Laravel (Inertia) → Node SSR renders full HTML
  → Browser displays HTML immediately (LCP achieved)
  → React hydrates (attaches event handlers)
  → Subsequent navigations use Inertia protocol (JSON only, no full reload)
```

## 4. Migration Plan

### Phase 1: Install & Configure Inertia

| Step | File(s) | What Changes |
|------|---------|-------------|
| 1.1 | `composer.json` | Add `inertiajs/inertia-laravel` |
| 1.2 | `package.json` | Add `@inertiajs/react`, `@inertiajs/server` |
| 1.3 | `vite.config.js` | Add Inertia SSR plugin |
| 1.4 | `bootstrap/app.php` | Register Inertia middleware |
| 1.5 | `resources/views/app.blade.php` | Replace with Inertia root template |
| 1.6 | `resources/js/main.jsx` | Replace ReactDOM.createRoot with Inertia App |
| 1.7 | `resources/js/ssr.jsx` | **New** — SSR entry point |
| 1.8 | `routes/web.php` | Convert catch-all route to Inertia render |

### Phase 2: Convert Public Pages (Page-by-Page)

Each page follows the same pattern:

**Before (current):**
```php
// routes/api.php
Route::get('/blog/{slug}', [BlogController::class, 'show']);

// BlogController.php
public function show($slug) {
    return BlogPost::where('slug', $slug)->firstOrFail();
}

// BlogDetail.jsx
const [post, setPost] = useState(null);
useEffect(() => {
    axios.get(`/api/blog/${slug}`).then(res => setPost(res.data));
}, [slug]);
```

**After (Inertia):**
```php
// routes/web.php (no separate API route needed for public)
Route::get('/blog/{slug}', [BlogPageController::class, 'show']);

// BlogPageController.php
public function show($slug) {
    $post = BlogPost::where('slug', $slug)->whereNotNull('published_at')->firstOrFail();
    return Inertia::render('blog/BlogDetail', [
        'post' => $post,
        'allPosts' => BlogPost::whereNotNull('published_at')->orderByDesc('published_at')->get(),
    ]);
}

// BlogDetail.jsx (simplified — no useEffect for fetching)
export const BlogDetail = ({ post, allPosts }) => {
    // post and allPosts are already available as props
    // No loading state needed for initial render
};
```

### Phase 3: Pages to Convert (Priority Order)

| Priority | Page | Current API Calls | Complexity |
|----------|------|-------------------|------------|
| P0 | Blog Detail | `getBySlug` + `getAll` | Low |
| P0 | Blog List | `getAll` | Low |
| P1 | Home Page | None (static) | Trivial |
| P1 | Safari Package Detail | `getById` | Low |
| P1 | Destination Detail | `getById` | Low |
| P2 | Content Pages | `getBySlug` | Low |
| P2 | Trekking Route Pages | `getBySlug` | Low |
| P3 | Booking Page | Various | Medium |
| P3 | Admin Pages | Many API calls | High (keep as CSR) |

### Phase 4: SSR Setup

| Step | What | Details |
|------|------|---------|
| 4.1 | Install Node SSR package | `@inertiajs/server` with React renderer |
| 4.2 | Create SSR entry | `resources/js/ssr.jsx` — renders app to string |
| 4.3 | Configure Vite SSR | Add SSR build config in `vite.config.js` |
| 4.4 | Start SSR daemon | Node process that pre-renders pages |
| 4.5 | Update deployment | cPanel: start SSR process, keep alive |

### Phase 5: Remove Redundant API Routes

Once a page is converted to Inertia, its corresponding API route in `routes/api.php` is no longer needed for public consumption (keep for admin panel if still used).

## 5. Key Technical Decisions

### 5.1 Keep Admin Panel as CSR

The admin panel (`/ops-7f3d/*`) has 15+ CRUD pages with complex state management. Converting these to Inertia would be high effort with low benefit (admin users don't need SEO). Keep admin as-is with the current API-based approach.

### 5.2 Context Providers → Inertia Shared Data

Current context providers that fetch on mount:
- **SettingsContext** → Replace with Inertia shared data (available on every page without fetching)
- **VisualsContext** → Replace with Inertia shared data
- **AuthContext** → Keep as-is (needs client-side session management)

```php
// In AppServiceProvider or middleware
Inertia::share('settings', fn () => SiteSetting::all()->pluck('value', 'key'));
Inertia::share('visuals', fn () => VisualAsset::all()->groupBy('section')->map->pluck('url'));
```

### 5.3 Framer Motion Compatibility

`framer-motion` animations work in SSR but require:
- Wrap animated elements in `AnimatePresence` with `mode="wait"`
- Use `initial={false}` for elements that should animate on mount
- Motion components render server-side as static HTML, then animate on hydration

### 5.4 Deployment Considerations

Current hosting: cPanel shared hosting. SSR requires a Node process:

**Option A: Separate Node SSR server**
- Run a small Node process on a different port (e.g., 13714)
- Laravel proxies SSR requests to this port
- Requires persistent process management (use PM2 or supervisor)

**Option B: Serverless SSR (Laravel Vapor)**
- Migrate to Laravel Vapor (AWS Lambda)
- SSR runs as a Lambda function
- Higher cost but zero server management

**Option C: Skip SSR, use Inertia without SSR**
- Inertia works without SSR (same as current CSR but with server-driven props)
- Still eliminates API waterfall — data arrives with the page
- Much simpler deployment (no Node process needed)
- Still fixes performance (no API calls) but NOT SEO (content still JS-rendered)

**Recommendation: Option C first, then Option A**

Deploy Inertia without SSR first to eliminate the API waterfall. Then add SSR as a separate step once the migration is stable.

## 6. File Changes Summary

### New Files
```
resources/js/ssr.jsx                          # SSR entry point
app/Http/Controllers/PageControllers/         # New directory for Inertia page controllers
  BlogPageController.php
  SafariPageController.php
  TrekkingPageController.php
  ContentPageController.php
```

### Modified Files
```
composer.json                                 # Add inertia-laravel
package.json                                  # Add @inertiajs/react, @inertiajs/server
vite.config.js                                # Add SSR build config
bootstrap/app.php                             # Add Inertia middleware
resources/views/app.blade.php                 # Replace with Inertia root template
resources/js/main.jsx                         # Replace with Inertia setup
resources/js/App.jsx                          # Replace React Router with Inertia router
resources/js/context/SettingsContext.jsx       # Replace with Inertia shared data
resources/js/context/VisualsContext.jsx        # Replace with Inertia shared data
resources/js/pages/blog/BlogDetail.jsx         # Convert to Inertia page component
resources/js/pages/blog/BlogList.jsx           # Convert to Inertia page component
resources/js/pages/safaris/SafariPackageDetail.jsx  # Convert to Inertia page component
resources/js/pages/safaris/DestinationDetail.jsx    # Convert to Inertia page component
resources/js/pages/content/ContentPage.jsx     # Convert to Inertia page component
routes/web.php                                # Replace catch-all with named routes
routes/api.php                                # Remove public-facing API routes (keep admin)
```

### Deleted Files (after migration complete)
```
resources/js/utils/apiCache.js                # No longer needed (data arrives with page)
resources/js/components/ui/SkeletonLoader.jsx  # No longer needed (initial render is server HTML)
```

## 7. Migration Sequence (Execution Order)

```
Week 1: Install Inertia + convert Blog pages
  Day 1: Install packages, configure Vite, create root template
  Day 2: Convert BlogDetail + BlogList to Inertia
  Day 3: Test, fix issues, verify SSR props

Week 2: Convert Safari + Destination pages
  Day 1: Convert SafariPackageDetail + DestinationDetail
  Day 2: Convert ContentPage + Trekking route pages
  Day 3: Test all public pages

Week 3: Shared data + Context removal
  Day 1: Replace SettingsContext with Inertia shared data
  Day 2: Replace VisualsContext with Inertia shared data
  Day 3: Remove unused API routes, clean up

Week 4: SSR setup + deployment
  Day 1: Configure SSR build, create SSR entry
  Day 2: Deploy to staging, test SSR rendering
  Day 3: Deploy to production, monitor
```

## 8. Risk Assessment

| Risk | Likelihood | Impact | Mitigation |
|------|-----------|--------|------------|
| Framer Motion breaks SSR | Medium | High | Use `dynamic(() => import(), { ssr: false })` for heavy animation components |
| Inertia v2 compatibility | Low | High | Pin versions, test thoroughly |
| cPanel doesn't support Node SSR | High | High | Deploy without SSR first (Option C), then evaluate Vapor or dedicated server |
| Large migration scope | Medium | Medium | Migrate page-by-page, keep old API routes until all pages converted |
| Admin panel breaks | Low | High | Keep admin as CSR, don't touch admin routes |

## 9. Rollback Plan

1. Keep all existing API routes in `routes/api.php` during migration
2. Keep old `resources/views/app.blade.php` as backup
3. If Inertia causes issues, revert `routes/web.php` catch-all to return `view('app')`
4. The old CSR app remains fully functional — Inertia only affects how pages are served

## 10. Success Metrics

| Metric | Current | Target |
|--------|---------|--------|
| LCP (Largest Contentful Paint) | ~4-6s | < 1.5s |
| TTFB (Time to First Byte) | ~200ms | ~200ms (same) |
| FCP (First Contentful Paint) | ~2-3s | < 0.5s |
| API calls per page load | 3-5 | 0 (data in page props) |
| JS bundle size | ~1.3 MB | ~1.3 MB (same, but not blocking render) |
| Google indexed pages | Unknown | All pages indexed |
