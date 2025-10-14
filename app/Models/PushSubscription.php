<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PushSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_type',
        'endpoint',
        'p256dh_key',
        'auth_key',
        'user_agent',
        'device_type',
        'is_active',
        'last_used_at',
        'notification_count'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_used_at' => 'datetime',
        'notification_count' => 'integer'
    ];

    /**
     * العلاقة مع المستخدم
     */
    public function user()
    {
        return $this->morphTo('user', 'user_type', 'user_id');
    }

    /**
     * الحصول على جميع الاشتراكات النشطة
     */
    public static function getActiveSubscriptions($userType = 'admin', $userId = null)
    {
        $query = self::where('is_active', true)
                    ->where('user_type', $userType);
        
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        return $query->get();
    }

    /**
     * إنشاء أو تحديث اشتراك
     */
    public static function createOrUpdate($data)
    {
        return self::updateOrCreate(
            ['endpoint' => $data['endpoint']],
            $data
        );
    }

    /**
     * تحديث آخر استخدام
     */
    public function updateLastUsed()
    {
        $this->update([
            'last_used_at' => now(),
            'notification_count' => $this->notification_count + 1
        ]);
    }

    /**
     * إلغاء تفعيل الاشتراك
     */
    public function deactivate()
    {
        $this->update(['is_active' => false]);
    }

    /**
     * تفعيل الاشتراك
     */
    public function activate()
    {
        $this->update(['is_active' => true]);
    }

    /**
     * تنظيف الاشتراكات القديمة (أكثر من 30 يوم بدون استخدام)
     */
    public static function cleanupOldSubscriptions($days = 30)
    {
        return self::where('last_used_at', '<', now()->subDays($days))
                   ->orWhere(function($query) {
                       $query->whereNull('last_used_at')
                             ->where('created_at', '<', now()->subDays($days));
                   })
                   ->delete();
    }

    /**
     * الحصول على إحصائيات الاشتراكات
     */
    public static function getStats()
    {
        return [
            'total_subscriptions' => self::count(),
            'active_subscriptions' => self::where('is_active', true)->count(),
            'admin_subscriptions' => self::where('user_type', 'admin')->where('is_active', true)->count(),
            'customer_subscriptions' => self::where('user_type', 'customer')->where('is_active', true)->count(),
            'mobile_subscriptions' => self::where('device_type', 'mobile')->where('is_active', true)->count(),
            'desktop_subscriptions' => self::where('device_type', 'desktop')->where('is_active', true)->count(),
        ];
    }
}
