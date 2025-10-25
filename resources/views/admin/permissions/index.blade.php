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
                                                <span class="badge bg-info" id="permission-count-{{ $role->id }}">{{ $role->permissions->count() }}</span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button type="button" class="btn btn-outline-primary js-edit-role"
                                                            data-role-id="{{ $role->id }}"
                                                            data-display-name="{{ e($role->display_name) }}"
                                                            data-description="{{ e($role->description) }}"
                                                            data-user-type="{{ e($role->user_type) }}"
                                                            data-permissions='@json($role->permissions->pluck('id'))'>
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    @if(!in_array($role->name, ['super_admin', 'admin', 'sales', 'marketing', 'importer']))
                                                        <button type="button" class="btn btn-outline-danger js-delete-role" 
                                                                data-role-id="{{ $role->id }}">
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
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('admin.permissions.store-role') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">إضافة دور جديد</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="name" class="form-label">اسم الدور (إنجليزي)</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="display_name" class="form-label">الاسم المعروض</label>
                                <input type="text" class="form-control" id="display_name" name="display_name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="user_type" class="form-label">نوع المستخدم</label>
                                <select class="form-select" id="user_type" name="user_type" required onchange="filterPermissionsByUserType('create')">
                                    <option value="">اختر نوع المستخدم</option>
                                    <option value="admin">الأدمن</option>
                                    <option value="sales">فريق المبيعات</option>
                                    <option value="marketing">فريق التسويق</option>
                                    <option value="importer">المستوردين</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">الوصف</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-shield-alt me-2"></i>
                            الصلاحيات
                            <small class="text-muted">(اختر الصلاحيات المناسبة لهذا الدور)</small>
                        </label>
                        <div class="row">
                            @foreach($permissionsByUserType as $userType => $sections)
                                @if($userType === 'customer')
                                    @continue
                                @endif
                                <div class="col-md-6 mb-3" data-user-type="{{ $userType }}">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">
                                                <i class="fas fa-user-tag me-2"></i>
                                                @if($userType === 'admin')
                                                    <i class="fas fa-crown me-1"></i>الأدمن
                                                @elseif($userType === 'sales')
                                                    <i class="fas fa-handshake me-1"></i>فريق المبيعات
                                                @elseif($userType === 'marketing')
                                                    <i class="fas fa-bullhorn me-1"></i>فريق التسويق
                                                @elseif($userType === 'importer')
                                                    <i class="fas fa-industry me-1"></i>المستوردين
                                                @else
                                                    {{ ucfirst($userType) }}
                                                @endif
                                                <span class="badge bg-primary ms-2">{{ $sections->sum(fn($section) => $section['permissions']->count()) }}</span>
                                            </h6>
                                        </div>
                                        <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                                            <div class="mb-3">
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllPermissions('create', '{{ $userType }}')">
                                                    <i class="fas fa-check-double me-1"></i>
                                                    تحديد الكل
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAllPermissions('create', '{{ $userType }}')">
                                                    <i class="fas fa-times me-1"></i>
                                                    إلغاء الكل
                                                </button>
                                            </div>
                                            
                                            @foreach($sections as $sectionKey => $section)
                                                <div class="mb-3">
                                                    <h6 class="text-primary mb-2">
                                                        <i class="fas fa-folder me-1"></i>
                                                        {{ $section['title'] }}
                                                        <span class="badge bg-light text-dark ms-2">{{ $section['permissions']->count() }}</span>
                                                    </h6>
                                                    <div class="ps-3">
                                                        @foreach($section['permissions'] as $permission)
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input create-permission-{{ $userType }}" type="checkbox" 
                                                               value="{{ $permission->id }}" 
                                                               name="permissions[]" 
                                                               id="create_permission_{{ $permission->id }}">
                                                                <label class="form-check-label" for="create_permission_{{ $permission->id }}">
                                                                    <div class="d-flex align-items-center">
                                                                        @php
                                                                            $icon = match($permission->module) {
                                                                                'dashboard' => 'tachometer-alt',
                                                                                'content' => 'edit',
                                                                                'importers' => 'industry',
                                                                                'tasks' => 'tasks',
                                                                                'financial' => 'chart-pie',
                                                                                'teams' => 'users',
                                                                                'customers' => 'user-friends',
                                                                                'system' => 'cog',
                                                                                'notifications' => 'bell',
                                                                                'contacts' => 'envelope',
                                                                                'whatsapp' => 'comments',
                                                                                'support' => 'life-ring',
                                                                                'orders' => 'shopping-cart',
                                                                                'profile' => 'user',
                                                                                default => 'file'
                                                                            };
                                                                        @endphp
                                                                        <i class="fas fa-{{ $icon }} me-2 text-muted"></i>
                                                                        <div>
                                                                            <strong>{{ $permission->display_name }}</strong>
                                                                            @if($permission->description)
                                                                                <br><small class="text-muted">{{ $permission->description }}</small>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
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
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit_display_name" class="form-label">الاسم المعروض</label>
                                <input type="text" class="form-control" id="edit_display_name" name="display_name" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit_description" class="form-label">الوصف</label>
                                <input type="text" class="form-control" id="edit_description" name="description">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="edit_user_type" class="form-label">نوع المستخدم</label>
                                <select class="form-select" id="edit_user_type" name="user_type" required onchange="filterPermissionsByUserType('edit')">
                                    <option value="">اختر نوع المستخدم</option>
                                    <option value="admin">الأدمن</option>
                                    <option value="sales">فريق المبيعات</option>
                                    <option value="marketing">فريق التسويق</option>
                                    <option value="importer">المستوردين</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">
                            <i class="fas fa-shield-alt me-2"></i>
                            الصلاحيات
                            <small class="text-muted">(اختر الصلاحيات المناسبة لهذا الدور)</small>
                        </label>
                        <div class="row">
                            @foreach($permissionsByUserType as $userType => $sections)
                                @if($userType === 'customer')
                                    @continue
                                @endif
                                <div class="col-md-6 mb-3" data-user-type="{{ $userType }}">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="mb-0">
                                                <i class="fas fa-user-tag me-2"></i>
                                                @if($userType === 'admin')
                                                    <i class="fas fa-crown me-1"></i>الأدمن
                                                @elseif($userType === 'sales')
                                                    <i class="fas fa-handshake me-1"></i>فريق المبيعات
                                                @elseif($userType === 'marketing')
                                                    <i class="fas fa-bullhorn me-1"></i>فريق التسويق
                                                @elseif($userType === 'importer')
                                                    <i class="fas fa-industry me-1"></i>المستوردين
                                                @else
                                                    {{ ucfirst($userType) }}
                                                @endif
                                                <span class="badge bg-primary ms-2">{{ $sections->sum(fn($section) => $section['permissions']->count()) }}</span>
                                            </h6>
                                        </div>
                                        <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                                            <div class="mb-3">
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAllPermissions('edit', '{{ $userType }}')">
                                                    <i class="fas fa-check-double me-1"></i>
                                                    تحديد الكل
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAllPermissions('edit', '{{ $userType }}')">
                                                    <i class="fas fa-times me-1"></i>
                                                    إلغاء الكل
                                                </button>
                                            </div>
                                            
                                            @foreach($sections as $sectionKey => $section)
                                                <div class="mb-3">
                                                    <h6 class="text-primary mb-2">
                                                        <i class="fas fa-folder me-1"></i>
                                                        {{ $section['title'] }}
                                                        <span class="badge bg-light text-dark ms-2">{{ $section['permissions']->count() }}</span>
                                                    </h6>
                                                    <div class="ps-3">
                                                        @foreach($section['permissions'] as $permission)
                                                            <div class="form-check mb-2">
                                                                <input class="form-check-input edit-permission edit-permission-{{ $userType }}" type="checkbox" 
                                                               value="{{ $permission->id }}" 
                                                               name="permissions[]" 
                                                               id="edit_permission_{{ $permission->id }}">
                                                                <label class="form-check-label" for="edit_permission_{{ $permission->id }}">
                                                                    <div class="d-flex align-items-center">
                                                                        @php
                                                                            $icon = match($permission->module) {
                                                                                'dashboard' => 'tachometer-alt',
                                                                                'content' => 'edit',
                                                                                'importers' => 'industry',
                                                                                'tasks' => 'tasks',
                                                                                'financial' => 'chart-pie',
                                                                                'teams' => 'users',
                                                                                'customers' => 'user-friends',
                                                                                'system' => 'cog',
                                                                                'notifications' => 'bell',
                                                                                'contacts' => 'envelope',
                                                                                'whatsapp' => 'comments',
                                                                                'support' => 'life-ring',
                                                                                'orders' => 'shopping-cart',
                                                                                'profile' => 'user',
                                                                                default => 'file'
                                                                            };
                                                                        @endphp
                                                                        <i class="fas fa-{{ $icon }} me-2 text-muted"></i>
                                                                        <div>
                                                                            <strong>{{ $permission->display_name }}</strong>
                                                                            @if($permission->description)
                                                                                <br><small class="text-muted">{{ $permission->description }}</small>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        @endforeach
                                                    </div>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary" id="saveEditBtn">
                        <i class="fas fa-save me-1"></i>
                        حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Edit role buttons
    document.querySelectorAll('.js-edit-role').forEach(button => {
        button.addEventListener('click', function() {
            const roleId = this.getAttribute('data-role-id');
            const displayName = this.getAttribute('data-display-name') || '';
            const description = this.getAttribute('data-description') || '';
            let permissions = [];
            try {
                const raw = this.getAttribute('data-permissions');
                permissions = raw ? JSON.parse(raw) : [];
            } catch (e) {
                permissions = [];
            }
            const userType = this.getAttribute('data-user-type');
            editRole(roleId, displayName, description, userType, permissions);
        });
    });

    // Delete role buttons
    document.querySelectorAll('.js-delete-role').forEach(button => {
        button.addEventListener('click', function() {
            const roleId = this.getAttribute('data-role-id');
            deleteRole(roleId);
        });
    });
});

