# Tanzania Sensational - CPanel Deployment Guide

## Issue Diagnosed
You're experiencing a "503 Service Unavailable" error after deploying to CPanel. This is typically caused by:

1. **PHP version mismatch** (requires PHP 8.2+)
2. **Missing dependencies** (vendor directory not properly deployed)
3. **Incorrect file permissions** (storage directories not writable)
4. **.htaccess configuration issues**
5. **Environment configuration problems**

## Files Created/Modified for Fix

### 1. Updated `.htaccess` 
- Enhanced CPanel compatibility
- Added security headers
- Improved rewrite rules
- Added PHP configuration for CPanel

### 2. Updated `.cpanel.yml`
- More robust deployment tasks
- Better error handling
- Proper permission setting
- Frontend build integration

### 3. Diagnostic Files
- `phpinfo.php` - Check PHP configuration on server
- `health-check.php` - Comprehensive Laravel health check
- **IMPORTANT**: Remove these files after debugging for security

## Steps to Fix Your Deployment

### Step 1: Check PHP Version on CPanel
1. Log into your CPanel
2. Go to "Select PHP Version" or "MultiPHP Manager"
3. Ensure PHP 8.2 or higher is selected
4. Enable required extensions: `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `openssl`, `fileinfo`

### Step 2: Upload Fixed Files
Upload the following updated files to your CPanel:
- `.htaccess` (updated version)
- `.cpanel.yml` (updated version)

### Step 3: Run Deployment Tasks
If using CPanel Deployment:
1. Go to "Git™ Version Control" in CPanel
2. Select your repository
3. Click "Manage" then "Update from Remote"
4. The updated `.cpanel.yml` will automatically run deployment tasks

If manual deployment:
```bash
# SSH into your CPanel or use File Manager terminal
composer install --no-dev --optimize-autoloader
php artisan key:generate --force
chmod -R 755 storage bootstrap/cache
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Step 4: Set Correct Permissions
```bash
# These commands fix common permission issues
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod -R 755 storage bootstrap/cache
chmod 755 artisan
```

### Step 5: Update Environment Configuration
Create/update `.env` file on CPanel with production settings:

```env
APP_NAME="Tanzania Sensational"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database configuration (get from CPanel MySQL databases)
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password

# Session configuration
SESSION_DRIVER=database
SESSION_LIFETIME=120
```

### Step 6: Test Deployment
1. Upload `phpinfo.php` and `health-check.php` temporarily
2. Visit `https://yourdomain.com/phpinfo.php` - check PHP version and extensions
3. Visit `https://yourdomain.com/health-check.php` - diagnose Laravel issues
4. Remove diagnostic files after testing

## Common 503 Error Causes and Solutions

### 1. PHP Version Too Low
**Solution**: Upgrade to PHP 8.2+ in CPanel MultiPHP Manager

### 2. Missing Composer Dependencies
**Solution**: Run `composer install --no-dev --optimize-autoloader` on server

### 3. Storage Directory Permissions
**Solution**: 
```bash
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

### 4. .htaccess Issues
**Solution**: Use the updated `.htaccess` file provided

### 5. Database Connection Issues
**Solution**: Verify database credentials in `.env` match CPanel MySQL settings

### 6. Memory Limit Exceeded
**Solution**: Add to `.htaccess` or `php.ini`:
```
php_value memory_limit 256M
php_value max_execution_time 300
```

## Verification Steps

After applying fixes:

1. **Clear browser cache** and visit your site
2. **Check error logs** in CPanel → Error Log or `storage/logs/laravel.log`
3. **Test API endpoints** if applicable
4. **Verify database connectivity**

## Rollback Plan

If issues persist:
1. Restore from backup
2. Contact hosting support with error logs
3. Check CPanel error logs at `/home/username/logs/error_log`

## Support

If you continue to experience 503 errors:
1. Check CPanel error logs
2. Enable detailed error reporting temporarily by setting `APP_DEBUG=true` in `.env`
3. Contact hosting provider with specific error messages

**Remember to remove diagnostic files (`phpinfo.php`, `health-check.php`) after debugging!**