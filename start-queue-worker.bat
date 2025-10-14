@echo off
echo Starting Laravel Queue Worker...
echo This will process email notifications in the background
echo Press Ctrl+C to stop the worker
echo.

cd /d "F:\infinity\Infinity-Wear"

php artisan queue:work --daemon --sleep=3 --tries=3 --max-time=3600

pause
