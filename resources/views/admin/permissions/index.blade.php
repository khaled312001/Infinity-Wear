@extends('layouts.dashboard')

@section('title', 'إدارة الصلاحيات')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title mb-0">إدارة الصلاحيات والأدوار</h4>
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">
                            <i class="fas fa-plus me-2"></i>إضافة دور جديد
                        </button>
                        <a href="{{ route('admin.permissions.reset') }}" class="btn btn-warning" 
                           onclick="return confirm('هل أنت متأكد من إعادة تعيين جميع الصلاحيات؟')">
                            <i class="fas fa-undo me-2"></i>إعادة تعيين
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Tabs for different user types -->
                    <ul class="nav nav-tabs" id="permissionsTabs" role="tablist">
                        @foreach($permissionsByUserType as $userType => $permissions)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                        id="{{ $userType }}-tab" 
                                        data-bs-toggle="tab" 
                                        data-bs-target="#{{ $userType }}" 
                                        type="button" 
                                        role="tab">
                                    @switch($userType)
                                        @case('admin')
                                            <i class="fas fa-user-shield me-2"></i>الأدمن
                                            @break
                                        @case('sales')
                                            <i class="fas fa-chart-line me-2"></i>المبيعات
                                            @break
                                        @case('marketing')
                                            <i class="fas fa-bullhorn me-2"></i>التسويق
                                            @break
                                        @case('customer')
                                            <i class="fas fa-user me-2"></i>العملاء
                                            @break
                                        @case('importer')
                                            <i class="fas fa-industry me-2"></i>المستوردين
                                            @break
                                        @default
                                            {{ ucfirst($userType) }}
                                    @endswitch
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content" id="permissionsTabsContent">
                        @foreach($permissionsByUserType as $userType => $permissions)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                                 id="{{ $userType }}" 
                                 role="tabpanel">
                                <div class="row mt-4">
                                    <div class="col-12">
                                        <h5 class="mb-3">الصلاحيات المتاحة لـ {{ $permissions->first()->display_name ?? ucfirst($userType) }}</h5>
                                        
                                        <div class="row">
                                            @foreach($permissions->groupBy('module') as $module => $modulePermissions)
                                                <div class="col-md-6 col-lg-4 mb-4">
                                                    <div class="card border">
                                                        <div class="card-header bg-light">
                                                            <h6 class="mb-0">{{ ucfirst($module) }}</h6>
                                                        </div>
                                                        <div class="card-body">
                                                            @foreach($modulePermissions as $permission)
                                                                <div class="form-check">
                                                                    <input class="form-check-input" 
                                                                           type="checkbox" 
                                                                           value="{{ $permission->id }}" 
                                                                           id="permission_{{ $permission->id }}"
                                                                           disabled>
                                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                                        {{ $permission->display_name }}
                                                                    </label>
                                                                    @if($permission->description)
                                                                        <small class="text-muted d-block">{{ $permission->description }}</small>
                                                                    @endif
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Roles Management Section -->
                    <div class="mt-5">
                        <h5 class="mb-3">إدارة الأدوار</h5>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>اسم الدور</th>
                                        <th>الاسم المعروض</th>
                                        <th>الوصف</th>
                                        <th>عدد الصلاحيات</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($roles as $role)
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary">{{ $role->name }}</span>
                                            </td>
                                            <td>{{ $role->display_name }}</td>
                                            <td>{{ $role->description }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $role->permissions->count() }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-primary" 
                                                            onclick="editRole({{ $role->id }}, '{{ $role->display_name }}', '{{ $role->description }}', [{{ $role->permissions->pluck('id')->implode(',') }}])">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    @if(!in_array($role->name, ['super_admin', 'admin', 'sales', 'marketing', 'customer', 'importer']))
                                                        <button type="button" class="btn btn-outline-danger" 
                                                                onclick="deleteRole({{ $role->id }})">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Role Modal -->
<div class="modal fade" id="createRoleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.permissions.store-role') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">إضافة دور جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">اسم الدور (إنجليزي)</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="display_name" class="form-label">الاسم المعروض</label>
                                <input type="text" class="form-control" id="display_name" name="display_name" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">الوصف</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الصلاحيات</label>
                        <div class="row">
                            @foreach($permissionsByUserType as $userType => $permissions)
                                <div class="col-md-6">
                                    <h6>{{ ucfirst($userType) }}</h6>
                                    @foreach($permissions as $permission)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   value="{{ $permission->id }}" 
                                                   name="permissions[]" 
                                                   id="create_permission_{{ $permission->id }}">
                                            <label class="form-check-label" for="create_permission_{{ $permission->id }}">
                                                {{ $permission->display_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Role Modal -->
<div class="modal fade" id="editRoleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="editRoleForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">تعديل الدور</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_display_name" class="form-label">الاسم المعروض</label>
                                <input type="text" class="form-control" id="edit_display_name" name="display_name" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_description" class="form-label">الوصف</label>
                                <input type="text" class="form-control" id="edit_description" name="description">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الصلاحيات</label>
                        <div class="row">
                            @foreach($permissionsByUserType as $userType => $permissions)
                                <div class="col-md-6">
                                    <h6>{{ ucfirst($userType) }}</h6>
                                    @foreach($permissions as $permission)
                                        <div class="form-check">
                                            <input class="form-check-input edit-permission" type="checkbox" 
                                                   value="{{ $permission->id }}" 
                                                   name="permissions[]" 
                                                   id="edit_permission_{{ $permission->id }}">
                                            <label class="form-check-label" for="edit_permission_{{ $permission->id }}">
                                                {{ $permission->display_name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editRole(roleId, displayName, description, permissionIds) {
    document.getElementById('editRoleForm').action = `/admin/permissions/roles/${roleId}`;
    document.getElementById('edit_display_name').value = displayName;
    document.getElementById('edit_description').value = description;
    
    // Clear all checkboxes
    document.querySelectorAll('.edit-permission').forEach(checkbox => {
        checkbox.checked = false;
    });
    
    // Check the role's permissions
    permissionIds.forEach(permissionId => {
        const checkbox = document.getElementById(`edit_permission_${permissionId}`);
        if (checkbox) {
            checkbox.checked = true;
        }
    });
    
    new bootstrap.Modal(document.getElementById('editRoleModal')).show();
}

function deleteRole(roleId) {
    if (confirm('هل أنت متأكد من حذف هذا الدور؟')) {
        fetch(`/admin/permissions/roles/${roleId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message || 'حدث خطأ أثناء حذف الدور');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء حذف الدور');
        });
    }
}
</script>
@endsection