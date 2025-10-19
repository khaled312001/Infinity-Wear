

<?php $__env->startSection('title', 'إدارة الجهات'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'إدارة الجهات'); ?>
<?php $__env->startSection('page-subtitle', 'إدارة جهات الاتصال والرسائل'); ?>

<?php $__env->startSection('content'); ?>
<div class="row g-4">
    <!-- إحصائيات سريعة -->
    <div class="col-12">
        <div class="row g-3">
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="dashboard-card text-center">
                    <div class="card-body">
                        <h3 class="text-primary"><?php echo e($stats['total']); ?></h3>
                        <p class="mb-0">إجمالي الجهات</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="dashboard-card text-center">
                    <div class="card-body">
                        <h3 class="text-warning"><?php echo e($stats['new']); ?></h3>
                        <p class="mb-0">جديدة</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="dashboard-card text-center">
                    <div class="card-body">
                        <h3 class="text-info"><?php echo e($stats['read']); ?></h3>
                        <p class="mb-0">مقروءة</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="dashboard-card text-center">
                    <div class="card-body">
                        <h3 class="text-success"><?php echo e($stats['replied']); ?></h3>
                        <p class="mb-0">تم الرد عليها</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="dashboard-card text-center">
                    <div class="card-body">
                        <h3 class="text-secondary"><?php echo e($stats['closed']); ?></h3>
                        <p class="mb-0">مغلقة</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="dashboard-card text-center">
                    <div class="card-body">
                        <h3 class="text-danger"><?php echo e($stats['high_priority']); ?></h3>
                        <p class="mb-0">أولوية عالية</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات إضافية -->
    <div class="col-12">
        <div class="row g-3">
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card text-center">
                    <div class="card-body">
                        <h4 class="text-info"><?php echo e($stats['inquiry']); ?></h4>
                        <p class="mb-0">استفسارات</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card text-center">
                    <div class="card-body">
                        <h4 class="text-warning"><?php echo e($stats['custom']); ?></h4>
                        <p class="mb-0">مخصصة</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card text-center">
                    <div class="card-body">
                        <h4 class="text-primary"><?php echo e($stats['marketing']); ?></h4>
                        <p class="mb-0">للتسويق</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="dashboard-card text-center">
                    <div class="card-body">
                        <h4 class="text-success"><?php echo e($stats['sales']); ?></h4>
                        <p class="mb-0">للمبيعات</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- فلترة وبحث -->
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-filter me-2 text-primary"></i>
                    فلترة وبحث الجهات
                </h5>
                <a href="<?php echo e(route('admin.contacts.create')); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    إضافة جهة جديدة
                </a>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">البحث</label>
                        <input type="text" class="form-control" name="search" 
                               value="<?php echo e(request('search')); ?>" placeholder="البحث في الجهات...">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">الحالة</label>
                        <select class="form-select" name="status">
                            <option value="">جميع الحالات</option>
                            <option value="new" <?php echo e(request('status') == 'new' ? 'selected' : ''); ?>>جديدة</option>
                            <option value="read" <?php echo e(request('status') == 'read' ? 'selected' : ''); ?>>مقروءة</option>
                            <option value="replied" <?php echo e(request('status') == 'replied' ? 'selected' : ''); ?>>تم الرد عليها</option>
                            <option value="closed" <?php echo e(request('status') == 'closed' ? 'selected' : ''); ?>>مغلقة</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">نوع الجهة</label>
                        <select class="form-select" name="contact_type">
                            <option value="">جميع الأنواع</option>
                            <option value="inquiry" <?php echo e(request('contact_type') == 'inquiry' ? 'selected' : ''); ?>>استفسار</option>
                            <option value="custom" <?php echo e(request('contact_type') == 'custom' ? 'selected' : ''); ?>>مخصص</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">التعيين</label>
                        <select class="form-select" name="assigned_to">
                            <option value="">جميع الفرق</option>
                            <option value="marketing" <?php echo e(request('assigned_to') == 'marketing' ? 'selected' : ''); ?>>التسويق</option>
                            <option value="sales" <?php echo e(request('assigned_to') == 'sales' ? 'selected' : ''); ?>>المبيعات</option>
                            <option value="both" <?php echo e(request('assigned_to') == 'both' ? 'selected' : ''); ?>>كلا الفريقين</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">الأولوية</label>
                        <select class="form-select" name="priority">
                            <option value="">جميع الأولويات</option>
                            <option value="low" <?php echo e(request('priority') == 'low' ? 'selected' : ''); ?>>منخفض</option>
                            <option value="medium" <?php echo e(request('priority') == 'medium' ? 'selected' : ''); ?>>متوسط</option>
                            <option value="high" <?php echo e(request('priority') == 'high' ? 'selected' : ''); ?>>عالي</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="<?php echo e(route('admin.contacts.index')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- قائمة الجهات -->
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-address-book me-2 text-primary"></i>
                    قائمة الجهات
                </h5>
                <div class="d-flex gap-2">
                    <button class="btn btn-outline-primary btn-sm" onclick="selectAll()">
                        <i class="fas fa-check-square me-1"></i>
                        تحديد الكل
                    </button>
                    <button class="btn btn-outline-warning btn-sm" onclick="bulkAssign()">
                        <i class="fas fa-users me-1"></i>
                        تعيين جماعي
                    </button>
                    <button class="btn btn-outline-danger btn-sm" onclick="bulkArchive()">
                        <i class="fas fa-archive me-1"></i>
                        أرشفة جماعية
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <?php if($contacts->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="30">
                                        <input type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                    </th>
                                    <th>الجهة</th>
                                    <th>المعلومات</th>
                                    <th>النوع</th>
                                    <th>التعيين</th>
                                    <th>الأولوية</th>
                                    <th>الحالة</th>
                                    <th>التاريخ</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $contacts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contact): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="<?php echo e($contact->status === 'new' ? 'table-warning' : ''); ?> <?php echo e($contact->priority === 'high' ? 'border-start border-danger border-3' : ''); ?>">
                                        <td>
                                            <input type="checkbox" class="contact-checkbox" value="<?php echo e($contact->id); ?>">
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                    <?php echo e(substr($contact->name, 0, 1)); ?>

                                                </div>
                                                <div>
                                                    <h6 class="mb-0"><?php echo e($contact->name); ?></h6>
                                                    <?php if($contact->company): ?>
                                                        <small class="text-muted"><?php echo e($contact->company); ?></small>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <small class="text-muted"><?php echo e($contact->email); ?></small>
                                                <?php if($contact->phone): ?>
                                                    <br><small class="text-muted"><?php echo e($contact->phone); ?></small>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo e($contact->contact_type === 'inquiry' ? 'info' : 'warning'); ?>">
                                                <?php echo e($contact->contact_type === 'inquiry' ? 'استفسار' : 'مخصص'); ?>

                                            </span>
                                            <br>
                                            <small class="text-muted"><?php echo e($contact->source_text); ?></small>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo e($contact->assigned_to === 'marketing' ? 'primary' : ($contact->assigned_to === 'sales' ? 'success' : 'info')); ?>">
                                                <?php echo e($contact->assigned_to_text); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge bg-<?php echo e($contact->priority_badge); ?>">
                                                <?php echo e($contact->priority_text); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <?php switch($contact->status):
                                                case ('new'): ?>
                                                    <span class="badge bg-warning">جديدة</span>
                                                    <?php break; ?>
                                                <?php case ('read'): ?>
                                                    <span class="badge bg-info">مقروءة</span>
                                                    <?php break; ?>
                                                <?php case ('replied'): ?>
                                                    <span class="badge bg-success">تم الرد عليها</span>
                                                    <?php break; ?>
                                                <?php case ('closed'): ?>
                                                    <span class="badge bg-secondary">مغلقة</span>
                                                    <?php break; ?>
                                            <?php endswitch; ?>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <?php echo e($contact->created_at->format('Y-m-d')); ?>

                                                <br>
                                                <?php echo e($contact->created_at->format('H:i')); ?>

                                            </small>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="<?php echo e(route('admin.contacts.show', $contact)); ?>" 
                                                   class="btn btn-sm btn-outline-primary" title="عرض">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="<?php echo e(route('admin.contacts.edit', $contact)); ?>" 
                                                   class="btn btn-sm btn-outline-warning" title="تعديل">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <?php if($contact->status === 'new'): ?>
                                                    <form method="POST" action="<?php echo e(route('admin.contacts.mark-read', $contact)); ?>" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-info" title="تمييز كمقروءة">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                <?php if($contact->status !== 'replied'): ?>
                                                    <form method="POST" action="<?php echo e(route('admin.contacts.mark-replied', $contact)); ?>" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-success" title="تمييز كرد عليها">
                                                            <i class="fas fa-reply"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                <?php if($contact->status !== 'closed'): ?>
                                                    <form method="POST" action="<?php echo e(route('admin.contacts.mark-closed', $contact)); ?>" class="d-inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <button type="submit" class="btn btn-sm btn-outline-secondary" title="إغلاق">
                                                            <i class="fas fa-lock"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                <form method="POST" action="<?php echo e(route('admin.contacts.destroy', $contact)); ?>" 
                                                      class="d-inline" 
                                                      onsubmit="return confirm('هل أنت متأكد من حذف هذه الجهة؟')">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="card-footer bg-white border-top">
                        <?php echo e($contacts->links()); ?>

                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-address-book fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">لا توجد جهات اتصال</h5>
                        <p class="text-muted">لم يتم إضافة أي جهات اتصال بعد</p>
                        <a href="<?php echo e(route('admin.contacts.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i>
                            إضافة جهة جديدة
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for bulk operations -->
<script>
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.contact-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
}

