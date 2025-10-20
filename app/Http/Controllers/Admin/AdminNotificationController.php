<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdminNotification as AdminNotificationNotification;
use Carbon\Carbon;

class AdminNotificationController extends Controller
{
    /**
     * عرض صفحة الإعلامات
     */
    public function index(Request $request)
    {
        $query = AdminNotification::with('creator')->latest();

        // فلترة حسب النوع
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // فلترة حسب الأولوية
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            if ($request->status === 'sent') {
                $query->where('is_sent', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_sent', false);
            } elseif ($request->status === 'scheduled') {
                $query->where('is_scheduled', true)->where('is_sent', false);
            }
        }

        // البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%");
            });
        }

        $adminNotifications = $query->paginate(15);

        // إحصائيات
        $adminStats = [
            'total' => AdminNotification::count(),
            'sent' => AdminNotification::where('is_sent', true)->count(),
            'pending' => AdminNotification::where('is_sent', false)->count(),
            'scheduled' => AdminNotification::where('is_scheduled', true)->where('is_sent', false)->count(),
        ];

        // إحصائيات النظام (للتبويب الأول)
        $stats = [
            'total' => \App\Models\Notification::count(),
            'unread' => \App\Models\Notification::where('is_read', false)->where('is_archived', false)->count(),
            'order' => \App\Models\Notification::where('is_read', false)->where('is_archived', false)->where('type', 'order')->count(),
            'contact' => \App\Models\Notification::where('is_read', false)->where('is_archived', false)->where('type', 'contact')->count(),
            'whatsapp' => \App\Models\Notification::where('is_read', false)->where('is_archived', false)->where('type', 'whatsapp')->count(),
            'importer_order' => \App\Models\Notification::where('is_read', false)->where('is_archived', false)->where('type', 'importer_order')->count(),
        ];

        // إشعارات النظام (للتبويب الأول)
        $notifications = \App\Models\Notification::notArchived()->latest()->paginate(20);

        return view('admin.notifications.index', compact('adminNotifications', 'adminStats', 'notifications', 'stats'));
    }

    /**
     * عرض صفحة إنشاء إشعار جديد
     */
    public function create()
    {
        // الحصول على المستخدمين حسب النوع
        $userTypes = [
            'admin' => 'مدير',
            'employee' => 'موظف',
            'importer' => 'مستورد',
            'sales' => 'مندوب مبيعات',
            'marketing' => 'موظف تسويق',
        ];

        // الحصول على المستخدمين للاختيار المحدد
        $users = User::where('is_active', true)
                    ->select('id', 'name', 'email', 'user_type')
                    ->orderBy('name')
                    ->get()
                    ->groupBy('user_type');

        return view('admin.notifications.create', compact('userTypes', 'users'));
    }

    /**
     * حفظ الإشعار الجديد
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'email_content' => 'nullable|string',
            'type' => 'required|in:notification,email,both',
            'target_type' => 'required|in:specific_users,user_type,all',
            'target_users' => 'nullable|array',
            'target_user_types' => 'nullable|array',
            'priority' => 'required|in:low,normal,high,urgent',
            'category' => 'nullable|string|max:100',
            'is_scheduled' => 'boolean',
            'scheduled_at' => 'nullable|date|after:now',
        ]);

        // التحقق من صحة البيانات حسب نوع المستهدفين
        if ($request->target_type === 'specific_users' && empty($request->target_users)) {
            return back()->withErrors(['target_users' => 'يجب اختيار مستخدم واحد على الأقل']);
        }

        if ($request->target_type === 'user_type' && empty($request->target_user_types)) {
            return back()->withErrors(['target_user_types' => 'يجب اختيار نوع مستخدم واحد على الأقل']);
        }

        // التحقق من وجود محتوى الإيميل إذا كان النوع يتطلب إيميل
        if (in_array($request->type, ['email', 'both']) && empty($request->email_content)) {
            return back()->withErrors(['email_content' => 'يجب إدخال محتوى الإيميل']);
        }

        $notification = AdminNotification::create([
            'title' => $request->title,
            'message' => $request->message,
            'email_content' => $request->email_content,
            'type' => $request->type,
            'target_type' => $request->target_type,
            'target_users' => $request->target_users,
            'target_user_types' => $request->target_user_types,
            'priority' => $request->priority,
            'category' => $request->category,
            'is_scheduled' => $request->boolean('is_scheduled'),
            'scheduled_at' => $request->scheduled_at ? Carbon::parse($request->scheduled_at) : null,
            'created_by' => Auth::id(),
        ]);

        // إرسال فوري إذا لم يكن مجدول
        if (!$notification->is_scheduled) {
            $this->sendNotification($notification);
        }

        return redirect()->route('admin.notifications.index')
                        ->with('success', 'تم إنشاء الإشعار بنجاح' . ($notification->is_scheduled ? ' وسيتم إرساله في الوقت المحدد' : ' وتم إرساله'));
    }

    /**
     * عرض تفاصيل الإشعار
     */
    public function show(AdminNotification $notification)
    {
        $notification->load('creator');
        $targetUsers = $notification->getTargetUsers();
        
        return view('admin.notifications.show', compact('notification', 'targetUsers'));
    }

    /**
     * إرسال الإشعار
     */
    public function send(AdminNotification $notification)
    {
        if (!$notification->canBeSent()) {
            return back()->withErrors(['error' => 'لا يمكن إرسال هذا الإشعار']);
        }

        $this->sendNotification($notification);

        return back()->with('success', 'تم إرسال الإشعار بنجاح');
    }

    /**
     * حذف الإشعار
     */
    public function destroy(AdminNotification $notification)
    {
        $notification->delete();

        return redirect()->route('admin.notifications.index')
                        ->with('success', 'تم حذف الإشعار بنجاح');
    }

    /**
     * إرسال الإشعار فعلياً
     */
    private function sendNotification(AdminNotification $notification)
    {
        $targetUsers = $notification->getTargetUsers();

        foreach ($targetUsers as $user) {
            try {
                // إرسال الإشعار
                if (in_array($notification->type, ['notification', 'both'])) {
                    $user->notify(new AdminNotificationNotification($notification));
                }

                // إرسال الإيميل
                if (in_array($notification->type, ['email', 'both'])) {
                    $this->sendEmail($user, $notification);
                }

                $notification->recordSendResult($user->id, true);

            } catch (\Exception $e) {
                $notification->recordSendResult($user->id, false, $e->getMessage());
            }
        }

        // تحديث حالة الإشعار
        $notification->update([
            'is_sent' => true,
            'sent_at' => now(),
        ]);
    }

    /**
     * إرسال الإيميل
     */
    private function sendEmail(User $user, AdminNotification $notification)
    {
        $data = [
            'user' => $user,
            'notification' => $notification,
            'title' => $notification->title,
            'content' => $notification->email_content,
        ];

        Mail::send('emails.admin-notification', $data, function ($message) use ($user, $notification) {
            $message->to($user->email, $user->name)
                   ->subject($notification->title);
        });
    }

    /**
     * الحصول على المستخدمين حسب النوع (AJAX)
     */
    public function getUsersByType(Request $request)
    {
        $userTypes = $request->input('user_types', []);
        
        if (empty($userTypes)) {
            return response()->json([]);
        }

        $users = User::whereIn('user_type', $userTypes)
                    ->where('is_active', true)
                    ->select('id', 'name', 'email', 'user_type')
                    ->orderBy('name')
                    ->get();

        return response()->json($users);
    }

    /**
     * إحصائيات الإشعارات (AJAX)
     */
    public function stats()
    {
        $stats = [
            'total' => AdminNotification::count(),
            'sent' => AdminNotification::where('is_sent', true)->count(),
            'pending' => AdminNotification::where('is_sent', false)->count(),
            'scheduled' => AdminNotification::where('is_scheduled', true)->where('is_sent', false)->count(),
            'today' => AdminNotification::whereDate('created_at', today())->count(),
            'this_week' => AdminNotification::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => AdminNotification::whereMonth('created_at', now()->month)->count(),
        ];

        return response()->json($stats);
    }
}