function editRole(roleId, displayName, description, userType, permissionIds) {
    const form = document.getElementById('editRoleForm');
    form.action = `/admin/permissions/roles/${roleId}`;
    
    document.getElementById('edit_display_name').value = displayName;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_user_type').value = userType;
    
    // تصفية الصلاحيات حسب نوع المستخدم
    filterPermissionsByUserType('edit');
    
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
    
    // إضافة event listener للزر
    const saveBtn = document.getElementById('saveEditBtn');
    saveBtn.onclick = function(e) {
        e.preventDefault();
        
        // إظهار loading
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>جاري الحفظ...';
        saveBtn.disabled = true;
        
        const formData = new FormData(form);
        
        // Ensure unchecked permissions are not included
        const uncheckedBoxes = document.querySelectorAll('.edit-permission:not(:checked)');
        uncheckedBoxes.forEach(checkbox => {
            // Remove any existing entries for this permission
            const permissionId = checkbox.value;
            const existingEntries = Array.from(formData.entries()).filter(([key, value]) => key === 'permissions[]' && value === permissionId);
            existingEntries.forEach(([key, value]) => {
                formData.delete(key);
            });
        });
        
        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // تحديث العدد في الجدول
                const selectedPermissions = document.querySelectorAll('.edit-permission:checked');
                const permissionCount = selectedPermissions.length;
                const roleId = form.action.split('/').pop();
                const countElement = document.getElementById(`permission-count-${roleId}`);
                if (countElement) {
                    countElement.textContent = permissionCount;
                }
                
                // إغلاق المودال
                const modal = bootstrap.Modal.getInstance(document.getElementById('editRoleModal'));
                modal.hide();
                
                // إعادة تحميل الصفحة
                location.reload();
            } else {
                alert('حدث خطأ أثناء تحديث الدور: ' + data.message);
                // إعادة تعيين الزر
                saveBtn.innerHTML = '<i class="fas fa-save me-1"></i>حفظ التغييرات';
                saveBtn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء تحديث الدور');
            // إعادة تعيين الزر
            saveBtn.innerHTML = '<i class="fas fa-save me-1"></i>حفظ التغييرات';
            saveBtn.disabled = false;
        });
    };
    
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