function selectAll() {
    const checkboxes = document.querySelectorAll('.contact-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
    document.getElementById('selectAll').checked = true;
}

function getSelectedContacts() {
    const checkboxes = document.querySelectorAll('.contact-checkbox:checked');
    return Array.from(checkboxes).map(checkbox => checkbox.value);
}

function bulkAssign() {
    const selectedIds = getSelectedContacts();
    if (selectedIds.length === 0) {
        alert('يرجى تحديد جهة واحدة على الأقل');
        return;
    }
    
    const team = prompt('اختر الفريق:\n1. marketing - التسويق\n2. sales - المبيعات\n3. both - كلا الفريقين');
    if (!team) return;
    
    const teamMap = {
        '1': 'marketing',
        '2': 'sales', 
        '3': 'both'
    };
    
    if (!teamMap[team]) {
        alert('اختيار غير صحيح');
        return;
    }
    
    if (confirm(`هل أنت متأكد من تعيين ${selectedIds.length} جهة لفريق ${teamMap[team]}؟`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?php echo e(route("admin.contacts.bulk-assign")); ?>';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '<?php echo e(csrf_token()); ?>';
        form.appendChild(csrfToken);
        
        const assignedTo = document.createElement('input');
        assignedTo.type = 'hidden';
        assignedTo.name = 'assigned_to';
        assignedTo.value = teamMap[team];
        form.appendChild(assignedTo);
        
        selectedIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'contact_ids[]';
            input.value = id;
            form.appendChild(input);
        });
        
        document.body.appendChild(form);
        form.submit();
    }
}

