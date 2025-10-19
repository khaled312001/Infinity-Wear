<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * الحصول على الإشعارات غير المقروءة (AJAX)
     */
    public function getUnreadNotifications(Request $request): JsonResponse
    {
        try {
            $limit = $request->get('limit', 10);
            $notifications = $this->notificationService->getUnreadNotifications($limit);
            
            Log::info('Getting unread notifications', [
                'limit' => $limit,
                'count' => $notifications->count(),
                'user' => auth('admin')->user() ? auth('admin')->user()->email : 'not authenticated'
            ]);
            
            return response()->json([
                'success' => true,
                'notifications' => $notifications,
                'count' => $this->notificationService->getUnreadCount()
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting unread notifications: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تحميل الإشعارات',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * الحصول على إحصائيات الإشعارات (AJAX)
     */
    public function getNotificationStats(): JsonResponse
    {
        try {
            $stats = $this->notificationService->getNotificationStats();
            
            Log::info('Getting notification stats', [
                'stats' => $stats,
                'user' => auth('admin')->user() ? auth('admin')->user()->email : 'not authenticated'
            ]);
            
            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting notification stats: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تحميل الإحصائيات',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * تحديد إشعار كمقروء (AJAX)
     */
    public function markAsRead(Request $request): JsonResponse
    {
        $notificationId = $request->get('notification_id');
        
        if ($this->notificationService->markAsRead($notificationId)) {
            return response()->json([
                'success' => true,
                'message' => 'تم تحديد الإشعار كمقروء'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'لم يتم العثور على الإشعار'
        ], 404);
    }

    /**
     * تحديد جميع الإشعارات كمقروءة (AJAX)
     */
    public function markAllAsRead(): JsonResponse
    {
        $this->notificationService->markAllAsRead();
        
        return response()->json([
            'success' => true,
            'message' => 'تم تحديد جميع الإشعارات كمقروءة'
        ]);
    }

    /**
     * أرشفة إشعار (AJAX)
     */
    public function archiveNotification(Request $request): JsonResponse
    {
        $notificationId = $request->get('notification_id');
        
        if ($this->notificationService->archiveNotification($notificationId)) {
            return response()->json([
                'success' => true,
                'message' => 'تم أرشفة الإشعار'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'لم يتم العثور على الإشعار'
        ], 404);
    }

    /**
     * أرشفة جميع الإشعارات المقروءة (AJAX)
     */
    public function archiveRead(): JsonResponse
    {
        try {
            $count = $this->notificationService->archiveReadNotifications();
            
            return response()->json([
                'success' => true,
                'message' => "تم أرشفة {$count} إشعار مقروء",
                'count' => $count
            ]);
        } catch (\Exception $e) {
            Log::error('Error archiving read notifications: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في أرشفة الإشعارات المقروءة'
            ], 500);
        }
    }

    /**
     * معاينة تفاصيل الإشعار
     */
    public function preview(Notification $notification): JsonResponse
    {
        try {
            $html = '';
            $relatedUrl = null;
            
            switch ($notification->type) {
                case 'order':
                    $html = $this->getOrderPreviewHtml($notification);
                    // $relatedUrl = route('admin.orders.show', $notification->data['order_id'] ?? '#');
                    $relatedUrl = url('/admin/orders'); // مؤقتاً حتى يتم إنشاء صفحة عرض الطلب
                    break;
                    
                case 'contact':
                    $html = $this->getContactPreviewHtml($notification);
                    $relatedUrl = route('admin.contacts.show', $notification->data['contact_id'] ?? '#');
                    break;
                    
                case 'whatsapp':
                    $html = $this->getWhatsAppPreviewHtml($notification);
                    $relatedUrl = route('admin.whatsapp.messages');
                    break;
                    
                case 'importer_order':
                    $html = $this->getImporterOrderPreviewHtml($notification);
                    $relatedUrl = route('admin.importers.orders');
                    break;
                    
                default:
                    $html = $this->getDefaultPreviewHtml($notification);
            }
            
            return response()->json([
                'success' => true,
                'html' => $html,
                'related_url' => $relatedUrl
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ في تحميل التفاصيل: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * عرض صفحة جميع الإشعارات
     */
    public function index(Request $request)
    {
        $query = Notification::notArchived()->latest();

        // فلترة حسب النوع
        if ($request->filled('type')) {
            $query->ofType($request->type);
        }

        // فلترة حسب حالة القراءة
        if ($request->filled('status')) {
            if ($request->status === 'read') {
                $query->where('is_read', true);
            } elseif ($request->status === 'unread') {
                $query->where('is_read', false);
            }
        }

        $notifications = $query->paginate(20);
        
        // إحصائيات
        $stats = $this->notificationService->getNotificationStats();
        
        return view('admin.notifications.index', compact('notifications', 'stats'));
    }

    /**
     * HTML معاينة الطلب
     */
    private function getOrderPreviewHtml(Notification $notification): string
    {
        $data = $notification->data ?? [];
        return '
            <div class="notification-preview">
                <div class="d-flex align-items-center mb-3">
                    <div class="notification-icon me-3">
                        <i class="fas fa-shopping-cart text-success fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">طلب جديد</h5>
                        <small class="text-muted">' . $notification->created_at->format('Y-m-d H:i') . '</small>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <h6><i class="fas fa-info-circle me-2"></i>تفاصيل الطلب</h6>
                    <p class="mb-2"><strong>رقم الطلب:</strong> ' . ($data['order_number'] ?? 'غير محدد') . '</p>
                    <p class="mb-2"><strong>المبلغ:</strong> ' . ($data['total'] ?? 'غير محدد') . ' ريال</p>
                    <p class="mb-0"><strong>العميل:</strong> ' . ($data['customer_name'] ?? 'غير محدد') . '</p>
                </div>
                
                <div class="mt-3">
                    <p class="text-muted">' . $notification->message . '</p>
                </div>
            </div>
        ';
    }

    /**
     * HTML معاينة رسالة الاتصال
     */
    private function getContactPreviewHtml(Notification $notification): string
    {
        $data = $notification->data ?? [];
        return '
            <div class="notification-preview">
                <div class="d-flex align-items-center mb-3">
                    <div class="notification-icon me-3">
                        <i class="fas fa-envelope text-info fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">رسالة اتصال جديدة</h5>
                        <small class="text-muted">' . $notification->created_at->format('Y-m-d H:i') . '</small>
                    </div>
                </div>
                
                <div class="alert alert-info">
                    <h6><i class="fas fa-user me-2"></i>معلومات المرسل</h6>
                    <p class="mb-2"><strong>الاسم:</strong> ' . ($data['contact_name'] ?? 'غير محدد') . '</p>
                    <p class="mb-2"><strong>البريد الإلكتروني:</strong> ' . ($data['email'] ?? 'غير محدد') . '</p>
                    <p class="mb-2"><strong>رقم الهاتف:</strong> ' . ($data['contact_phone'] ?? 'غير محدد') . '</p>
                    <p class="mb-2"><strong>اسم الشركة:</strong> ' . ($data['contact_company'] ?? 'غير محدد') . '</p>
                    <p class="mb-0"><strong>الموضوع:</strong> ' . ($data['contact_subject'] ?? 'غير محدد') . '</p>
                </div>
                
                <div class="alert alert-light">
                    <h6><i class="fas fa-comment me-2"></i>نص الرسالة</h6>
                    <p class="mb-0">' . ($data['contact_message'] ?? 'لا يوجد نص للرسالة') . '</p>
                </div>
                
                <div class="mt-3">
                    <p class="text-muted">' . $notification->message . '</p>
                </div>
            </div>
        ';
    }

    /**
     * HTML معاينة رسالة الواتساب
     */
    private function getWhatsAppPreviewHtml(Notification $notification): string
    {
        $data = $notification->data ?? [];
        return '
            <div class="notification-preview">
                <div class="d-flex align-items-center mb-3">
                    <div class="notification-icon me-3">
                        <i class="fab fa-whatsapp text-success fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">رسالة واتساب جديدة</h5>
                        <small class="text-muted">' . $notification->created_at->format('Y-m-d H:i') . '</small>
                    </div>
                </div>
                
                <div class="alert alert-success">
                    <h6><i class="fas fa-phone me-2"></i>معلومات المرسل</h6>
                    <p class="mb-2"><strong>الاسم:</strong> ' . ($data['contact_name'] ?? 'غير محدد') . '</p>
                    <p class="mb-0"><strong>رقم الهاتف:</strong> ' . ($data['from_number'] ?? 'غير محدد') . '</p>
                </div>
                
                <div class="mt-3">
                    <p class="text-muted">' . $notification->message . '</p>
                </div>
            </div>
        ';
    }

    /**
     * HTML معاينة طلب المستورد
     */
    private function getImporterOrderPreviewHtml(Notification $notification): string
    {
        $data = $notification->data ?? [];
        return '
            <div class="notification-preview">
                <div class="d-flex align-items-center mb-3">
                    <div class="notification-icon me-3">
                        <i class="fas fa-industry text-warning fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">طلب مستورد جديد</h5>
                        <small class="text-muted">' . $notification->created_at->format('Y-m-d H:i') . '</small>
                    </div>
                </div>
                
                <div class="alert alert-warning">
                    <h6><i class="fas fa-building me-2"></i>معلومات المستورد</h6>
                    <p class="mb-2"><strong>اسم الشركة:</strong> ' . ($data['company_name'] ?? 'غير محدد') . '</p>
                    <p class="mb-0"><strong>رقم الطلب:</strong> ' . ($data['importer_order_id'] ?? 'غير محدد') . '</p>
                </div>
                
                <div class="mt-3">
                    <p class="text-muted">' . $notification->message . '</p>
                </div>
            </div>
        ';
    }

    /**
     * HTML معاينة افتراضي
     */
    private function getDefaultPreviewHtml(Notification $notification): string
    {
        return '
            <div class="notification-preview">
                <div class="d-flex align-items-center mb-3">
                    <div class="notification-icon me-3">
                        <i class="' . $notification->icon . ' text-' . $notification->color . ' fa-2x"></i>
                    </div>
                    <div>
                        <h5 class="mb-1">' . $notification->title . '</h5>
                        <small class="text-muted">' . $notification->created_at->format('Y-m-d H:i') . '</small>
                    </div>
                </div>
                
                <div class="mt-3">
                    <p class="text-muted">' . $notification->message . '</p>
                </div>
            </div>
        ';
    }
}
