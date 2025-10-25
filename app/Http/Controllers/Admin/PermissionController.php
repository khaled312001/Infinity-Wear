<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Database\Seeders\DashboardPermissionsSeeder;

class PermissionController extends Controller
{
    /**
     * Display the permissions management page
     */
    public function index()
    {
        // Get permissions grouped by user type (exclude customer)
        $permissionsByUserType = Permission::where('is_active', true)
            ->where('user_type', '!=', 'customer')
            ->orderBy('user_type')
            ->orderBy('module')
            ->orderBy('display_name')
            ->get()
            ->groupBy('user_type');

        // Get roles with their permissions (exclude customer)
        $roles = Role::where('name', '!=', 'customer')
            ->with('permissions')
            ->get();

        // Ensure all roles have appropriate permissions
        $this->ensureRolePermissions($roles);

        // Unify super_admin and admin (treat as the same role in the UI)
        $adminRole = $roles->firstWhere('name', 'admin');
        $superAdminRole = $roles->firstWhere('name', 'super_admin');
        if ($adminRole && $superAdminRole) {
            // Merge permissions for display
            $mergedPermissions = $adminRole->permissions
                ->merge($superAdminRole->permissions)
                ->unique('id')
                ->values();
            $adminRole->setRelation('permissions', $mergedPermissions);

            // Hide super_admin from the list (since it's unified with admin)
            $roles = $roles->reject(function ($role) {
                return $role->name === 'super_admin';
            })->values();
        }

        return view('admin.permissions.index', compact('permissionsByUserType', 'roles'));
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

                // Keep admin and super_admin in sync
                if (in_array($role->name, ['admin', 'super_admin'], true)) {
                    $peerRoleName = $role->name === 'admin' ? 'super_admin' : 'admin';
                    $peerRole = Role::where('name', $peerRoleName)->first();
                    if ($peerRole) {
                        $peerRole->permissions()->sync($permissionIds);
                    }
                }
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
            Artisan::call('db:seed', [
                '--class' => DashboardPermissionsSeeder::class,
                '--force' => true,
            ]);

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
            'user_type' => 'required|string|in:admin,sales,marketing,importer',
            'permissions' => 'array'
        ]);

        try {
            DB::beginTransaction();

            $role = Role::create([
                'name' => $request->name,
                'display_name' => $request->display_name,
                'description' => $request->description,
                'user_type' => $request->user_type,
                'is_active' => true
            ]);

            if ($request->has('permissions')) {
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
            'user_type' => 'required|string|in:admin,sales,marketing,importer',
            'permissions' => 'array'
        ]);

        try {
            DB::beginTransaction();

            $role = Role::findOrFail($id);
            $role->update([
                'display_name' => $request->display_name,
                'description' => $request->description,
                'user_type' => $request->user_type
            ]);

            if ($request->has('permissions')) {
                $role->permissions()->sync($request->permissions);
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json(['success' => true, 'message' => 'تم تحديث الدور بنجاح']);
            }

            return redirect()->route('admin.permissions.index')
                ->with('success', 'تم تحديث الدور بنجاح');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'حدث خطأ أثناء تحديث الدور: ' . $e->getMessage()]);
            }
            
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
                return response()->json([
                    'success' => false,
                    'message' => 'لا يمكن حذف هذا الدور لأنه مستخدم حالياً'
                ]);
            }

            $role->permissions()->detach();
            $role->delete();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف الدور بنجاح'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حذف الدور: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Ensure all roles have appropriate permissions
     */
    private function ensureRolePermissions($roles)
    {
        foreach ($roles as $role) {
            if ($role->permissions->count() == 0) {
                $permissions = [];
                
                switch ($role->name) {
                    case 'super_admin':
                    case 'admin':
                        // Get all active permissions
                        $permissions = Permission::where('is_active', true)->pluck('id')->toArray();
                        break;
                        
                    case 'sales':
                        // Get sales-specific permissions
                        $permissions = Permission::where('is_active', true)
                            ->where('user_type', 'sales')
                            ->pluck('id')
                            ->toArray();
                        break;
                        
                    case 'marketing':
                        // Get marketing-specific permissions
                        $permissions = Permission::where('is_active', true)
                            ->where('user_type', 'marketing')
                            ->pluck('id')
                            ->toArray();
                        break;
                        
                    case 'importer':
                        // Get importer-specific permissions
                        $permissions = Permission::where('is_active', true)
                            ->where('user_type', 'importer')
                            ->pluck('id')
                            ->toArray();
                        break;
                }
                
                if (!empty($permissions)) {
                    $role->permissions()->sync($permissions);
                    $role->load('permissions');
                }
            }
        }
    }
}