function bulkArchive() {
    const selectedIds = getSelectedContacts();
    if (selectedIds.length === 0) {
        alert('يرجى تحديد جهة واحدة على الأقل');
        return;
    }
    
    if (confirm(`هل أنت متأكد من أرشفة ${selectedIds.length} جهة؟`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?php echo e(route("admin.contacts.bulk-archive")); ?>';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '<?php echo e(csrf_token()); ?>';
        form.appendChild(csrfToken);
        
        selectedIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'contact_ids[]';
            input.value = id;
            form.appendChild(input);
        });
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Auto-refresh every 30 seconds for new contacts
setInterval(function() {
    // You can add auto-refresh logic here if needed
}, 30000);
</script>

<!-- Custom Styles -->
<style>
.dashboard-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border: none;
    margin-bottom: 1.5rem;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px 12px 0 0;
    border: none;
    padding: 1.5rem;
}

.avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 1rem;
    font-weight: 600;
}

.table th {
    background-color: #f8fafc;
    border-bottom: 2px solid #e2e8f0;
    font-weight: 600;
    color: #374151;
    padding: 1rem 0.75rem;
}

.table td {
    vertical-align: middle;
    border-bottom: 1px solid #e2e8f0;
    padding: 1rem 0.75rem;
}

.btn-group .btn {
    margin: 0 1px;
}

.border-start.border-danger {
    border-left-width: 4px !important;
}

.badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
    
    .avatar-sm {
        width: 30px;
        height: 30px;
        font-size: 0.8rem;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\contacts\index.blade.php ENDPATH**/ ?>