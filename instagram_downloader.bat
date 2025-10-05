@echo off
echo ========================================
echo    Instagram Downloader - Infinity Wear
echo ========================================
echo.

REM Create directories if they don't exist
if not exist "images\instagram_downloads" mkdir "images\instagram_downloads"
if not exist "images\portfolio" mkdir "images\portfolio"

echo تم إنشاء المجلدات المطلوبة...
echo.

echo تعليمات التنزيل:
echo 1. انتقل إلى حساب إنستغرام @infinityw.sa
echo 2. انقر على الصورة التي تريد تنزيلها
echo 3. انقر على النقاط الثلاث (...) في الزاوية العلوية
echo 4. اختر "نسخ الرابط" أو "Copy Link"
echo 5. استخدم أحد المواقع التالية لتنزيل الصورة:
echo.
echo    - https://savegram.app/ar
echo    - https://insaver.net/ar/photo/
echo    - https://snapinsta.to/ar/
echo.

echo بعد تنزيل الصور:
echo 1. احفظ الصور في مجلد images\instagram_downloads
echo 2. أعد تسمية الصور بأسماء وصفية (مثل: football_team_1.jpg)
echo 3. انسخ الصور إلى مجلد images\portfolio
echo 4. شغل update_portfolio.php لتحديث الموقع
echo.

pause
