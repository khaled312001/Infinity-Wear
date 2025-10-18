<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Importer;
use App\Models\ImporterOrder;
use App\Models\MarketingTeam;
use App\Models\SalesTeam;
use App\Models\Task;
use App\Models\PortfolioItem;
use App\Models\Testimonial;
use App\Models\User;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /**
     * عرض لوحة التحكم الرئيسية
     */
    public function dashboard()
    {
        // إحصائيات عامة محسنة
        $totalImporters = Importer::count();
        $newImporters = Importer::where('status', 'new')->count();
        $approvedImporters = Importer::where('status', 'qualified')->count();
        $rejectedImporters = Importer::where('status', 'closed_lost')->count();
        
        $processingOrders = ImporterOrder::where('status', 'processing')->count();
        $completedOrders = ImporterOrder::where('status', 'completed')->count();
        
        // إحصائيات المستخدمين والتصاميم
        $totalUsers = User::count();
        $newUsersThisMonth = User::whereRaw('strftime("%m", created_at) = ?', [str_pad(now()->month, 2, '0', STR_PAD_LEFT)])
                                ->whereRaw('strftime("%Y", created_at) = ?', [now()->year])
                                ->count();
        
        // الإيرادات الشهرية من المعاملات
        $monthlyRevenue = Transaction::getMonthlyRevenue();
        $monthlyExpenses = Transaction::getMonthlyExpenses();
        $monthlyProfit = Transaction::getMonthlyProfit();
        
        // إحصائيات المهام
        $totalTasks = Task::count();
        $pendingTasks = Task::where('status', '!=', 'completed')->count();
        $overdueTasks = Task::where('due_date', '<', now())
                           ->where('status', '!=', 'completed')
                           ->count();
        
        
        // إحصائيات للوحة التحكم الجديدة
        $stats = [
            'total_users' => $totalUsers,
            'total_importers' => $totalImporters,
            'new_importers' => $newImporters,
            'monthly_revenue' => $monthlyRevenue,
            'monthly_expenses' => $monthlyExpenses,
            'monthly_profit' => $monthlyProfit,
            'total_tasks' => $totalTasks,
            'pending_tasks' => $pendingTasks,
            'overdue_tasks' => $overdueTasks,
            'new_users_this_month' => $newUsersThisMonth,
            'completed_orders' => $completedOrders,
            'processing_orders' => $processingOrders
        ];
        
        // إحصائيات المهام المتأخرة
        $overdueTasks = Task::where('status', '!=', 'completed')
                          ->where('due_date', '<', now())
                          ->count();
        
        $marketingTeamCount = MarketingTeam::where('is_active', true)->count();
        $salesTeamCount = SalesTeam::where('is_active', true)->count();
        
        // أحدث المستوردين
        $latestImporters = Importer::latest()->take(5)->get();
        
        // إعداد الإحصائيات للوحة التحكم
        $stats = [
            'total_users' => $totalUsers,
            'monthly_revenue' => $monthlyRevenue,
            'total_importers' => $totalImporters,
            'new_importers' => $newImporters,
            'approved_importers' => $approvedImporters,
            'rejected_importers' => $rejectedImporters,
        ];
        
        
        // المهام العاجلة
        $urgentTasks = Task::where('status', '!=', 'completed')
                         ->where('priority', 'high')
                         ->orderBy('due_date')
                         ->take(5)
                         ->get();
        
        // إحصائيات المبيعات الشهرية للرسم البياني
        $monthlySales = Transaction::getMonthlyChartData();
        
        // إحصائيات النشاط الأخير
        $recentActivity = $this->getRecentActivity();
        
        // إحصائيات الأداء
        $performanceStats = $this->getPerformanceStats();
        
        // بيانات الرسم البياني
        $chartData = $this->getChartData();
        
        return view('admin.dashboard', compact(
            'stats',
            'totalImporters', 'newImporters', 'approvedImporters', 'rejectedImporters',
            'processingOrders', 'completedOrders',
            'totalTasks', 'pendingTasks', 'overdueTasks',
            'marketingTeamCount', 'salesTeamCount',
            'latestImporters', 'urgentTasks', 'monthlySales',
            'recentActivity', 'performanceStats', 'chartData'
        ));
    }

    /**
     * الحصول على النشاط الأخير
     */
    private function getRecentActivity()
    {
        $activities = collect();
        
        // أحدث المستوردين
        $recentImporters = Importer::latest()->take(3)->get();
        foreach ($recentImporters as $importer) {
            $activities->push([
                'type' => 'importer',
                'title' => 'مستورد جديد: ' . $importer->name,
                'time' => $importer->created_at,
                'icon' => 'fas fa-truck',
                'color' => 'success'
            ]);
        }
        
        // أحدث الطلبات
        $recentOrders = ImporterOrder::latest()->take(3)->get();
        foreach ($recentOrders as $order) {
            $activities->push([
                'type' => 'order',
                'title' => 'طلب جديد #' . $order->order_number,
                'time' => $order->created_at,
                'icon' => 'fas fa-shopping-cart',
                'color' => 'primary'
            ]);
        }
        
        // أحدث المهام
        $recentTasks = Task::latest()->take(3)->get();
        foreach ($recentTasks as $task) {
            $activities->push([
                'type' => 'task',
                'title' => 'مهمة جديدة: ' . $task->title,
                'time' => $task->created_at,
                'icon' => 'fas fa-tasks',
                'color' => 'warning'
            ]);
        }
        
        return $activities->sortByDesc('time')->take(10);
    }

    /**
     * الحصول على إحصائيات الأداء
     */
    private function getPerformanceStats()
    {
        $currentMonth = now()->month;
        $lastMonth = now()->subMonth()->month;
        
        // مقارنة الطلبات
        $currentMonthOrders = ImporterOrder::whereRaw('strftime("%m", created_at) = ?', [str_pad($currentMonth, 2, '0', STR_PAD_LEFT)])->count();
        $lastMonthOrders = ImporterOrder::whereRaw('strftime("%m", created_at) = ?', [str_pad($lastMonth, 2, '0', STR_PAD_LEFT)])->count();
        $ordersGrowth = $lastMonthOrders > 0 ? (($currentMonthOrders - $lastMonthOrders) / $lastMonthOrders) * 100 : 0;
        
        // مقارنة المستوردين
        $currentMonthImporters = Importer::whereRaw('strftime("%m", created_at) = ?', [str_pad($currentMonth, 2, '0', STR_PAD_LEFT)])->count();
        $lastMonthImporters = Importer::whereRaw('strftime("%m", created_at) = ?', [str_pad($lastMonth, 2, '0', STR_PAD_LEFT)])->count();
        $importersGrowth = $lastMonthImporters > 0 ? (($currentMonthImporters - $lastMonthImporters) / $lastMonthImporters) * 100 : 0;
        
        // مقارنة الإيرادات
        $currentMonthRevenue = Transaction::getMonthlyRevenue();
        $lastMonthRevenue = Transaction::getMonthlyRevenue(now()->subMonth()->year, $lastMonth);
        $revenueGrowth = $lastMonthRevenue > 0 ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 : 0;
        
        return [
            'orders_growth' => round($ordersGrowth, 1),
            'importers_growth' => round($importersGrowth, 1),
            'revenue_growth' => round($revenueGrowth, 1),
            'current_month_orders' => $currentMonthOrders,
            'current_month_importers' => $currentMonthImporters,
            'current_month_revenue' => $currentMonthRevenue
        ];
    }

    /**
     * الحصول على بيانات الرسم البياني
     */
    private function getChartData()
    {
        $months = [];
        $importersData = [];
        $revenueData = [];
        
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M');
            
            
            $importersData[] = Importer::whereRaw('strftime("%m", created_at) = ?', [str_pad($date->month, 2, '0', STR_PAD_LEFT)])
                                     ->whereRaw('strftime("%Y", created_at) = ?', [$date->year])
                                     ->count();
            
            $revenueData[] = Transaction::getMonthlyRevenue($date->year, $date->month);
        }
        
        return [
            'months' => $months,
            'importers' => $importersData,
            'revenue' => $revenueData
        ];
    }

    /**
     * API endpoint للحصول على إحصائيات لوحة التحكم
     */
    public function getDashboardStats()
    {
        try {
            // إحصائيات سريعة
            $stats = [
                'total_users' => User::count(),
                'total_importers' => Importer::count(),
                'monthly_revenue' => Transaction::getMonthlyRevenue(),
                'total_tasks' => Task::count(),
                'pending_tasks' => Task::where('status', '!=', 'completed')->count(),
                'overdue_tasks' => Task::where('status', '!=', 'completed')
                                   ->where('due_date', '<', now())
                                   ->count(),
            ];

            // بيانات الرسم البياني
            $chartData = $this->getChartData();

            return response()->json([
                'success' => true,
                'stats' => $stats,
                'chartData' => $chartData,
                'timestamp' => now()->toISOString()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في جلب البيانات',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * عرض قائمة المستوردين
     */
    public function importersIndex()
    {
        $importers = Importer::latest()->paginate(10);
        return view('admin.importers.index', compact('importers'));
    }
    
    /**
     * عرض تفاصيل المستورد
     */
    public function importersShow($id)
    {
        $importer = Importer::findOrFail($id);
        $orders = ImporterOrder::where('importer_id', $importer->id)->latest()->get();
        return view('admin.importers.show', compact('importer', 'orders'));
    }
    
    /**
     * تحديث حالة المستورد
     */
    public function importersUpdateStatus(Request $request, $id)
    {
        $importer = Importer::findOrFail($id);
        $importer->status = $request->status;
        $importer->save();
        
        return redirect()->back()->with('success', 'تم تحديث حالة المستورد بنجاح');
    }

    /**
     * عرض نموذج إضافة مستورد جديد
     */
    public function importersCreate()
    {
        return view('admin.importers.create');
    }

    /**
     * حفظ بيانات المستورد الجديد
     */
    public function importersStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:importers',
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'business_type' => 'required|in:academy,school,store,hospital,other',
            'business_type_other' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
        ]);

        $importer = Importer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company_name' => $request->company_name,
            'business_type' => $request->business_type,
            'business_type_other' => $request->business_type_other,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'notes' => $request->notes,
            'status' => 'new',
        ]);

        return redirect()->route('admin.importers.index')
            ->with('success', 'تم إضافة المستورد بنجاح');
    }

    /**
     * عرض نموذج تعديل بيانات المستورد
     */
    public function importersEdit($id)
    {
        $importer = Importer::findOrFail($id);
        return view('admin.importers.edit', compact('importer'));
    }

    /**
     * تحديث بيانات المستورد
     */
    public function importersUpdate(Request $request, $id)
    {
        $importer = Importer::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:importers,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'company_name' => 'nullable|string|max:255',
            'business_type' => 'required|in:academy,school,store,hospital,other',
            'business_type_other' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
            'status' => 'required|in:new,contacted,qualified,proposal,negotiation,closed_won,closed_lost',
        ]);

        $importer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'company_name' => $request->company_name,
            'business_type' => $request->business_type,
            'business_type_other' => $request->business_type_other,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'notes' => $request->notes,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.importers.index')
            ->with('success', 'تم تحديث بيانات المستورد بنجاح');
    }

    /**
     * حذف المستورد
     */
    public function importersDestroy($id)
    {
        $importer = Importer::findOrFail($id);
        $importer->delete();

        return redirect()->route('admin.importers.index')
            ->with('success', 'تم حذف المستورد بنجاح');
    }
    
    /**
     * تحديث حالة الطلب
     */
    public function ordersUpdateStatus(Request $request, $id)
    {
        $order = ImporterOrder::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'تم تحديث حالة الطلب بنجاح']);
        }
        
        return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }
    
    /**
     * عرض طلبات المستوردين
     */
    public function importersOrders()
    {
        $orders = ImporterOrder::with(['importer', 'importer.user'])
            ->latest()
            ->paginate(15);
            
        return view('admin.importers.orders', compact('orders'));
    }

    /**
     * عرض جميع الطلبات
     */
    public function ordersIndex()
    {
        $orders = ImporterOrder::with(['importer', 'importer.user'])
            ->latest()
            ->paginate(15);
            
        return view('admin.orders.index', compact('orders'));
    }
    
    /**
     * عرض تفاصيل طلب واحد
     */
    public function showOrder($id)
    {
        $order = ImporterOrder::with(['importer', 'importer.user'])->findOrFail($id);
        
        return view('admin.orders.show', compact('order'));
    }
    
    
    // The dashboardUpdated method has been merged into the dashboard method

    /**
     * عرض تقارير المبيعات والأداء
     */
    public function reports()
    {
        // تقارير المبيعات حسب الشهر
        $monthlySales = ImporterOrder::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(final_cost) as total')
        )
        ->where('status', 'completed')
        ->whereRaw('YEAR(created_at) >= ?', [now()->subYear()->year])
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();

        // تقارير المستوردين حسب الحالة
        $importersByStatus = Importer::select(
            'status',
            DB::raw('COUNT(*) as total')
        )
        ->groupBy('status')
        ->get()
        ->pluck('total', 'status')
        ->toArray();

        // تقارير المهام حسب القسم
        $tasksByDepartment = Task::select(
            'department',
            DB::raw('COUNT(*) as total'),
            DB::raw('SUM(CASE WHEN status = "completed" THEN 1 ELSE 0 END) as completed')
        )
        ->groupBy('department')
        ->get();

        // أداء فريق المبيعات
        $salesPerformance = SalesTeam::with('admin')
            ->select(
                'sales_team.admin_id',
                DB::raw('COUNT(DISTINCT importer_orders.id) as total_orders'),
                DB::raw('SUM(CASE WHEN importer_orders.status = "completed" THEN 1 ELSE 0 END) as completed_orders'),
                DB::raw('SUM(CASE WHEN importer_orders.status = "processing" THEN 1 ELSE 0 END) as processing_orders')
            )
            ->leftJoin('importer_orders', 'sales_team.admin_id', '=', 'importer_orders.assigned_to')
            ->groupBy('sales_team.admin_id')
            ->get();

        // أداء فريق التسويق
        $marketingPerformance = MarketingTeam::with('admin')
            ->select(
                'marketing_team.admin_id',
                DB::raw('COUNT(DISTINCT tasks.id) as total_tasks'),
                DB::raw('SUM(CASE WHEN tasks.status = "completed" THEN 1 ELSE 0 END) as completed_tasks')
            )
            ->leftJoin('tasks', function($join) {
                $join->on('marketing_team.admin_id', '=', 'tasks.assigned_to')
                     ->where('tasks.department', '=', 'marketing');
            })
            ->groupBy('marketing_team.admin_id')
            ->get();

        return view('admin.reports', compact(
            'monthlySales',
            'importersByStatus',
            'tasksByDepartment',
            'salesPerformance',
            'marketingPerformance'
        ));
    }

    /**
     * عرض قائمة المستخدمين
     */
    public function users()
    {
        $users = User::where('user_type', 'customer')
            ->latest()
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * عرض نموذج إضافة مستخدم جديد
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * حفظ بيانات المستخدم الجديد
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => 'customer',
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'تم إضافة المستخدم بنجاح');
    }

    /**
     * عرض بيانات المستخدم
     */
    public function showUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    /**
     * عرض نموذج تعديل بيانات المستخدم
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * تحديث بيانات المستخدم
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')
            ->with('success', 'تم تحديث بيانات المستخدم بنجاح');
    }

    /**
     * حذف المستخدم
     */
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'تم حذف المستخدم بنجاح');
    }

    /**
     * الإعدادات العامة
     */
    public function settings()
    {
        $settings = \App\Models\Setting::getAll();
        return view('admin.settings', compact('settings'));
    }

    /**
     * تحديث الإعدادات
     */
    public function updateSettings(Request $request)
    {
        // Log the request for debugging
        Log::info('Settings update request received', [
            'has_site_logo' => $request->hasFile('site_logo'),
            'has_site_favicon' => $request->hasFile('site_favicon'),
            'all_files' => $request->allFiles(),
            'site_logo_valid' => $request->hasFile('site_logo') ? $request->file('site_logo')->isValid() : false,
            'site_logo_size' => $request->hasFile('site_logo') ? $request->file('site_logo')->getSize() : 0
        ]);

        $validatedData = $request->validate([
            // General Settings
            'site_name' => 'required|string|max:255',
            'site_tagline' => 'nullable|string|max:255',
            'site_description' => 'required|string',
            'default_language' => 'nullable|string|in:ar,en',
            'default_currency' => 'nullable|string|in:SAR,USD,EUR',
            'timezone' => 'nullable|string',
            
            // File Uploads
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp,avif|max:2048',
            'site_favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp,avif|max:1024',
            
            // Contact Information
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string',
            'whatsapp_number' => 'nullable|string',
            'support_email' => 'nullable|email',
            'address' => 'required|string',
            'business_hours' => 'nullable|string',
            'emergency_contact' => 'nullable|string',
            
            // Social Media
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'tiktok_url' => 'nullable|url',
            
            // System Settings
            'enable_registration' => 'boolean',
            'email_verification' => 'boolean',
            'maintenance_mode' => 'boolean',
            'debug_mode' => 'boolean',
            'backup_frequency' => 'nullable|string|in:daily,weekly,monthly',
            'log_level' => 'nullable|string|in:error,warning,info,debug',
            'session_timeout' => 'nullable|integer|min:30|max:1440',
        ]);

        try {
            // Handle file uploads
            if ($request->hasFile('site_logo')) {
                $logoFile = $request->file('site_logo');
                
                Log::info('Processing site_logo file', [
                    'file_name' => $logoFile->getClientOriginalName(),
                    'file_size' => $logoFile->getSize(),
                    'file_mime' => $logoFile->getMimeType(),
                    'is_valid' => $logoFile->isValid()
                ]);
                
                // Additional validation
                if (!$logoFile->isValid()) {
                    Log::error('Invalid logo file uploaded');
                    return redirect()->route('admin.settings')
                        ->with('error', 'ملف الشعار غير صالح');
                }
                
                // Delete old logo if exists
                $oldLogo = \App\Models\Setting::get('site_logo');
                if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                    Storage::disk('public')->delete($oldLogo);
                    Log::info('Deleted old logo', ['old_logo' => $oldLogo]);
                }
                
                $logoPath = $logoFile->store('settings', 'public');
                $validatedData['site_logo'] = $logoPath;
                
                Log::info('Logo saved successfully', [
                    'logo_path' => $logoPath,
                    'full_url' => asset('storage/' . $logoPath)
                ]);
            }

            if ($request->hasFile('site_favicon')) {
                $faviconFile = $request->file('site_favicon');
                
                // Additional validation
                if (!$faviconFile->isValid()) {
                    return redirect()->route('admin.settings')
                        ->with('error', 'ملف الأيقونة غير صالح');
                }
                
                // Delete old favicon if exists
                $oldFavicon = \App\Models\Setting::get('site_favicon');
                if ($oldFavicon && Storage::disk('public')->exists($oldFavicon)) {
                    Storage::disk('public')->delete($oldFavicon);
                }
                
                $faviconPath = $faviconFile->store('settings', 'public');
                $validatedData['site_favicon'] = $faviconPath;
            }

            // Convert boolean values
            $validatedData['enable_registration'] = $request->has('enable_registration') ? 1 : 0;
            $validatedData['email_verification'] = $request->has('email_verification') ? 1 : 0;
            $validatedData['maintenance_mode'] = $request->has('maintenance_mode') ? 1 : 0;
            $validatedData['debug_mode'] = $request->has('debug_mode') ? 1 : 0;

            // Save settings
            \App\Models\Setting::setMultiple($validatedData);

            // Clear cache
            \App\Models\Setting::clearCache();
            \App\Helpers\SiteSettingsHelper::clearCache();
            
            // مسح كاش Laravel العام
            \Illuminate\Support\Facades\Cache::flush();

            // Update environment file for critical settings
            $this->updateEnvironmentFile($validatedData);

            // Log successful update
            Log::info('Settings updated successfully', [
                'updated_fields' => array_keys($validatedData)
            ]);

            $successMessage = 'تم تحديث الإعدادات بنجاح';
            if (isset($validatedData['site_logo'])) {
                $successMessage .= ' - تم تحديث الشعار';
            }
            if (isset($validatedData['site_favicon'])) {
                $successMessage .= ' - تم تحديث الأيقونة';
            }

            return redirect()->route('admin.settings')
                ->with('success', $successMessage);

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Settings update failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()->route('admin.settings')
                ->with('error', 'حدث خطأ أثناء تحديث الإعدادات: ' . $e->getMessage());
        }
    }

    /**
     * Update environment file for critical settings
     */
    private function updateEnvironmentFile($settings)
    {
        $envFile = base_path('.env');
        
        if (file_exists($envFile)) {
            $envContent = file_get_contents($envFile);
            
            // Update critical settings
            $criticalSettings = [
                'APP_DEBUG' => $settings['debug_mode'] ? 'true' : 'false',
                'APP_LOCALE' => $settings['default_language'] ?? 'ar',
                'APP_TIMEZONE' => $settings['timezone'] ?? 'Asia/Riyadh',
            ];

            foreach ($criticalSettings as $key => $value) {
                if (strpos($envContent, $key) !== false) {
                    $envContent = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $envContent);
                } else {
                    $envContent .= "\n{$key}={$value}";
                }
            }

            file_put_contents($envFile, $envContent);
        }
    }
    
    /**
     * عرض قائمة المشرفين
     */
    public function admins()
    {
        // استخدام جدول الأدمن بدلاً من المستخدمين
        $admins = \App\Models\Admin::latest()->paginate(20);

        return view('admin.admins.index', compact('admins'));
    }

    /**
     * عرض نموذج إضافة مشرف جديد
     */
    public function createAdmin()
    {
        return view('admin.admins.create');
    }

    /**
     * حفظ بيانات المشرف الجديد
     */
    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:super_admin,admin,manager',
        ]);

        $admin = \App\Models\Admin::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => true,
        ]);

        return redirect()->route('admin.admins.index')
            ->with('success', 'تم إضافة المشرف بنجاح');
    }

    /**
     * عرض بيانات المشرف
     */
    public function showAdmin($id)
    {
        $admin = User::findOrFail($id);
        
        // التحقق من أن المستخدم هو مشرف
        if ($admin->role === 'customer') {
            return redirect()->route('admin.admins.index')
                ->with('error', 'هذا المستخدم ليس مشرفًا');
        }
        
        return view('admin.admins.show', compact('admin'));
    }

    /**
     * عرض نموذج تعديل بيانات المشرف
     */
    public function editAdmin($id)
    {
        $admin = \App\Models\Admin::findOrFail($id);
        
        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * تحديث بيانات المشرف
     */
    public function updateAdmin(Request $request, $id)
    {
        $admin = \App\Models\Admin::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:super_admin,admin,manager',
        ]);

        $adminData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $adminData['password'] = Hash::make($request->password);
        }

        $admin->update($adminData);

        return redirect()->route('admin.admins.index')
            ->with('success', 'تم تحديث بيانات المشرف بنجاح');
    }

    /**
     * حذف المشرف
     */
    public function destroyAdmin($id)
    {
        $admin = \App\Models\Admin::findOrFail($id);
        
        // منع حذف المشرف الحالي
        if ($admin->id === auth('admin')->id()) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'لا يمكنك حذف حسابك الخاص');
        }
        
        // حذف المشرف
        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'تم حذف المشرف بنجاح');
    }
    
    /**
     * عرض قائمة فريق التسويق
     */
    public function marketingTeam()
    {
        $marketingTeam = MarketingTeam::with('admin')
            ->where('is_active', true)
            ->latest()
            ->paginate(20);

        return view('admin.marketing_team.index', compact('marketingTeam'));
    }

    /**
     * عرض بيانات عضو فريق التسويق
     */
    public function showMarketingMember($id)
    {
        $member = MarketingTeam::with(['admin', 'tasks' => function($query) {
            $query->latest()->take(10);
        }])->findOrFail($id);

        // إحصائيات المهام
        $taskStats = [
            'total' => Task::where('assigned_to', $member->admin_id)
                ->where('department', 'marketing')
                ->count(),
            'completed' => Task::where('assigned_to', $member->admin_id)
                ->where('department', 'marketing')
                ->where('status', 'completed')
                ->count(),
            'pending' => Task::where('assigned_to', $member->admin_id)
                ->where('department', 'marketing')
                ->where('status', '!=', 'completed')
                ->count(),
            'overdue' => Task::where('assigned_to', $member->admin_id)
                ->where('department', 'marketing')
                ->where('status', '!=', 'completed')
                ->where('due_date', '<', now())
                ->count(),
        ];

        return view('admin.marketing_team.show', compact('member', 'taskStats'));
    }

    /**
     * تعيين مهمة جديدة لعضو فريق التسويق
     */
    public function assignTaskToMarketing(Request $request, $id)
    {
        $member = MarketingTeam::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'assigned_to' => $member->admin_id,
            'assigned_by' => Auth::id(),
            'department' => 'marketing',
            'priority' => $request->priority,
            'status' => 'pending',
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('admin.marketing.show', $id)
            ->with('success', 'تم تعيين المهمة بنجاح');
    }

    /**
     * تعطيل عضو فريق التسويق
     */
    public function disableMarketingMember($id)
    {
        $member = MarketingTeam::findOrFail($id);
        $member->update(['is_active' => false]);

        // تحديث دور المستخدم إلى مشرف عادي
        User::where('id', $member->admin_id)->update(['user_type' => 'admin']);

        return redirect()->route('admin.marketing.index')
            ->with('success', 'تم تعطيل عضو فريق التسويق بنجاح');
    }

    /**
     * عرض نموذج إضافة عضو جديد لفريق التسويق
     */
    public function createMarketingMember()
    {
        $admins = \App\Models\Admin::where('role', 'admin')->get();
        return view('admin.marketing_team.create', compact('admins'));
    }

    /**
     * حفظ بيانات عضو فريق التسويق الجديد
     */
    public function storeMarketingMember(Request $request)
    {
        $request->validate([
            'admin_id' => 'required|exists:admins,id',
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'phone' => 'nullable|string|max:20',
        ]);

        $member = MarketingTeam::create([
            'admin_id' => $request->admin_id,
            'department' => $request->department,
            'position' => $request->position,
            'bio' => $request->bio,
            'phone' => $request->phone,
            'is_active' => true,
        ]);

        return redirect()->route('admin.marketing.index')
            ->with('success', 'تم إضافة عضو فريق التسويق بنجاح');
    }

    /**
     * عرض نموذج تعديل بيانات عضو فريق التسويق
     */
    public function editMarketingMember($id)
    {
        $member = MarketingTeam::with('admin')->findOrFail($id);
        $admins = \App\Models\Admin::where('role', 'admin')->get();
        return view('admin.marketing_team.edit', compact('member', 'admins'));
    }

    /**
     * تحديث بيانات عضو فريق التسويق
     */
    public function updateMarketingMember(Request $request, $id)
    {
        $member = MarketingTeam::findOrFail($id);
        
        $request->validate([
            'admin_id' => 'required|exists:admins,id',
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'phone' => 'nullable|string|max:20',
        ]);

        $member->update([
            'admin_id' => $request->admin_id,
            'department' => $request->department,
            'position' => $request->position,
            'bio' => $request->bio,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.marketing.index')
            ->with('success', 'تم تحديث بيانات عضو فريق التسويق بنجاح');
    }

    /**
     * حذف عضو فريق التسويق
     */
    public function destroyMarketingMember($id)
    {
        $member = MarketingTeam::findOrFail($id);
        $member->delete();

        return redirect()->route('admin.marketing.index')
            ->with('success', 'تم حذف عضو فريق التسويق بنجاح');
    }
    
    /**
     * عرض قائمة فريق المبيعات
     */
    public function salesTeam()
    {
        $salesTeam = SalesTeam::with('admin')
            ->where('is_active', true)
            ->latest()
            ->paginate(20);

        return view('admin.sales_team.index', compact('salesTeam'));
    }

    /**
     * عرض بيانات عضو فريق المبيعات
     */
    public function showSalesMember($id)
    {
        $member = SalesTeam::with(['admin', 'tasks' => function($query) {
            $query->latest()->take(10);
        }])->findOrFail($id);

        // إحصائيات المهام
        $taskStats = [
            'total' => Task::where('assigned_to', $member->admin_id)
                ->where('department', 'sales')
                ->count(),
            'completed' => Task::where('assigned_to', $member->admin_id)
                ->where('department', 'sales')
                ->where('status', 'completed')
                ->count(),
            'pending' => Task::where('assigned_to', $member->admin_id)
                ->where('department', 'sales')
                ->where('status', '!=', 'completed')
                ->count(),
        ];

        // إحصائيات المستوردين
        $importerStats = [
            'total' => Importer::where('assigned_to', $member->admin_id)->count(),
            'new' => Importer::where('assigned_to', $member->admin_id)
                ->where('status', 'new')
                ->count(),
            'qualified' => Importer::where('assigned_to', $member->admin_id)
                ->where('status', 'qualified')
                ->count(),
            'proposal' => Importer::where('assigned_to', $member->admin_id)
                ->where('status', 'proposal')
                ->count(),
            'negotiation' => Importer::where('assigned_to', $member->admin_id)
                ->where('status', 'negotiation')
                ->count(),
            'closed_won' => Importer::where('assigned_to', $member->admin_id)
                ->where('status', 'closed_won')
                ->count(),
            'closed_lost' => Importer::where('assigned_to', $member->admin_id)
                ->where('status', 'closed_lost')
                ->count(),
        ];

        // إحصائيات الطلبات
        $orderStats = [
            'total' => ImporterOrder::whereHas('importer', function($query) use ($member) {
                $query->where('assigned_to', $member->admin_id);
            })->count(),
            'new' => ImporterOrder::whereHas('importer', function($query) use ($member) {
                $query->where('assigned_to', $member->admin_id);
            })->where('status', 'new')->count(),
            'processing' => ImporterOrder::whereHas('importer', function($query) use ($member) {
                $query->where('assigned_to', $member->admin_id);
            })->where('status', 'processing')->count(),
            'completed' => ImporterOrder::whereHas('importer', function($query) use ($member) {
                $query->where('assigned_to', $member->admin_id);
            })->where('status', 'completed')->count(),
        ];

        // حساب نسبة الإنجاز
        $achievement = $member->calculateAchievement();

        return view('admin.sales_team.show', compact(
            'member', 
            'taskStats', 
            'importerStats', 
            'orderStats',
            'achievement'
        ));
    }

    /**
     * تعيين مهمة جديدة لعضو فريق المبيعات
     */
    public function assignTaskToSales(Request $request, $id)
    {
        $member = SalesTeam::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'due_date' => 'required|date|after_or_equal:today',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'assigned_to' => $member->admin_id,
            'assigned_by' => Auth::id(),
            'department' => 'sales',
            'priority' => $request->priority,
            'status' => 'pending',
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('admin.sales.show', $id)
            ->with('success', 'تم تعيين المهمة بنجاح');
    }

    /**
     * تحديث هدف المبيعات لعضو فريق المبيعات
     */
    public function updateSalesTarget(Request $request, $id)
    {
        $member = SalesTeam::findOrFail($id);

        $request->validate([
            'target' => 'required|numeric|min:0',
        ]);

        $member->update(['target' => $request->target]);

        return redirect()->route('admin.sales.show', $id)
            ->with('success', 'تم تحديث هدف المبيعات بنجاح');
    }

    /**
     * تعطيل عضو فريق المبيعات
     */
    public function disableSalesMember($id)
    {
        $member = SalesTeam::findOrFail($id);
        $member->update(['is_active' => false]);

        // تحديث دور المستخدم إلى مشرف عادي
        User::where('id', $member->admin_id)->update(['user_type' => 'admin']);

        return redirect()->route('admin.sales.index')
            ->with('success', 'تم تعطيل عضو فريق المبيعات بنجاح');
    }
    
    /**
     * عرض قائمة معرض الأعمال
     */
    public function portfolio()
    {
        $portfolioItems = PortfolioItem::orderBy('sort_order')
            ->latest()
            ->paginate(20);

        return view('admin.portfolio.index', compact('portfolioItems'));
    }

    /**
     * عرض نموذج إضافة عمل جديد
     */
    public function createPortfolioItem()
    {
        return view('admin.portfolio.create');
    }

    /**
     * حفظ بيانات العمل الجديد
     */
    public function storePortfolioItem(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'client_name' => 'required|string|max:255',
            'completion_date' => 'required|date',
            'category' => 'required|string|max:100',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // معالجة الصورة الرئيسية
        $imagePath = $request->file('image')->store('images/portfolio', 'public');

        // معالجة معرض الصور
        $gallery = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $gallery[] = $image->store('images/portfolio/gallery', 'public');
            }
        }

        PortfolioItem::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'gallery' => $gallery,
            'client_name' => $request->client_name,
            'completion_date' => $request->completion_date,
            'category' => $request->category,
            'is_featured' => $request->is_featured ?? false,
            'sort_order' => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'تم إضافة العمل بنجاح');
    }

    /**
     * عرض نموذج تعديل العمل
     */
    public function editPortfolioItem($id)
    {
        $portfolioItem = PortfolioItem::findOrFail($id);
        return view('admin.portfolio.edit', compact('portfolioItem'));
    }

    /**
     * تحديث بيانات العمل
     */
    public function updatePortfolioItem(Request $request, $id)
    {
        $portfolioItem = PortfolioItem::findOrFail($id);
        
        // Debug: Log what's being received
        Log::info('Update Portfolio Request Data:', [
            'has_image' => $request->hasFile('image'),
            'image_file' => $request->file('image'),
            'all_files' => $request->allFiles(),
            'all_input' => $request->except(['_token', '_method'])
        ]);

        // Validate only non-file fields
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'client_name' => 'required|string|max:255',
            'completion_date' => 'required|date',
            'category' => 'required|string|max:100',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        // Manual file validation
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            Log::info('Image file details:', [
                'isValid' => $image->isValid(),
                'mimeType' => $image->getMimeType(),
                'size' => $image->getSize(),
                'originalName' => $image->getClientOriginalName(),
                'extension' => $image->getClientOriginalExtension()
            ]);
            
            if (!$image->isValid()) {
                return back()->withErrors(['image' => 'The uploaded image is not valid.'])->withInput();
            }
            
            $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/avif', 'image/webp'];
            if (!in_array($image->getMimeType(), $allowedMimes)) {
                return back()->withErrors(['image' => 'The image must be a file of type: jpeg, png, jpg, gif, avif, webp.'])->withInput();
            }
            
            if ($image->getSize() > 2048 * 1024) { // 2MB
                return back()->withErrors(['image' => 'The image may not be greater than 2MB.'])->withInput();
            }
        }

        if ($request->hasFile('gallery')) {
            $galleryFiles = $request->file('gallery');
            $allowedMimes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/avif', 'image/webp'];
            
            foreach ($galleryFiles as $index => $file) {
                if (!$file->isValid()) {
                    return back()->withErrors(["gallery.{$index}" => 'The uploaded image is not valid.'])->withInput();
                }
                
                if (!in_array($file->getMimeType(), $allowedMimes)) {
                    return back()->withErrors(["gallery.{$index}" => 'The image must be a file of type: jpeg, png, jpg, gif, avif, webp.'])->withInput();
                }
                
                if ($file->getSize() > 2048 * 1024) { // 2MB
                    return back()->withErrors(["gallery.{$index}" => 'The image may not be greater than 2MB.'])->withInput();
                }
            }
        }

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'client_name' => $request->client_name,
            'completion_date' => $request->completion_date,
            'category' => $request->category,
            'is_featured' => $request->is_featured ?? false,
            'sort_order' => $request->sort_order ?? 0,
        ];

        // معالجة الصورة الرئيسية إذا تم تحميلها
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            Log::info('Processing main image upload');
            // حذف الصورة القديمة
            if ($portfolioItem->image && Storage::disk('public')->exists($portfolioItem->image)) {
                Storage::disk('public')->delete($portfolioItem->image);
            }
            $imagePath = $request->file('image')->store('images/portfolio', 'public');
            $data['image'] = $imagePath;
            Log::info('Main image stored at: ' . $imagePath);
        }

        // معالجة معرض الصور إذا تم تحميلها
        if ($request->hasFile('gallery')) {
            $galleryFiles = $request->file('gallery');
            $validGalleryFiles = array_filter($galleryFiles, function($file) {
                return $file && $file->isValid();
            });
            
            if (!empty($validGalleryFiles)) {
                Log::info('Processing gallery images upload');
                $gallery = $portfolioItem->gallery ?? [];
                foreach ($validGalleryFiles as $image) {
                    $galleryPath = $image->store('images/portfolio/gallery', 'public');
                    $gallery[] = $galleryPath;
                    Log::info('Gallery image stored at: ' . $galleryPath);
                }
                $data['gallery'] = $gallery;
            }
        }

        // حذف الصور المحددة من المعرض
        if ($request->has('delete_gallery')) {
            $gallery = $portfolioItem->gallery ?? [];
            $deleteImages = $request->delete_gallery;
            foreach ($deleteImages as $index) {
                if (isset($gallery[$index])) {
                    if (Storage::disk('public')->exists($gallery[$index])) {
                        Storage::disk('public')->delete($gallery[$index]);
                    }
                    unset($gallery[$index]);
                }
            }
            $data['gallery'] = array_values($gallery);
        }

        Log::info('Updating portfolio item with data:', $data);
        $portfolioItem->update($data);
        Log::info('Portfolio item updated successfully');

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'تم تحديث العمل بنجاح');
    }

    /**
     * حذف العمل
     */
    public function destroyPortfolioItem($id)
    {
        $portfolioItem = PortfolioItem::findOrFail($id);

        // حذف الصورة الرئيسية
        if ($portfolioItem->image && Storage::disk('public')->exists($portfolioItem->image)) {
            Storage::disk('public')->delete($portfolioItem->image);
        }

        // حذف معرض الصور
        if ($portfolioItem->gallery) {
            foreach ($portfolioItem->gallery as $image) {
                if (Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
            }
        }

        $portfolioItem->delete();

        return redirect()->route('admin.portfolio.index')
            ->with('success', 'تم حذف العمل بنجاح');
    }

    /**
     * عرض قائمة التقييمات
     */
    public function testimonials()
    {
        $testimonials = Testimonial::orderBy('sort_order')
            ->latest()
            ->paginate(20);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * عرض نموذج إضافة تقييم جديد
     */
    public function createTestimonial()
    {
        return view('admin.testimonials.create');
    }

    /**
     * حفظ بيانات التقييم الجديدة
     */
    public function storeTestimonial(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_position' => 'required|string|max:255',
            'client_company' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $data = [
            'client_name' => $request->client_name,
            'client_position' => $request->client_position,
            'client_company' => $request->client_company,
            'content' => $request->content,
            'rating' => $request->rating,
            'is_active' => $request->is_active ?? true,
            'sort_order' => $request->sort_order ?? 0,
        ];

        // معالجة الصورة إذا تم تحميلها
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('testimonials', 'public');
        }

        Testimonial::create($data);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'تم إضافة التقييم بنجاح');
    }

    /**
     * عرض نموذج تعديل التقييم
     */
    public function editTestimonial($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * تحديث بيانات التقييم
     */
    public function updateTestimonial(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $request->validate([
            'client_name' => 'required|string|max:255',
            'client_position' => 'required|string|max:255',
            'client_company' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $data = [
            'client_name' => $request->client_name,
            'client_position' => $request->client_position,
            'client_company' => $request->client_company,
            'content' => $request->content,
            'rating' => $request->rating,
            'is_active' => $request->is_active ?? true,
            'sort_order' => $request->sort_order ?? 0,
        ];

        // معالجة الصورة إذا تم تحميلها
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
                Storage::disk('public')->delete($testimonial->image);
            }
            $data['image'] = $request->file('image')->store('testimonials', 'public');
        }

        $testimonial->update($data);

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'تم تحديث التقييم بنجاح');
    }

    /**
     * حذف التقييم
     */
    public function destroyTestimonial($id)
    {
        $testimonial = Testimonial::findOrFail($id);

        // حذف الصورة إذا وجدت
        if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
            Storage::disk('public')->delete($testimonial->image);
        }

        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'تم حذف التقييم بنجاح');
    }

    /**
     * عرض الملف الشخصي للمشرف
     */
    public function profile()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.profile.index', compact('admin'));
    }

    /**
     * تحديث الملف الشخصي للمشرف
     */
    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins,email,' . $admin->id,
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:1000',
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'bio' => $request->bio,
        ]);

        return redirect()->route('admin.profile')
            ->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    /**
     * تحديث كلمة مرور المشرف
     */
    public function updatePassword(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // التحقق من كلمة المرور الحالية
        if (!Hash::check($request->current_password, $admin->password)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
        }

        $admin->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.profile')
            ->with('success', 'تم تحديث كلمة المرور بنجاح');
    }

    /**
     * عرض إعدادات المشرف
     */
    public function adminSettings()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.settings.index', compact('admin'));
    }

    /**
     * تحديث إعدادات المشرف
     */
    public function updateAdminSettings(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        
        $request->validate([
            'language' => 'required|string|in:ar,en',
            'timezone' => 'required|string',
            'notifications' => 'nullable|array',
            'notifications.email' => 'boolean',
            'notifications.sms' => 'boolean',
            'notifications.push' => 'boolean',
        ]);

        $admin->update([
            'language' => $request->language,
            'timezone' => $request->timezone,
            'notification_settings' => json_encode($request->notifications ?? []),
        ]);

        return redirect()->route('admin.admin-settings')
            ->with('success', 'تم تحديث الإعدادات بنجاح');
    }
}
