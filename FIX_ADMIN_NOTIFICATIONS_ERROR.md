# Fix for Admin Notifications Error

## Problem
The admin notifications page (`/admin/notifications`) is showing an error:
```
ErrorException: Undefined variable $adminNotifications
```

## Root Cause
The production server has cached routes that are pointing to the wrong controller. The route should be calling `App\Http\Controllers\Admin\AdminNotificationController@index` but the cached version might be calling a different controller.

## Solution

### Step 1: Clear All Caches on Production Server
Run the following command on the production server via SSH:

```bash
cd /path/to/infinitywearsa.com
php artisan optimize:clear
```

This command will clear:
- Configuration cache
- Application cache
- Compiled files
- Event cache
- Route cache
- View cache

### Step 2: If Step 1 Doesn't Work, Clear Individual Caches

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear
```

### Step 3: Verify the Route is Correct

```bash
php artisan route:list --name=admin.notifications.index
```

You should see:
```
GET|HEAD  admin/notifications  admin.notifications.index › Admin\AdminNotificationController@index
```

### Step 4: If Using OPcache, Restart PHP-FPM

If the server uses OPcache, you need to restart PHP-FPM:

```bash
# For Ubuntu/Debian
sudo systemctl restart php8.2-fpm

# Or for CentOS/RHEL
sudo systemctl restart php-fpm
```

### Step 5: Verify the Fix

Visit the page again: https://infinitywearsa.com/admin/notifications

The page should now load without errors.

## Verification

After applying the fix, verify that:
1. ✅ The page loads without errors
2. ✅ The admin notifications tab is visible
3. ✅ The system notifications tab is visible
4. ✅ All statistics are displayed correctly

## Technical Details

### Controller Information
- **File**: `app/Http/Controllers/Admin/AdminNotificationController.php`
- **Method**: `index()`
- **Variables Passed to View**:
  - `$adminNotifications`: Paginated list of admin notifications
  - `$adminStats`: Statistics for admin notifications (total, sent, pending, scheduled)
  - `$notifications`: System notifications
  - `$stats`: Statistics for system notifications

### Route Information
- **URL**: `/admin/notifications`
- **Name**: `admin.notifications.index`
- **Controller**: `App\Http\Controllers\Admin\AdminNotificationController@index`
- **Middleware**: `web`, `admin.auth`, `user.permission:admin_notifications`

### Database Tables
- `admin_notifications`: Stores custom admin notifications
- `notifications`: Stores system notifications

## Alternative Solution (If Above Doesn't Work)

If the above steps don't work, there might be an issue with the web server configuration. Try restarting the web server:

```bash
# For Nginx
sudo systemctl restart nginx

# For Apache
sudo systemctl restart apache2
```

## Notes

- The controller has been verified to work correctly in local testing
- All required variables are being passed to the view
- The route is correctly configured
- The database tables exist and are accessible
- The issue is most likely due to cached routes on the production server

## Quick Command for Server Admin

Copy and paste this single command to fix the issue:

```bash
cd /path/to/infinitywearsa.com && php artisan optimize:clear && php artisan config:cache && php artisan route:cache && php artisan view:cache && sudo systemctl restart php8.2-fpm && sudo systemctl restart nginx
```

**Note**: Replace `/path/to/infinitywearsa.com` with the actual path to the application and `php8.2-fpm` with the correct PHP-FPM version if different.