// دوال تحديد وإلغاء تحديد الصلاحيات
function selectAllPermissions(modalType, userType) {
    const checkboxes = document.querySelectorAll(`.${modalType}-permission-${userType}`);
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
}

function deselectAllPermissions(modalType, userType) {
    const checkboxes = document.querySelectorAll(`.${modalType}-permission-${userType}`);
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
}

// دالة تصفية الصلاحيات حسب نوع المستخدم
function filterPermissionsByUserType(modalType) {
    const userTypeSelect = document.getElementById(`${modalType}_user_type`);
    const selectedUserType = userTypeSelect.value;
    
    // إخفاء جميع بطاقات الصلاحيات
    const permissionCards = document.querySelectorAll(`#${modalType}RoleModal .col-md-6`);
    permissionCards.forEach(card => {
        card.style.display = 'none';
    });
    
    // إظهار بطاقة الصلاحيات المحددة فقط
    if (selectedUserType) {
        const targetCard = document.querySelector(`#${modalType}RoleModal .col-md-6[data-user-type="${selectedUserType}"]`);
        if (targetCard) {
            targetCard.style.display = 'block';
        }
    }
}

</script>
@endsection

<style>
#saveEditBtn {
    position: relative;
    z-index: 1000;
    pointer-events: auto;
    cursor: pointer;
}

.modal-footer {
    position: relative;
    z-index: 1000;
}

.modal-footer .btn {
    position: relative;
    z-index: 1001;
}
</style>