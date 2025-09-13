<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * عرض لوحة التحكم الرئيسية
     */
    public function dashboard()
    {
        // إحصائيات عامة محسنة
        $totalImporters = Importer::count();
        $newImporters = Importer::where('status', 'pending')->count();
        $approvedImporters = Importer::where('status', 'approved')->count();
        $rejectedImporters = Importer::where('status', 'rejected')->count();
        
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->get();
        $processingOrders = ImporterOrder::where('status', 'processing')->count();
        $completedOrders = ImporterOrder::where('status', 'completed')->count();
        
        // إحصائيات المستخدمين والتصاميم
        $totalUsers = User::count();
        $totalDesigns = \App\Models\CustomDesign::count();
        
        // الإيرادات الشهرية (إذا كان هناك جدول المعاملات)
        $monthlyRevenue = 0;
        if (class_exists('\App\Models\Transaction')) {
            $monthlyRevenue = \App\Models\Transaction::getMonthlyRevenue();
        }
        
        $totalTasks = Task::count();
        $pendingTasks = Task::where('status', '!=', 'completed')->count();
        $overdueTasks = Task::where('status', '!=', 'completed')
                          ->where('due_date', '<', now())
                          ->count();
        
        $marketingTeamCount = MarketingTeam::where('is_active', true)->count();
        $salesTeamCount = SalesTeam::where('is_active', true)->count();
        
        // أحدث المستوردين
        $latestImporters = Importer::latest()->take(5)->get();
        
        // إعداد الإحصائيات للوحة التحكم
        $stats = [
            'total_orders' => $totalOrders,
            'total_users' => $totalUsers,
            'total_designs' => $totalDesigns,
            'monthly_revenue' => $monthlyRevenue,
            'pending_orders' => $pendingOrders->count(),
            'total_importers' => $totalImporters,
            'new_importers' => $newImporters,
            'approved_importers' => $approvedImporters,
            'rejected_importers' => $rejectedImporters,
        ];
        
        // أحدث الطلبات
        $latestOrders = ImporterOrder::with('importer')->latest()->take(5)->get();
        
        // المهام العاجلة
        $urgentTasks = Task::where('status', '!=', 'completed')
                         ->where('priority', 'high')
                         ->orderBy('due_date')
                         ->take(5)
                         ->get();
        
        // إحصائيات المبيعات
        $monthlySales = ImporterOrder::where('status', 'completed')
                                   ->whereYear('updated_at', now()->year)
                                   ->selectRaw('MONTH(updated_at) as month, SUM(final_cost) as total')
                                   ->groupBy('month')
                                   ->get()
                                   ->pluck('total', 'month')
                                   ->toArray();
        
        return view('admin.dashboard', compact(
            'stats', 'pendingOrders',
            'totalImporters', 'newImporters', 'approvedImporters', 'rejectedImporters',
            'totalOrders', 'processingOrders', 'completedOrders',
            'totalTasks', 'pendingTasks', 'overdueTasks',
            'marketingTeamCount', 'salesTeamCount',
            'latestImporters', 'latestOrders', 'urgentTasks', 'monthlySales'
        ));
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
     * تحديث حالة الطلب
     */
    public function ordersUpdateStatus(Request $request, $id)
    {
        $order = ImporterOrder::findOrFail($id);
        $order->status = $request->status;
        $order->save();
        
        return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }
    
    /**
     * عرض قائمة الطلبات
     */
    public function ordersIndex()
    {
        $orders = Order::with('user')->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }
    
    /**
     * عرض قائمة الطلبات الجديدة
     */
    public function newOrders()
    {
        $newOrders = ImporterOrder::where('status', 'pending')->latest()->paginate(10);
        return view('admin.orders.new', compact('newOrders'));
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
        ->whereYear('created_at', '>=', now()->subYear()->year)
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
                DB::raw('COUNT(DISTINCT importers.id) as total_importers'),
                DB::raw('SUM(CASE WHEN importers.status = "closed_won" THEN 1 ELSE 0 END) as won_deals'),
                DB::raw('SUM(CASE WHEN importers.status = "closed_lost" THEN 1 ELSE 0 END) as lost_deals')
            )
            ->leftJoin('importers', 'sales_team.admin_id', '=', 'importers.assigned_to')
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
        $users = User::where('role', 'customer')
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
        return view('admin.settings');
    }

    /**
     * تحديث الإعدادات
     */
    public function updateSettings(Request $request)
    {
        $validatedData = $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'required|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string',
            'address' => 'required|string',
            'facebook_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
        ]);

        // حفظ الإعدادات في قاعدة البيانات أو ملف التكوين
        foreach ($validatedData as $key => $value) {
            // يمكن حفظها في جدول الإعدادات
            DB::table('settings')->updateOrInsert(
                ['key' => $key],
                ['value' => $value, 'updated_at' => now()]
            );
        }

        return redirect()->route('admin.settings')
            ->with('success', 'تم تحديث الإعدادات بنجاح');
    }
    
    /**
     * عرض قائمة المشرفين
     */
    public function admins()
    {
        $admins = User::where('role', '!=', 'customer')
            ->latest()
            ->paginate(20);

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
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,marketing,sales',
        ]);

        $admin = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        // إذا كان المشرف من فريق التسويق، أضفه إلى جدول فريق التسويق
        if ($request->role === 'marketing') {
            MarketingTeam::create([
                'admin_id' => $admin->id,
                'is_active' => true,
            ]);
        }

        // إذا كان المشرف من فريق المبيعات، أضفه إلى جدول فريق المبيعات
        if ($request->role === 'sales') {
            SalesTeam::create([
                'admin_id' => $admin->id,
                'is_active' => true,
                'target' => $request->target ?? 0,
            ]);
        }

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
        $admin = User::findOrFail($id);
        
        // التحقق من أن المستخدم هو مشرف
        if ($admin->role === 'customer') {
            return redirect()->route('admin.admins.index')
                ->with('error', 'هذا المستخدم ليس مشرفًا');
        }
        
        return view('admin.admins.edit', compact('admin'));
    }

    /**
     * تحديث بيانات المشرف
     */
    public function updateAdmin(Request $request, $id)
    {
        $admin = User::findOrFail($id);
        
        // التحقق من أن المستخدم هو مشرف
        if ($admin->role === 'customer') {
            return redirect()->route('admin.admins.index')
                ->with('error', 'هذا المستخدم ليس مشرفًا');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,marketing,sales',
        ]);

        $oldRole = $admin->role;
        $newRole = $request->role;

        $adminData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $newRole,
        ];

        if ($request->filled('password')) {
            $adminData['password'] = Hash::make($request->password);
        }

        $admin->update($adminData);

        // إذا تغير الدور، قم بتحديث الجداول ذات الصلة
        if ($oldRole !== $newRole) {
            // إذا كان الدور القديم هو التسويق، قم بإلغاء تنشيط السجل في جدول فريق التسويق
            if ($oldRole === 'marketing') {
                MarketingTeam::where('admin_id', $admin->id)->update(['is_active' => false]);
            }
            
            // إذا كان الدور القديم هو المبيعات، قم بإلغاء تنشيط السجل في جدول فريق المبيعات
            if ($oldRole === 'sales') {
                SalesTeam::where('admin_id', $admin->id)->update(['is_active' => false]);
            }
            
            // إذا كان الدور الجديد هو التسويق، قم بإضافة سجل جديد أو تنشيط السجل الموجود في جدول فريق التسويق
            if ($newRole === 'marketing') {
                MarketingTeam::updateOrCreate(
                    ['admin_id' => $admin->id],
                    ['is_active' => true]
                );
            }
            
            // إذا كان الدور الجديد هو المبيعات، قم بإضافة سجل جديد أو تنشيط السجل الموجود في جدول فريق المبيعات
            if ($newRole === 'sales') {
                SalesTeam::updateOrCreate(
                    ['admin_id' => $admin->id],
                    ['is_active' => true, 'target' => $request->target ?? 0]
                );
            }
        } else if ($newRole === 'sales' && $request->has('target')) {
            // إذا لم يتغير الدور ولكن تم تحديث الهدف لمندوب المبيعات
            SalesTeam::where('admin_id', $admin->id)->update(['target' => $request->target]);
        }

        return redirect()->route('admin.admins.index')
            ->with('success', 'تم تحديث بيانات المشرف بنجاح');
    }

    /**
     * حذف المشرف
     */
    public function destroyAdmin($id)
    {
        $admin = User::findOrFail($id);
        
        // التحقق من أن المستخدم هو مشرف
        if ($admin->role === 'customer') {
            return redirect()->route('admin.admins.index')
                ->with('error', 'هذا المستخدم ليس مشرفًا');
        }
        
        // إذا كان المشرف من فريق التسويق، قم بإلغاء تنشيط السجل في جدول فريق التسويق
        if ($admin->role === 'marketing') {
            MarketingTeam::where('admin_id', $admin->id)->update(['is_active' => false]);
        }
        
        // إذا كان المشرف من فريق المبيعات، قم بإلغاء تنشيط السجل في جدول فريق المبيعات
        if ($admin->role === 'sales') {
            SalesTeam::where('admin_id', $admin->id)->update(['is_active' => false]);
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
        User::where('id', $member->admin_id)->update(['role' => 'admin']);

        return redirect()->route('admin.marketing.index')
            ->with('success', 'تم تعطيل عضو فريق التسويق بنجاح');
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
        User::where('id', $member->admin_id)->update(['role' => 'admin']);

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
        $imagePath = $request->file('image')->store('portfolio', 'public');

        // معالجة معرض الصور
        $gallery = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $gallery[] = $image->store('portfolio/gallery', 'public');
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

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'client_name' => 'required|string|max:255',
            'completion_date' => 'required|date',
            'category' => 'required|string|max:100',
            'is_featured' => 'boolean',
            'sort_order' => 'nullable|integer',
        ]);

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
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            if ($portfolioItem->image && Storage::disk('public')->exists($portfolioItem->image)) {
                Storage::disk('public')->delete($portfolioItem->image);
            }
            $data['image'] = $request->file('image')->store('portfolio', 'public');
        }

        // معالجة معرض الصور إذا تم تحميلها
        if ($request->hasFile('gallery')) {
            $gallery = $portfolioItem->gallery ?? [];
            foreach ($request->file('gallery') as $image) {
                $gallery[] = $image->store('portfolio/gallery', 'public');
            }
            $data['gallery'] = $gallery;
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

        $portfolioItem->update($data);

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
     * عرض نموذج إضافة شهادة جديدة
     */
    public function createTestimonial()
    {
        return view('admin.testimonials.create');
    }

    /**
     * حفظ بيانات الشهادة الجديدة
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
            ->with('success', 'تم إضافة الشهادة بنجاح');
    }

    /**
     * عرض نموذج تعديل الشهادة
     */
    public function editTestimonial($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    /**
     * تحديث بيانات الشهادة
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
            ->with('success', 'تم تحديث الشهادة بنجاح');
    }

    /**
     * حذف الشهادة
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
            ->with('success', 'تم حذف الشهادة بنجاح');
    }
}
