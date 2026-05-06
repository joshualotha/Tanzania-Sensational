# Tanzania Sensational — Deployment Guide

## Architecture Overview

The site uses **Inertia.js** to render all public pages server-side via Laravel. React handles interactivity on the client after the initial HTML is delivered. This means:

- **All public pages are fully indexable** by search engines — content is in the initial HTML
- **No API calls on page load** — data arrives with the HTML response via Inertia props
- **Frontend assets are pre-built** and committed to the `build/` directory — no server-side build step needed

## Deployment Methods

### Option A: CPanel Git Deployment (Recommended)

The project includes a [`.cpanel.yml`](.cpanel.yml) file that automates deployment via CPanel's Git Version Control.

1. **Push your changes to your Git repository** (GitHub, GitLab, etc.)
2. **Log into CPanel** → Go to **"Git™ Version Control"**
3. **Select your repository** → Click **"Manage"** → **"Update from Remote"**
4. The `.cpanel.yml` will automatically run:
   - `composer install --no-dev --optimize-autoloader`
   - `php artisan optimize:clear`
   - `php artisan config:cache`
   - `php artisan event:cache`
   - `php artisan view:cache`
   - `php artisan migrate --force`
   - `php artisan storage:link`
   - `php artisan optimize`

**Important:** `php artisan route:cache` is intentionally skipped because Inertia uses closure-based routes (for static page components) which cannot be serialized. Route caching is not needed — Laravel's route matching is fast enough without it.

### Option B: Manual Deployment via SSH / File Manager

```bash
# 1. Upload all files to your CPanel document root

# 2. Install PHP dependencies
composer install --no-dev --optimize-autoloader

# 3. Generate app key if not set
php artisan key:generate --force

# 4. Set correct permissions
chmod -R 755 storage bootstrap/cache database
chmod 755 artisan

# 5. Clear all caches
php artisan optimize:clear

# 6. Cache config, events, and views (NOT routes — see note above)
php artisan config:cache
php artisan event:cache
php artisan view:cache

# 7. Run migrations
php artisan migrate --force

# 8. Create storage symlink
php artisan storage:link --force

# 9. Final optimization
php artisan optimize
```

**Note:** Frontend assets are pre-built and committed to the `build/` directory. You do NOT need to run `npm install` or `npm run build` on the server. If you need to rebuild assets, run `npm run build` locally and commit the result.

## Environment Configuration

Create/update `.env` on the production server:

```env
APP_NAME="Tanzania Sensational"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tanzaniasensational.com

# Database — production uses MySQL
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

# Session
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

## Pre-Deployment Checklist

Before deploying, ensure:

- [ ] Run `npm run build` locally and commit the `build/` directory
- [ ] All new database migrations are committed
- [ ] Seeders have been run on production (if needed)
- [ ] Test locally with `php artisan serve` to verify Inertia pages render correctly

## Post-Deployment Verification

1. **Visit the homepage** — should load instantly with full HTML content
2. **Check a trekking route page** — e.g., `/trekking/kilimanjaro/machame` — should show route data without loading spinner
3. **Check a blog post** — e.g., `/blog/why-kilimanjaro` — should render full article HTML
4. **Check a 404 page** — visit `/nonexistent-page` — should show styled 404 page
5. **Check admin panel** — `/ops-7f3d/login` — should still work as CSR SPA
6. **View page source** — right-click → "View Page Source" — should contain visible content text (not just JavaScript)

## Troubleshooting

### 503 Service Unavailable
- Check PHP version (requires 8.2+)
- Check `storage/logs/laravel.log` for errors
- Run `php artisan optimize:clear` to reset all caches

### Inertia Pages Not Rendering
- Ensure `@inertiajs/react` is installed in `package.json`
- Check that `resources/js/main.jsx` uses `createInertiaApp`
- Verify `resources/views/app.blade.php` has `@inertia` directive

### Route Caching Error
If you see `RuntimeException: Unable to prepare route ... for serialization. Uses Closure.`:
- This is expected — Inertia uses closure-based routes for static pages
- Simply remove `php artisan route:cache` from your deployment script
- The site works fine without route caching

### Diagnostic Files
- `phpinfo.php` — Check PHP configuration on server
- `health-check.php` — Comprehensive Laravel health check
- **Remove these files after debugging for security**