<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    /**
     * Display the permissions management page
     */
    public function index()
    {
        // Get permissions grouped by user type
        $permissionsByUserType = Permission::where('is_active', true)
            ->orderBy('user_type')
            ->orderBy('module')
            ->orderBy('display_name')
            ->get()
            ->groupBy('user_type');

        // Get roles with their permissions
        $roles = Role::with('permissions')->get();

        // Get current user type permissions from database
        $currentPermissions = $this->getCurrentPermissions();

        return view('admin.permissions.index', compact('permissionsByUserType', 'roles', 'currentPermissions'));
    }

    /**
     * Update permissions for roles
     */
    public function update(Request $request)
    {
        $request->validate([
            'role_permissions' => 'required|array',
            'role_permissions.*' => 'array'
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->role_permissions as $roleId => $permissionIds) {
                $role = Role::findOrFail($roleId);
                $role->permissions()->sync($permissionIds);
            }

            DB::commit();

            return redirect()->route('admin.permissions.index')
                ->with('success', 'تم تحديث الصلاحيات بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.permissions.index')
                ->with('error', 'حدث خطأ أثناء تحديث الصلاحيات: ' . $e->getMessage());
        }
    }

    /**
     * Get current permissions from database
     */
    private function getCurrentPermissions()
    {
        try {
            // Get role permissions
            $rolePermissions = DB::table('role_permissions')
                ->join('roles', 'role_permissions.role_id', '=', 'roles.id')
                ->join('permissions', 'role_permissions.permission_id', '=', 'permissions.id')
                ->select('roles.name as role_name', 'permissions.name as permission_name')
                ->get()
                ->groupBy('role_name')
                ->map(function ($group) {
                    return $group->pluck('permission_name')->toArray();
                })
                ->toArray();

            return $rolePermissions;
        } catch (\Exception $e) {
            // If table doesn't exist, return empty array
            return [];
        }
    }

    /**
     * Reset permissions to default
     */
    public function reset()
    {
        try {
            DB::beginTransaction();

            // Run the seeder to reset permissions
            $this->call(DashboardPermissionsSeeder::class);

            DB::commit();

            return redirect()->route('admin.permissions.index')
                ->with('success', 'تم إعادة تعيين الصلاحيات للقيم الافتراضية');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.permissions.index')
                ->with('error', 'حدث خطأ أثناء إعادة تعيين الصلاحيات: ' . $e->getMessage());
        }
    }

    /**
     * Create a new role
     */
    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'array'
        ]);

        try {
            DB::beginTransaction();

            $role = Role::create([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description,
                'is_active' => true
            ]);

            if ($request->permissions) {
                $role->permissions()->sync($request->permissions);
            }

            DB::commit();

            return redirect()->route('admin.permissions.index')
                ->with('success', 'تم إنشاء الدور بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.permissions.index')
                ->with('error', 'حدث خطأ أثناء إنشاء الدور: ' . $e->getMessage());
        }
    }

    /**
     * Update a role
     */
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'display_name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'array'
        ]);

        try {
            DB::beginTransaction();

            $role = Role::findOrFail($id);
            $role->update([
                'display_name' => $request->display_name,
                'description' => $request->description
            ]);

            if ($request->has('permissions')) {
                $role->permissions()->sync($request->permissions);
            }

            DB::commit();

            return redirect()->route('admin.permissions.index')
                ->with('success', 'تم تحديث الدور بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.permissions.index')
                ->with('error', 'حدث خطأ أثناء تحديث الدور: ' . $e->getMessage());
        }
    }

    /**
     * Delete a role
     */
    public function destroyRole($id)
    {
        try {
            $role = Role::findOrFail($id);
            
            // Check if role is being used
            if ($role->admins()->count() > 0 || $role->users()->count() > 0) {
                return redirect()->route('admin.permissions.index')
                    ->with('error', 'لا يمكن حذف هذا الدور لأنه مستخدم حالياً');
            }

            $role->permissions()->detach();
            $role->delete();

            return redirect()->route('admin.permissions.index')
                ->with('success', 'تم حذف الدور بنجاح');

        } catch (\Exception $e) {
            return redirect()->route('admin.permissions.index')
                ->with('error', 'حدث خطأ أثناء حذف الدور: ' . $e->getMessage());
        }
    }
}