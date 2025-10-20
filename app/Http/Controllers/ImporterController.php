<?php

namespace App\Http\Controllers;

use App\Models\Importer;
use App\Models\ImporterOrder;
use App\Models\TaskCard;
use App\Models\User;
use App\Services\AIDesignService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ImporterController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }
    /**
     * عرض قائمة المستوردين
     */
    public function index()
    {
        $importers = Importer::latest()->paginate(15);
        return view('admin.importers.index', compact('importers'));
    }

    /**
     * عرض نموذج إنشاء مستورد جديد
     */
    public function create()
    {
        return view('admin.importers.create');
    }

    /**
     * حفظ مستورد جديد
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'company_name' => 'required|string|max:255',
            'business_type' => 'required|string|in:academy,school,store,hospital,other',
            'business_type_other' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'status' => 'required|string|in:new,contacted,qualified,proposal,negotiation,closed_won,closed_lost',
        ]);

        $importer = Importer::create($validated);

        return redirect()->route('admin.importers.index')
            ->with('success', 'تم إضافة المستورد بنجاح');
    }

    /**
     * عرض تفاصيل المستورد
     */
    public function show(Importer $importer)
    {
        $orders = $importer->orders()->latest()->get();
        $tasks = $importer->tasks()->latest()->get();
        
        return view('admin.importers.show', compact('importer', 'orders', 'tasks'));
    }

    /**
     * عرض نموذج تعديل المستورد
     */
    public function edit(Importer $importer)
    {
        return view('admin.importers.edit', compact('importer'));
    }

    /**
     * تحديث بيانات المستورد
     */
    public function update(Request $request, Importer $importer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'company_name' => 'required|string|max:255',
            'business_type' => 'required|string|in:academy,school,store,hospital,other',
            'business_type_other' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'notes' => 'nullable|string',
            'status' => 'required|string|in:new,contacted,qualified,proposal,negotiation,closed_won,closed_lost',
        ]);

        $importer->update($validated);

        return redirect()->route('admin.importers.index')
            ->with('success', 'تم تحديث بيانات المستورد بنجاح');
    }

    /**
     * حذف المستورد
     */
    public function destroy(Importer $importer)
    {
        $importer->delete();

        return redirect()->route('admin.importers.index')
            ->with('success', 'تم حذف المستورد بنجاح');
    }

    /**
     * عرض استمارة طلب المستورد (للواجهة الأمامية)
     */
    public function showImporterForm()
    {
        return view('importers.form');
    }

    /**
     * معالجة استمارة طلب المستورد (للواجهة الأمامية)
     */
    public function submitImporterForm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'company_name' => 'required|string|max:255',
            'business_type' => 'required|string|in:academy,school,store,hospital,other',
            'business_type_other' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'requirements' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'design_option' => 'required|string|in:text,upload,template',
            'design_details_text' => 'required_if:design_option,text|nullable|string',
            'design_file' => 'required_if:design_option,upload|nullable|file|mimes:jpeg,png,jpg,pdf,gif,bmp,tiff,webp,svg,ico,psd,ai,eps|max:5120',
            'design_upload_notes' => 'nullable|string',
            'design_3d_tshirt' => 'required_if:design_option,template|nullable|array',
            'design_3d_shorts' => 'nullable|array',
            'design_3d_socks' => 'nullable|array',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // إنشاء حساب مستخدم للمستورد
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'user_type' => 'importer',
        ]);

        // إنشاء سجل المستورد
        $importer = Importer::create([
            'user_id' => $user->id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'company_name' => $validated['company_name'],
            'business_type' => $validated['business_type'],
            'business_type_other' => $validated['business_type_other'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'country' => $validated['country'] ?? null,
            'status' => 'new',
        ]);

        // معالجة تفاصيل التصميم حسب الخيار المحدد
        $designDetails = [
            'option' => $validated['design_option'],
        ];

        switch ($validated['design_option']) {
            case 'text':
                $designDetails['text'] = $validated['design_details_text'];
                break;
            case 'upload':
                if ($request->hasFile('design_file')) {
                    $filePath = $request->file('design_file')->store('designs', 'public');
                    $designDetails['file_path'] = $filePath;
                }
                $designDetails['notes'] = $validated['design_upload_notes'];
                break;
            case 'template':
                $designDetails['3d_design'] = [
                    'tshirt' => $validated['design_3d_tshirt'] ?? null,
                    'shorts' => $validated['design_3d_shorts'] ?? null,
                    'socks' => $validated['design_3d_socks'] ?? null,
                ];
                break;
        }

        // إنشاء طلب المستورد
        $order = ImporterOrder::create([
            'importer_id' => $importer->id,
            'order_number' => ImporterOrder::generateOrderNumber(),
            'status' => 'new',
            'requirements' => $validated['requirements'],
            'quantity' => $validated['quantity'],
            'design_details' => json_encode($designDetails),
        ]);

        // إنشاء إشعار لطلب المستورد الجديد
        $this->notificationService->createImporterOrderNotification($order);

        // إرسال بريد وإشعار فوري للإدارة بطلب المستورد الجديد
        try {
            $emailService = app(\App\Services\EmailService::class);
            $emailService->sendImporterRequest([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'company' => $validated['company_name'],
                'requirements' => $validated['requirements'],
                'quantity' => $validated['quantity'],
                'design_option' => $validated['design_option'],
                'importer_id' => $importer->id,
                'order_id' => $order->id,
            ]);
        } catch (\Exception $e) {
            Log::warning('Failed to send importer request admin notification/email', [
                'error' => $e->getMessage(),
                'order_id' => $order->id,
            ]);
        }

        // تسجيل الدخول للمستخدم
        Auth::login($user);

        return redirect()->route('importers.dashboard')
            ->with('success', 'تم إنشاء حسابك وتسجيل طلبك بنجاح');
    }

    /**
     * عرض لوحة تحكم المستورد
     */
    public function dashboard()
    {
        $user = Auth::user();
        $importer = Importer::where('user_id', $user->id)->first();
        
        if (!$importer) {
            return redirect()->route('importers.form')
                ->with('error', 'يرجى إكمال بيانات المستورد أولاً');
        }
        
        $orders = $importer->orders()->latest()->get();
        
        return view('importers.dashboard', compact('importer', 'orders'));
    }

    /**
     * عرض طلبات المستورد
     */
    public function orders()
    {
        $user = Auth::user();
        $importer = Importer::where('user_id', $user->id)->first();
        
        if (!$importer) {
            return redirect()->route('importers.form')
                ->with('error', 'يرجى إكمال بيانات المستورد أولاً');
        }
        
        $orders = $importer->orders()->latest()->paginate(10);
        
        return view('importers.orders', compact('importer', 'orders'));
    }

    /**
     * عرض تتبع الشحنات
     */
    public function tracking()
    {
        $user = Auth::user();
        $importer = Importer::where('user_id', $user->id)->first();
        
        if (!$importer) {
            return redirect()->route('importers.form')
                ->with('error', 'يرجى إكمال بيانات المستورد أولاً');
        }
        
        // جلب الطلبات التي تم شحنها أو قيد التنفيذ أو في طريقها للتسليم
        $shippedOrders = $importer->orders()
            ->whereIn('status', ['in_progress', 'shipped', 'in_transit', 'out_for_delivery', 'delivered'])
            ->latest()
            ->get();
        
        // جلب الطلبات المكتملة للتتبع التاريخي
        $completedOrders = $importer->orders()
            ->where('status', 'completed')
            ->latest()
            ->limit(5)
            ->get();
        
        return view('importers.tracking', compact('importer', 'shippedOrders', 'completedOrders'));
    }

    /**
     * عرض الفواتير
     */
    public function invoices()
    {
        $user = Auth::user();
        $importer = Importer::where('user_id', $user->id)->first();
        
        if (!$importer) {
            return redirect()->route('importers.form')
                ->with('error', 'يرجى إكمال بيانات المستورد أولاً');
        }
        
        // جلب الطلبات التي لها فواتير (مكتملة)
        $invoices = $importer->orders()
            ->where('status', 'completed')
            ->latest()
            ->paginate(10);
        
        // حساب الإحصائيات
        $totalInvoices = $invoices->total();
        $totalAmount = $importer->orders()
            ->where('status', 'completed')
            ->sum(DB::raw('COALESCE(final_cost, estimated_cost, 0)'));
        $paidAmount = $importer->orders()
            ->where('status', 'completed')
            ->sum(DB::raw('COALESCE(final_cost, estimated_cost, 0)'));
        $pendingAmount = $totalAmount - $paidAmount;
        
        return view('importers.invoices', compact('importer', 'invoices', 'totalInvoices', 'totalAmount', 'paidAmount', 'pendingAmount'));
    }

    /**
     * عرض تفاصيل الفاتورة
     */
    public function showInvoice($orderId)
    {
        $user = Auth::user();
        $importer = Importer::where('user_id', $user->id)->first();
        
        if (!$importer) {
            return redirect()->route('importers.form')
                ->with('error', 'يرجى إكمال بيانات المستورد أولاً');
        }
        
        $order = $importer->orders()->findOrFail($orderId);
        
        return view('importers.invoice-details', compact('importer', 'order'));
    }

    /**
     * عرض طرق الدفع
     */
    public function paymentMethods()
    {
        $user = Auth::user();
        $importer = Importer::where('user_id', $user->id)->first();
        
        if (!$importer) {
            return redirect()->route('importers.form')
                ->with('error', 'يرجى إكمال بيانات المستورد أولاً');
        }
        
        // طرق الدفع المتاحة
        $paymentMethods = [
            [
                'id' => 'bank_transfer',
                'name' => 'تحويل بنكي',
                'description' => 'تحويل مباشر إلى الحساب البنكي',
                'icon' => 'fas fa-university',
                'status' => 'active',
                'processing_time' => '1-2 يوم عمل',
                'fees' => 'مجاني'
            ],
            [
                'id' => 'credit_card',
                'name' => 'بطاقة ائتمان',
                'description' => 'دفع آمن عبر البطاقات الائتمانية',
                'icon' => 'fas fa-credit-card',
                'status' => 'active',
                'processing_time' => 'فوري',
                'fees' => '2.5%'
            ],
            [
                'id' => 'stc_pay',
                'name' => 'STC Pay',
                'description' => 'دفع سريع وآمن عبر STC Pay',
                'icon' => 'fas fa-mobile-alt',
                'status' => 'active',
                'processing_time' => 'فوري',
                'fees' => '1.5%'
            ],
            [
                'id' => 'apple_pay',
                'name' => 'Apple Pay',
                'description' => 'دفع آمن عبر Apple Pay',
                'icon' => 'fab fa-apple-pay',
                'status' => 'active',
                'processing_time' => 'فوري',
                'fees' => '2%'
            ],
            [
                'id' => 'installments',
                'name' => 'الدفع بالتقسيط',
                'description' => 'دفع على أقساط شهرية',
                'icon' => 'fas fa-calendar-alt',
                'status' => 'available',
                'processing_time' => '1-3 أيام عمل',
                'fees' => '5% سنوياً'
            ]
        ];
        
        // معلومات الحساب البنكي
        $bankAccount = [
            'bank_name' => 'البنك الأهلي السعودي',
            'account_name' => 'إنفينيتي وير للتجارة',
            'account_number' => 'SA1234567890123456789012',
            'iban' => 'SA1234567890123456789012',
            'swift_code' => 'NCBKSAJE'
        ];
        
        return view('importers.payment-methods', compact('importer', 'paymentMethods', 'bankAccount'));
    }

    /**
     * إضافة طريقة دفع جديدة
     */
    public function addPaymentMethod(Request $request)
    {
        $user = Auth::user();
        $importer = Importer::where('user_id', $user->id)->first();
        
        if (!$importer) {
            return redirect()->route('importers.form')
                ->with('error', 'يرجى إكمال بيانات المستورد أولاً');
        }

        $validated = $request->validate([
            'method_type' => 'required|string|in:credit_card,stc_pay,apple_pay',
            'card_number' => 'required_if:method_type,credit_card|string|min:16|max:19',
            'expiry_date' => 'required_if:method_type,credit_card|string',
            'cvv' => 'required_if:method_type,credit_card|string|min:3|max:4',
            'cardholder_name' => 'required_if:method_type,credit_card|string|max:255',
            'phone_number' => 'required_if:method_type,stc_pay|string|max:20',
            'is_default' => 'boolean'
        ]);

        // محاكاة حفظ طريقة الدفع
        // في التطبيق الحقيقي، سيتم حفظ هذه البيانات في قاعدة البيانات
        
        return redirect()->route('importers.payment-methods')
            ->with('success', 'تم إضافة طريقة الدفع بنجاح');
    }

    /**
     * حذف طريقة دفع
     */
    public function deletePaymentMethod(Request $request, $methodId)
    {
        $user = Auth::user();
        $importer = Importer::where('user_id', $user->id)->first();
        
        if (!$importer) {
            return redirect()->route('importers.form')
                ->with('error', 'يرجى إكمال بيانات المستورد أولاً');
        }

        // محاكاة حذف طريقة الدفع
        // في التطبيق الحقيقي، سيتم حذف البيانات من قاعدة البيانات
        
        return redirect()->route('importers.payment-methods')
            ->with('success', 'تم حذف طريقة الدفع بنجاح');
    }

    /**
     * عرض الإشعارات
     */
    public function notifications()
    {
        $user = Auth::user();
        $importer = Importer::where('user_id', $user->id)->first();
        
        if (!$importer) {
            return redirect()->route('importers.form')
                ->with('error', 'يرجى إكمال بيانات المستورد أولاً');
        }
        
        // الحصول على الإشعارات من قاعدة البيانات
        $notifications = \App\Models\Notification::where('user_id', $user->id)
            ->where('is_archived', false)
            ->orderBy('created_at', 'desc')
            ->get();
        
        // إذا لم توجد إشعارات، إنشاء بعض الإشعارات التجريبية
        if ($notifications->isEmpty()) {
            $this->createSampleNotifications($user->id);
            $notifications = \App\Models\Notification::where('user_id', $user->id)
                ->where('is_archived', false)
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        // إحصائيات الإشعارات
        $unreadCount = $notifications->where('is_read', false)->count();
        $totalCount = $notifications->count();
        
        return view('importers.notifications', compact('importer', 'notifications', 'unreadCount', 'totalCount'));
    }

    /**
     * الحصول على عدد الإشعارات غير المقروءة
     */
    public function getUnreadNotificationsCount()
    {
        $user = Auth::user();
        $importer = Importer::where('user_id', $user->id)->first();
        
        if (!$importer) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $unreadCount = \App\Models\Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->where('is_archived', false)
            ->count();
        
        return response()->json(['unread_count' => $unreadCount]);
    }

    /**
     * إنشاء إشعارات تجريبية
     */
    private function createSampleNotifications($userId)
    {
        $sampleNotifications = [
            [
                'type' => 'order_status',
                'title' => 'تم تحديث حالة طلبك',
                'message' => 'تم تحديث حالة الطلب #12345 إلى "قيد التنفيذ"',
                'icon' => 'fas fa-shopping-cart',
                'color' => 'primary',
                'is_read' => false,
                'data' => ['order_id' => 12345, 'status' => 'in_progress']
            ],
            [
                'type' => 'payment',
                'title' => 'تم استلام دفعتك',
                'message' => 'تم استلام دفعتك بقيمة 1,500 ريال للطلب #12344',
                'icon' => 'fas fa-money-bill-wave',
                'color' => 'success',
                'is_read' => false,
                'data' => ['order_id' => 12344, 'amount' => 1500]
            ],
            [
                'type' => 'shipping',
                'title' => 'تم شحن طلبك',
                'message' => 'تم شحن طلبك #12343 وهو في الطريق إليك',
                'icon' => 'fas fa-truck',
                'color' => 'info',
                'is_read' => true,
                'data' => ['order_id' => 12343, 'tracking_number' => 'TRK123456']
            ],
            [
                'type' => 'invoice',
                'title' => 'فاتورة جديدة',
                'message' => 'تم إنشاء فاتورة جديدة للطلب #12342 بقيمة 2,300 ريال',
                'icon' => 'fas fa-file-invoice',
                'color' => 'warning',
                'is_read' => true,
                'data' => ['order_id' => 12342, 'amount' => 2300]
            ],
            [
                'type' => 'system',
                'title' => 'تحديث النظام',
                'message' => 'تم إضافة ميزات جديدة لصفحة تتبع الشحنات',
                'icon' => 'fas fa-cog',
                'color' => 'secondary',
                'is_read' => true,
                'data' => []
            ]
        ];

        foreach ($sampleNotifications as $notification) {
            \App\Models\Notification::create([
                'user_id' => $userId,
                'type' => $notification['type'],
                'title' => $notification['title'],
                'message' => $notification['message'],
                'icon' => $notification['icon'],
                'color' => $notification['color'],
                'is_read' => $notification['is_read'],
                'data' => $notification['data'],
                'created_at' => now()->subMinutes(rand(30, 4320)) // من 30 دقيقة إلى 3 أيام
            ]);
        }
    }

    /**
     * تحديد إشعار كمقروء
     */
    public function markNotificationAsRead(Request $request, $notificationId)
    {
        $user = Auth::user();
        $importer = Importer::where('user_id', $user->id)->first();
        
        if (!$importer) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // البحث عن الإشعار وتحديده كمقروء
        $notification = \App\Models\Notification::where('id', $notificationId)
            ->where('user_id', $user->id)
            ->first();
        
        if (!$notification) {
            return response()->json(['error' => 'الإشعار غير موجود'], 404);
        }
        
        $notification->markAsRead();
        
        return response()->json(['success' => true, 'message' => 'تم تحديد الإشعار كمقروء']);
    }

    /**
     * تحديد جميع الإشعارات كمقروءة
     */
    public function markAllNotificationsAsRead(Request $request)
    {
        $user = Auth::user();
        $importer = Importer::where('user_id', $user->id)->first();
        
        if (!$importer) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // تحديد جميع الإشعارات غير المقروءة كمقروءة
        \App\Models\Notification::where('user_id', $user->id)
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);
        
        return response()->json(['success' => true, 'message' => 'تم تحديد جميع الإشعارات كمقروءة']);
    }

    /**
     * حذف إشعار
     */
    public function deleteNotification(Request $request, $notificationId)
    {
        $user = Auth::user();
        $importer = Importer::where('user_id', $user->id)->first();
        
        if (!$importer) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // البحث عن الإشعار وحذفه
        $notification = \App\Models\Notification::where('id', $notificationId)
            ->where('user_id', $user->id)
            ->first();
        
        if (!$notification) {
            return response()->json(['error' => 'الإشعار غير موجود'], 404);
        }
        
        $notification->delete();
        
        return response()->json(['success' => true, 'message' => 'تم حذف الإشعار']);
    }

    /**
     * إعدادات الإشعارات
     */
    public function notificationSettings()
    {
        $user = Auth::user();
        $importer = Importer::where('user_id', $user->id)->first();
        
        if (!$importer) {
            return redirect()->route('importers.form')
                ->with('error', 'يرجى إكمال بيانات المستورد أولاً');
        }
        
        // محاكاة إعدادات الإشعارات
        $settings = [
            'email_notifications' => true,
            'sms_notifications' => false,
            'push_notifications' => true,
            'order_updates' => true,
            'payment_notifications' => true,
            'shipping_updates' => true,
            'invoice_notifications' => true,
            'system_announcements' => false,
            'marketing_emails' => false
        ];
        
        return view('importers.notification-settings', compact('importer', 'settings'));
    }

    /**
     * تحديث إعدادات الإشعارات
     */
    public function updateNotificationSettings(Request $request)
    {
        $user = Auth::user();
        $importer = Importer::where('user_id', $user->id)->first();
        
        if (!$importer) {
            return redirect()->route('importers.form')
                ->with('error', 'يرجى إكمال بيانات المستورد أولاً');
        }

        $validated = $request->validate([
            'email_notifications' => 'boolean',
            'sms_notifications' => 'boolean',
            'push_notifications' => 'boolean',
            'order_updates' => 'boolean',
            'payment_notifications' => 'boolean',
            'shipping_updates' => 'boolean',
            'invoice_notifications' => 'boolean',
            'system_announcements' => 'boolean',
            'marketing_emails' => 'boolean'
        ]);

        // محاكاة حفظ الإعدادات
        // في التطبيق الحقيقي، سيتم حفظ في قاعدة البيانات
        
        return redirect()->route('importers.notification-settings')
            ->with('success', 'تم تحديث إعدادات الإشعارات بنجاح');
    }

    /**
     * عرض صفحة المساعدة
     */
    public function help()
    {
        $user = Auth::user();
        $importer = Importer::where('user_id', $user->id)->first();
        
        if (!$importer) {
            return redirect()->route('importers.form')
                ->with('error', 'يرجى إكمال بيانات المستورد أولاً');
        }
        
        // محاكاة مقالات المساعدة
        $helpArticles = [
            [
                'id' => 1,
                'category' => 'getting_started',
                'title' => 'كيفية إنشاء طلب جديد',
                'content' => 'تعلم كيفية إنشاء طلب جديد خطوة بخطوة...',
                'icon' => 'fas fa-plus-circle',
                'color' => 'primary'
            ],
            [
                'id' => 2,
                'category' => 'orders',
                'title' => 'متابعة حالة الطلبات',
                'content' => 'كيفية متابعة حالة طلباتك ومعرفة التحديثات...',
                'icon' => 'fas fa-shopping-cart',
                'color' => 'success'
            ],
            [
                'id' => 3,
                'category' => 'payments',
                'title' => 'طرق الدفع المتاحة',
                'content' => 'جميع طرق الدفع المتاحة وكيفية استخدامها...',
                'icon' => 'fas fa-credit-card',
                'color' => 'info'
            ],
            [
                'id' => 4,
                'category' => 'shipping',
                'title' => 'تتبع الشحنات',
                'content' => 'كيفية تتبع شحناتك ومعرفة موقعها الحالي...',
                'icon' => 'fas fa-truck',
                'color' => 'warning'
            ],
            [
                'id' => 5,
                'category' => 'invoices',
                'title' => 'إدارة الفواتير',
                'content' => 'كيفية عرض وتحميل فواتيرك...',
                'icon' => 'fas fa-file-invoice',
                'color' => 'secondary'
            ]
        ];
        
        $categories = [
            'getting_started' => 'البداية',
            'orders' => 'الطلبات',
            'payments' => 'المدفوعات',
            'shipping' => 'الشحن',
            'invoices' => 'الفواتير'
        ];
        
        return view('importers.help', compact('importer', 'helpArticles', 'categories'));
    }

    /**
     * عرض صفحة الدعم الفني
     */
    public function support()
    {
        $user = Auth::user();
        $importer = Importer::where('user_id', $user->id)->first();
        
        if (!$importer) {
            return redirect()->route('importers.form')
                ->with('error', 'يرجى إكمال بيانات المستورد أولاً');
        }
        
        // محاكاة تذاكر الدعم
        $supportTickets = [
            [
                'id' => 1,
                'subject' => 'مشكلة في تحميل الفاتورة',
                'status' => 'open',
                'priority' => 'high',
                'created_at' => now()->subHours(2),
                'last_reply' => now()->subMinutes(30)
            ],
            [
                'id' => 2,
                'subject' => 'استفسار حول وقت التسليم',
                'status' => 'in_progress',
                'priority' => 'medium',
                'created_at' => now()->subDays(1),
                'last_reply' => now()->subHours(3)
            ],
            [
                'id' => 3,
                'subject' => 'طلب تغيير في التصميم',
                'status' => 'resolved',
                'priority' => 'low',
                'created_at' => now()->subDays(3),
                'last_reply' => now()->subDays(1)
            ]
        ];
        
        return view('importers.support', compact('importer', 'supportTickets'));
    }

    /**
     * إنشاء تذكرة دعم جديدة
     */
    public function createSupportTicket(Request $request)
    {
        // التحقق من وجود مستخدم مسجل دخول أو السماح بالوصول العام للتواصل
        $user = Auth::user();
        $importer = null;
        
        if ($user) {
            $importer = Importer::where('user_id', $user->id)->first();
        }

        // التحقق من صحة البيانات
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'category' => 'nullable|string|in:technical,billing,shipping,general',
            'priority' => 'nullable|string|in:low,medium,high,urgent',
            'attachments' => 'nullable|array|max:5',
            'attachments.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,gif,bmp,tiff,webp,svg,ico,psd,ai,eps|max:5120'
        ]);

        try {
            // إنشاء سجل تواصل جديد
            $contact = \App\Models\Contact::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'subject' => $validated['subject'],
                'message' => $validated['message'],
                'status' => 'new',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'admin_notes' => 'تم إنشاؤها من نموذج الدعم الفني'
            ]);

            // إنشاء إشعار للمدير
            $notificationService = app(\App\Services\NotificationService::class);
            $notificationService->createContactNotification($contact);
            
            // إرسال إيميل للمدير
            $emailService = app(\App\Services\EmailService::class);
            $emailService->sendContactForm([
                'name' => $contact->name,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'company' => $contact->company ?? 'غير محدد',
                'subject' => $contact->subject,
                'message' => $contact->message
            ]);

            // إرسال إشعار WhatsApp للمدير
            try {
                $whatsappService = app(\App\Services\WhatsAppAutoService::class);
                $adminPhone = '+966501234567'; // رقم المدير
                $message = "🔔 تذكرة دعم جديدة\n\n";
                $message .= "👤 الاسم: {$contact->name}\n";
                $message .= "📧 البريد: {$contact->email}\n";
                $message .= "📱 الهاتف: " . ($contact->phone ?: 'غير محدد') . "\n";
                $message .= "📋 الموضوع: {$contact->subject}\n";
                $message .= "💬 الرسالة: " . substr($contact->message, 0, 100) . "...\n\n";
                $message .= "🔗 رابط الإدارة: " . url('/admin/contacts/' . $contact->id);
                
                $whatsappService->sendMessage($adminPhone, $message);
            } catch (\Exception $e) {
                Log::warning('Failed to send WhatsApp notification: ' . $e->getMessage());
            }

            // إرجاع استجابة JSON للطلبات AJAX
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم إرسال تذكرة الدعم بنجاح! سنتواصل معك قريباً.',
                    'data' => [
                        'id' => $contact->id,
                        'timestamp' => now()->toISOString()
                    ]
                ], 201);
            }

            // إرجاع استجابة عادية للطلبات العادية
            return redirect()->back()
                ->with('success', 'تم إرسال تذكرة الدعم بنجاح! سنتواصل معك قريباً.');

        } catch (\Exception $e) {
            Log::error('Support ticket creation error: ' . $e->getMessage());
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'حدث خطأ أثناء إرسال تذكرة الدعم. يرجى المحاولة مرة أخرى.',
                    'error' => 'Database error'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء إرسال تذكرة الدعم. يرجى المحاولة مرة أخرى.')
                ->withInput();
        }
    }

    /**
     * عرض صفحة التواصل معنا
     */
    public function contact()
    {
        $user = Auth::user();
        $importer = Importer::where('user_id', $user->id)->first();
        
        if (!$importer) {
            return redirect()->route('importers.form')
                ->with('error', 'يرجى إكمال بيانات المستورد أولاً');
        }
        
        // معلومات التواصل
        $contactInfo = [
            'phone' => '+966500982394',
            'email' => 'support@infinitywear.sa',
            'whatsapp' => '+966500982394',
            'address' => 'الرياض، حي النخيل، المملكة العربية السعودية',
            'working_hours' => 'الأحد - الخميس: 8:00 ص - 6:00 م',
            'emergency_contact' => '+966 50 987 6543'
        ];
        
        return view('importers.contact', compact('importer', 'contactInfo'));
    }

    /**
     * إرسال رسالة تواصل
     */
    public function sendContactMessage(Request $request)
    {
        $user = Auth::user();
        $importer = Importer::where('user_id', $user->id)->first();
        
        if (!$importer) {
            return redirect()->route('importers.form')
                ->with('error', 'يرجى إكمال بيانات المستورد أولاً');
        }

        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'contact_method' => 'required|string|in:email,phone,whatsapp',
            'preferred_time' => 'nullable|string|max:255'
        ]);

        // محاكاة إرسال الرسالة
        // في التطبيق الحقيقي، سيتم حفظ في قاعدة البيانات وإرسال إشعار
        
        return redirect()->route('importers.contact')
            ->with('success', 'تم إرسال رسالتك بنجاح. سنتواصل معك قريباً.');
    }

    /**
     * عرض الملف الشخصي للمستورد
     */
    public function profile()
    {
        $user = Auth::user();
        $importer = Importer::where('user_id', $user->id)->first();
        
        if (!$importer) {
            return redirect()->route('importers.form')
                ->with('error', 'يرجى إكمال بيانات المستورد أولاً');
        }
        
        return view('importers.profile', compact('importer'));
    }

    /**
     * تحديث الملف الشخصي للمستورد
     */
    public function updateProfile(Request $request)
    {
        $authUser = Auth::user();
        $importer = Importer::where('user_id', $authUser->id)->first();
        
        if (!$importer) {
            return redirect()->route('importers.form')
                ->with('error', 'يرجى إكمال بيانات المستورد أولاً');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $authUser->id,
            'phone' => 'required|string|max:20',
            'company_name' => 'required|string|max:255',
            'business_type' => 'required|string|in:academy,school,store,hospital,other',
            'business_type_other' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
        ]);

        // تحديث بيانات المستخدم
        $user = User::find($authUser->id);
        if ($user) {
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'city' => $validated['city'],
            ]);
        }

        // تحديث بيانات المستورد
        $importer->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'company_name' => $validated['company_name'],
            'business_type' => $validated['business_type'],
            'business_type_other' => $validated['business_type_other'],
            'address' => $validated['address'],
            'city' => $validated['city'],
            'country' => $validated['country'],
        ]);

        return redirect()->route('importers.profile')
            ->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    /**
     * API endpoint for AI design assistance
     */
    public function aiDesignAssistance(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:1000',
            'style' => 'required|string|in:realistic,modern,minimalist,sporty,elegant'
        ]);

        try {
            $aiService = new AIDesignService();
            $result = $aiService->generateDesignDescription($request->prompt, $request->style);
            
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('AI Assistance Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'حدث خطأ في خدمة الذكاء الاصطناعي'
            ], 500);
        }
    }

    /**
     * API endpoint for design analysis
     */
    public function analyzeDesignRequirements(Request $request)
    {
        $request->validate([
            'requirements' => 'required|string|max:2000'
        ]);

        try {
            $aiService = new AIDesignService();
            $result = $aiService->analyzeDesignRequirements($request->requirements);
            
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Design Analysis Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'حدث خطأ في تحليل المتطلبات'
            ], 500);
        }
    }

    /**
     * API endpoint for AI design generation
     */
    public function generateDesign(Request $request)
    {
        $request->validate([
            'prompt' => 'required|string|max:1000'
        ]);

        try {
            $aiService = new \App\Services\AIDesignService();
            $result = $aiService->generateTShirtDesign($request->prompt);
            
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('AI Design Generation Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'حدث خطأ في إنشاء التصميم'
            ], 500);
        }
    }
}