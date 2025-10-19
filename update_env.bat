@echo off
echo ========================================
echo    تحديث ملف .env - Infinity Wear
echo    Update .env file - Infinity Wear
echo ========================================
echo.

echo نسخ الإعدادات الجديدة...
echo Copying new settings...

copy env_complete.txt .env
if %errorlevel% neq 0 (
    echo خطأ في نسخ الملف!
    echo Error copying file!
    pause
    exit /b 1
)

echo تم نسخ الإعدادات بنجاح!
echo Settings copied successfully!
echo.

echo مسح الـ Cache...
echo Clearing cache...

php artisan config:clear
if %errorlevel% neq 0 (
    echo تحذير: فشل في مسح config cache
    echo Warning: Failed to clear config cache
)

php artisan cache:clear
if %errorlevel% neq 0 (
    echo تحذير: فشل في مسح application cache
    echo Warning: Failed to clear application cache
)

php artisan route:clear
if %errorlevel% neq 0 (
    echo تحذير: فشل في مسح route cache
    echo Warning: Failed to clear route cache
)

echo.
echo ========================================
echo    تم التحديث بنجاح!
echo    Update completed successfully!
echo ========================================
echo.
echo للاختبار:
echo For testing:
echo https://infinitywearsa.com/email-test
echo.
echo اضغط أي مفتاح للمتابعة...
echo Press any key to continue...
pause > nul
