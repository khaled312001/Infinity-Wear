<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Contact;
use App\Models\WhatsAppMessage;
use App\Models\ImporterOrder;
use App\Models\User;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DailyReportService
{
    /**
     * إنشاء التقرير اليومي
     */
    public function generateDailyReport($date = null)
    {
        $date = $date ? Carbon::parse($date) : Carbon::yesterday();
        $startOfDay = $date->startOfDay();
        $endOfDay = $date->endOfDay();
        
        return [
            'date' => $date->format('Y-m-d'),
            'date_arabic' => $date->locale('ar')->isoFormat('dddd، D MMMM Y'),
            'summary' => $this->getSummary($startOfDay, $endOfDay),
            'orders' => $this->getOrdersData($startOfDay, $endOfDay),
            'contacts' => $this->getContactsData($startOfDay, $endOfDay),
            'whatsapp' => $this->getWhatsAppData($startOfDay, $endOfDay),
            'importer_orders' => $this->getImporterOrdersData($startOfDay, $endOfDay),
            'tasks' => $this->getTasksData($startOfDay, $endOfDay),
            'marketing_reports' => $this->getMarketingReportsData($startOfDay, $endOfDay),
            'sales_reports' => $this->getSalesReportsData($startOfDay, $endOfDay),
            'notifications' => $this->getNotificationsData($startOfDay, $endOfDay),
            'users' => $this->getUsersData($startOfDay, $endOfDay),
            'statistics' => $this->getStatistics($startOfDay, $endOfDay)
        ];
    }

    /**
     * الحصول على ملخص عام
     */
    private function getSummary($startOfDay, $endOfDay)
    {
        return [
            'total_orders' => Order::whereBetween('created_at', [$startOfDay, $endOfDay])->count(),
            'total_contacts' => Contact::whereBetween('created_at', [$startOfDay, $endOfDay])->count(),
            'total_whatsapp' => WhatsAppMessage::whereBetween('created_at', [$startOfDay, $endOfDay])->count(),
            'total_importer_orders' => ImporterOrder::whereBetween('created_at', [$startOfDay, $endOfDay])->count(),
            'total_tasks' => 0, // سيتم إضافة Task model لاحقاً
            'total_marketing_reports' => 0, // سيتم إضافة MarketingReport model لاحقاً
            'total_sales_reports' => 0, // سيتم إضافة SalesReport model لاحقاً
            'total_notifications' => Notification::whereBetween('created_at', [$startOfDay, $endOfDay])->count(),
            'total_users' => User::whereBetween('created_at', [$startOfDay, $endOfDay])->count(),
        ];
    }

    /**
     * بيانات الطلبات
     */
    private function getOrdersData($startOfDay, $endOfDay)
    {
        $orders = Order::whereBetween('created_at', [$startOfDay, $endOfDay])
            ->with(['user', 'items'])
            ->orderBy('created_at', 'desc')
            ->get();

        $totalAmount = $orders->sum('total_amount');
        $statusCounts = $orders->groupBy('status')->map->count();

        return [
            'count' => $orders->count(),
            'total_amount' => $totalAmount,
            'average_amount' => $orders->count() > 0 ? $totalAmount / $orders->count() : 0,
            'status_counts' => $statusCounts,
            'recent_orders' => $orders->take(5)->map(function ($order) {
                return [
                    'id' => $order->id,
                    'customer_name' => $order->user->name ?? 'غير محدد',
                    'total' => $order->total_amount,
                    'status' => $order->status,
                    'created_at' => $order->created_at->format('H:i')
                ];
            })
        ];
    }

    /**
     * بيانات رسائل الاتصال
     */
    private function getContactsData($startOfDay, $endOfDay)
    {
        $contacts = Contact::whereBetween('created_at', [$startOfDay, $endOfDay])
            ->orderBy('created_at', 'desc')
            ->get();

        $statusCounts = $contacts->groupBy('status')->map->count();

        return [
            'count' => $contacts->count(),
            'status_counts' => $statusCounts,
            'recent_contacts' => $contacts->take(5)->map(function ($contact) {
                return [
                    'id' => $contact->id,
                    'name' => $contact->name,
                    'email' => $contact->email,
                    'subject' => $contact->subject,
                    'status' => $contact->status,
                    'created_at' => $contact->created_at->format('H:i')
                ];
            })
        ];
    }

    /**
     * بيانات رسائل الواتساب
     */
    private function getWhatsAppData($startOfDay, $endOfDay)
    {
        $messages = WhatsAppMessage::whereBetween('created_at', [$startOfDay, $endOfDay])
            ->orderBy('created_at', 'desc')
            ->get();

        $statusCounts = $messages->groupBy('status')->map->count();

        return [
            'count' => $messages->count(),
            'status_counts' => $statusCounts,
            'recent_messages' => $messages->take(5)->map(function ($message) {
                return [
                    'id' => $message->id,
                    'sender_name' => $message->sender_name,
                    'from_number' => $message->from_number,
                    'message_content' => substr($message->message_content, 0, 50) . '...',
                    'status' => $message->status,
                    'created_at' => $message->created_at->format('H:i')
                ];
            })
        ];
    }

    /**
     * بيانات طلبات المستوردين
     */
    private function getImporterOrdersData($startOfDay, $endOfDay)
    {
        $orders = ImporterOrder::whereBetween('created_at', [$startOfDay, $endOfDay])
            ->with(['importer'])
            ->orderBy('created_at', 'desc')
            ->get();

        $statusCounts = $orders->groupBy('status')->map->count();

        return [
            'count' => $orders->count(),
            'status_counts' => $statusCounts,
            'recent_orders' => $orders->take(5)->map(function ($order) {
                return [
                    'id' => $order->id,
                    'importer_name' => $order->importer->company_name ?? 'غير محدد',
                    'status' => $order->status,
                    'created_at' => $order->created_at->format('H:i')
                ];
            })
        ];
    }

    /**
     * بيانات المهام
     */
    private function getTasksData($startOfDay, $endOfDay)
    {
        // سيتم إضافة Task model لاحقاً
        return [
            'count' => 0,
            'priority_counts' => [],
            'status_counts' => [],
            'recent_tasks' => []
        ];
    }

    /**
     * بيانات التقارير التسويقية
     */
    private function getMarketingReportsData($startOfDay, $endOfDay)
    {
        // سيتم إضافة MarketingReport model لاحقاً
        return [
            'count' => 0,
            'status_counts' => [],
            'recent_reports' => []
        ];
    }

    /**
     * بيانات تقارير المبيعات
     */
    private function getSalesReportsData($startOfDay, $endOfDay)
    {
        // سيتم إضافة SalesReport model لاحقاً
        return [
            'count' => 0,
            'status_counts' => [],
            'recent_reports' => []
        ];
    }

    /**
     * بيانات الإشعارات
     */
    private function getNotificationsData($startOfDay, $endOfDay)
    {
        $notifications = Notification::whereBetween('created_at', [$startOfDay, $endOfDay])
            ->orderBy('created_at', 'desc')
            ->get();

        $typeCounts = $notifications->groupBy('type')->map->count();

        return [
            'count' => $notifications->count(),
            'type_counts' => $typeCounts,
            'recent_notifications' => $notifications->take(5)->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'type' => $notification->type,
                    'is_read' => $notification->is_read,
                    'created_at' => $notification->created_at->format('H:i')
                ];
            })
        ];
    }

    /**
     * بيانات المستخدمين
     */
    private function getUsersData($startOfDay, $endOfDay)
    {
        $users = User::whereBetween('created_at', [$startOfDay, $endOfDay])
            ->orderBy('created_at', 'desc')
            ->get();

        $roleCounts = $users->groupBy('role')->map->count();

        return [
            'count' => $users->count(),
            'role_counts' => $roleCounts,
            'recent_users' => $users->take(5)->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'created_at' => $user->created_at->format('H:i')
                ];
            })
        ];
    }

    /**
     * إحصائيات عامة
     */
    private function getStatistics($startOfDay, $endOfDay)
    {
        return [
            'total_activities' => $this->getTotalActivities($startOfDay, $endOfDay),
            'most_active_hour' => $this->getMostActiveHour($startOfDay, $endOfDay),
            'top_priority_tasks' => $this->getTopPriorityTasks($startOfDay, $endOfDay),
            'pending_items' => $this->getPendingItems($startOfDay, $endOfDay)
        ];
    }

    /**
     * إجمالي الأنشطة
     */
    private function getTotalActivities($startOfDay, $endOfDay)
    {
        return Order::whereBetween('created_at', [$startOfDay, $endOfDay])->count() +
               Contact::whereBetween('created_at', [$startOfDay, $endOfDay])->count() +
               WhatsAppMessage::whereBetween('created_at', [$startOfDay, $endOfDay])->count() +
               ImporterOrder::whereBetween('created_at', [$startOfDay, $endOfDay])->count() +
               Notification::whereBetween('created_at', [$startOfDay, $endOfDay])->count();
    }

    /**
     * الساعة الأكثر نشاطاً
     */
    private function getMostActiveHour($startOfDay, $endOfDay)
    {
        $hourlyData = DB::table('orders')
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->select(DB::raw('HOUR(created_at) as hour'), DB::raw('COUNT(*) as count'))
            ->groupBy('hour')
            ->orderBy('count', 'desc')
            ->first();

        return $hourlyData ? $hourlyData->hour . ':00' : 'غير محدد';
    }

    /**
     * المهام عالية الأولوية
     */
    private function getTopPriorityTasks($startOfDay, $endOfDay)
    {
        // سيتم إضافة Task model لاحقاً
        return 0;
    }

    /**
     * العناصر المعلقة
     */
    private function getPendingItems($startOfDay, $endOfDay)
    {
        return [
            'pending_orders' => Order::where('status', 'pending')->count(),
            'pending_contacts' => Contact::where('status', 'pending')->count(),
            'pending_tasks' => 0, // سيتم إضافة Task model لاحقاً
            'unread_notifications' => Notification::where('is_read', false)->count()
        ];
    }
}
