<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Importer;
use App\Models\MarketingTeam;
use App\Models\SalesTeam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * عرض قائمة المستخدمين
     */
    public function index(Request $request)
    {
        $query = User::query();

        // فلترة حسب نوع المستخدم
        if ($request->filled('user_type')) {
            $query->where('user_type', $request->user_type);
        }

        // فلترة حسب الحالة
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(20);

        // إحصائيات
        $stats = [
            'total' => User::count(),
            'active' => User::where('is_active', true)->count(),
            'inactive' => User::where('is_active', false)->count(),
            'by_type' => User::selectRaw('user_type, count(*) as count')
                ->groupBy('user_type')
                ->pluck('count', 'user_type')
                ->toArray()
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * عرض صفحة إنشاء مستخدم جديد
     */
    public function create()
    {
        $userTypes = [
            'admin' => 'مدير',
            'employee' => 'موظف',
            'importer' => 'مستورد',
            'sales' => 'مندوب مبيعات',
            'marketing' => 'موظف تسويق'
        ];

        return view('admin.users.create', compact('userTypes'));
    }

    /**
     * حفظ مستخدم جديد
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'user_type' => ['required', Rule::in(['admin', 'employee', 'importer', 'sales', 'marketing'])],
            'is_active' => 'boolean',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userData = $request->only([
            'name', 'email', 'phone', 'address', 'city', 'user_type', 'is_active', 'bio'
        ]);

        $userData['password'] = Hash::make($request->password);

        // رفع الصورة الشخصية
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $filename = time() . '_' . $avatar->getClientOriginalName();
            $avatar->storeAs('public/avatars', $filename);
            $userData['avatar'] = 'avatars/' . $filename;
        }

        $user = User::create($userData);

        // إنشاء سجل في الجداول المرتبطة حسب نوع المستخدم
        $this->createUserTypeRecord($user, $request);

        return redirect()->route('admin.users.index')
            ->with('success', 'تم إنشاء المستخدم بنجاح');
    }

    /**
     * عرض تفاصيل المستخدم
     */
    public function show(User $user)
    {
        $user->load(['importer', 'employee']);
        
        return view('admin.users.show', compact('user'));
    }

    /**
     * عرض صفحة تعديل المستخدم
     */
    public function edit(User $user)
    {
        $userTypes = [
            'admin' => 'مدير',
            'employee' => 'موظف',
            'importer' => 'مستورد',
            'sales' => 'مندوب مبيعات',
            'marketing' => 'موظف تسويق'
        ];

        return view('admin.users.edit', compact('user', 'userTypes'));
    }

    /**
     * تحديث بيانات المستخدم
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'user_type' => ['required', Rule::in(['admin', 'employee', 'importer', 'sales', 'marketing'])],
            'is_active' => 'boolean',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $userData = $request->only([
            'name', 'email', 'phone', 'address', 'city', 'user_type', 'is_active', 'bio'
        ]);

        // تحديث كلمة المرور إذا تم إدخالها
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        // رفع صورة شخصية جديدة
        if ($request->hasFile('avatar')) {
            // حذف الصورة القديمة
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            $avatar = $request->file('avatar');
            $filename = time() . '_' . $avatar->getClientOriginalName();
            $avatar->storeAs('public/avatars', $filename);
            $userData['avatar'] = 'avatars/' . $filename;
        }

        $user->update($userData);

        // تحديث السجلات المرتبطة
        $this->updateUserTypeRecord($user, $request);

        return redirect()->route('admin.users.index')
            ->with('success', 'تم تحديث بيانات المستخدم بنجاح');
    }

    /**
     * حذف المستخدم
     */
    public function destroy(User $user)
    {
        // حذف الصورة الشخصية
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // حذف السجلات المرتبطة
        $this->deleteUserTypeRecord($user);

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'تم حذف المستخدم بنجاح');
    }

    /**
     * تغيير حالة المستخدم
     */
    public function toggleStatus(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'تفعيل' : 'إلغاء تفعيل';
        
        return redirect()->back()
            ->with('success', "تم {$status} المستخدم بنجاح");
    }

    /**
     * إنشاء سجل في الجداول المرتبطة حسب نوع المستخدم
     */
    private function createUserTypeRecord(User $user, Request $request)
    {
        switch ($user->user_type) {
            case 'importer':
                Importer::create([
                    'user_id' => $user->id,
                    'company_name' => $request->company_name ?? '',
                    'company_type' => $request->company_type ?? '',
                    'business_license' => $request->business_license ?? '',
                    'is_verified' => false
                ]);
                break;
                
            case 'employee':
                \App\Models\Employee::create([
                    'user_id' => $user->id,
                    'department' => $request->department ?? 'عام',
                    'position' => $request->position ?? 'موظف',
                    'hire_date' => now(),
                    'is_active' => true
                ]);
                break;
                
            case 'marketing':
                MarketingTeam::create([
                    'user_id' => $user->id,
                    'department' => $request->department ?? 'تسويق',
                    'position' => $request->position ?? 'موظف تسويق',
                    'hire_date' => now(),
                    'is_active' => true
                ]);
                break;
                
            case 'sales':
                SalesTeam::create([
                    'user_id' => $user->id,
                    'department' => $request->department ?? 'مبيعات',
                    'position' => $request->position ?? 'مندوب مبيعات',
                    'hire_date' => now(),
                    'is_active' => true
                ]);
                break;
        }
    }

    /**
     * تحديث السجلات المرتبطة
     */
    private function updateUserTypeRecord(User $user, Request $request)
    {
        switch ($user->user_type) {
            case 'importer':
                $importer = $user->importer;
                if ($importer) {
                    $importer->update([
                        'company_name' => $request->company_name ?? $importer->company_name,
                        'company_type' => $request->company_type ?? $importer->company_type,
                        'business_license' => $request->business_license ?? $importer->business_license,
                    ]);
                }
                break;
                
            case 'employee':
                $employee = $user->employee;
                if ($employee) {
                    $employee->update([
                        'department' => $request->department ?? $employee->department,
                        'position' => $request->position ?? $employee->position,
                    ]);
                }
                break;
                
            case 'marketing':
                $marketing = $user->marketingTeam;
                if ($marketing) {
                    $marketing->update([
                        'department' => $request->department ?? $marketing->department,
                        'position' => $request->position ?? $marketing->position,
                    ]);
                }
                break;
                
            case 'sales':
                $sales = $user->salesTeam;
                if ($sales) {
                    $sales->update([
                        'department' => $request->department ?? $sales->department,
                        'position' => $request->position ?? $sales->position,
                    ]);
                }
                break;
        }
    }

    /**
     * حذف السجلات المرتبطة
     */
    private function deleteUserTypeRecord(User $user)
    {
        switch ($user->user_type) {
            case 'importer':
                $user->importer?->delete();
                break;
            case 'employee':
                $user->employee?->delete();
                break;
            case 'marketing':
                $user->marketingTeam?->delete();
                break;
            case 'sales':
                $user->salesTeam?->delete();
                break;
        }
    }

    /**
     * تصدير قائمة المستخدمين
     */
    public function export(Request $request)
    {
        $query = User::query();

        if ($request->filled('user_type')) {
            $query->where('user_type', $request->user_type);
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $users = $query->get();

        $filename = 'users_export_' . now()->format('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // إضافة BOM للدعم العربي
            fwrite($file, "\xEF\xBB\xBF");
            
            // رؤوس الأعمدة
            fputcsv($file, [
                'الاسم',
                'البريد الإلكتروني',
                'رقم الهاتف',
                'نوع المستخدم',
                'الحالة',
                'المدينة',
                'تاريخ الإنشاء'
            ]);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->name,
                    $user->email,
                    $user->phone ?? '',
                    $user->getUserTypeLabelAttribute(),
                    $user->is_active ? 'نشط' : 'غير نشط',
                    $user->city ?? '',
                    $user->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
