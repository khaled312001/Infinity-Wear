<?php

// إعداد مفاتيح VAPID للاختبار
$vapidKeys = [
    'public' => 'BEl62iUYgUivxIkv69yViEuiBIa40HI0QY-DRhkJjlbHUsQ_8j0ONQZfpb3ywsxcrkAIzHFrLyxcc96S0XgL0B8',
    'private' => 'yT78whF0YOwu9kzfuUaUfAGRINBoc7ync0PTQmI7pK0'
];

echo "=== إعداد Push Notifications ===\n";
echo "مفاتيح VAPID جاهزة للاستخدام:\n\n";

echo "Public Key: " . $vapidKeys['public'] . "\n";
echo "Private Key: " . $vapidKeys['private'] . "\n\n";

echo "أضف هذه الإعدادات إلى ملف .env:\n";
echo "PUSH_NOTIFICATIONS_ENABLED=true\n";
echo "PUSH_VAPID_SUBJECT=http://127.0.0.1:8000\n";
echo "PUSH_VAPID_PUBLIC_KEY=" . $vapidKeys['public'] . "\n";
echo "PUSH_VAPID_PRIVATE_KEY=" . $vapidKeys['private'] . "\n";
echo "PUSH_DEFAULT_ICON=/images/logo.png\n";
echo "PUSH_DEFAULT_BADGE=/images/logo.png\n";
echo "PUSH_DEFAULT_URL=/admin/notifications\n\n";

echo "بعد إضافة الإعدادات:\n";
echo "1. احفظ ملف .env\n";
echo "2. شغل: php artisan config:clear\n";
echo "3. افتح Chrome وانتقل إلى: http://127.0.0.1:8000/admin/notifications/push-notifications\n";
echo "4. اضغط 'تفعيل الإشعارات'\n";
echo "5. وافق على الإذن في Chrome\n";
echo "6. اضغط 'إرسال إشعار تجريبي'\n";
echo "7. ستظهر الإشعار في شريط الإشعارات في Windows!\n\n";

echo "=== تم الإعداد ===\n";
