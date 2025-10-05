@extends('layouts.dashboard')

@section('title', 'إدارة الصلاحيات')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active">إدارة الصلاحيات</li>
                    </ol>
                </div>
                <h4 class="page-title">
                    <i class="fas fa-shield-alt me-2"></i>
                    إدارة الصلاحيات
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-users-cog me-2"></i>
                            صلاحيات أنواع المستخدمين
                        </h5>
                        <div class="btn-group">
                            <button type="button" class="btn btn-info btn-sm" onclick="showDemoDashboards()">
                                <i class="fas fa-eye me-1"></i>
                                عرض الديمو
                            </button>
                            <button type="button" class="btn btn-warning btn-sm" onclick="resetPermissions()">
                                <i class="fas fa-undo me-1"></i>
                                إعادة تعيين
                            </button>
                            <button type="button" class="btn btn-success btn-sm" onclick="savePermissions()">
                                <i class="fas fa-save me-1"></i>
                                حفظ التغييرات
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form id="permissionsForm" method="POST" action="{{ route('admin.permissions.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            @foreach($permissions as $userType => $userPermissions)
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card border">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="card-title mb-0">
                                                <i class="fas fa-user-{{ $userType === 'admin' ? 'shield' : ($userType === 'importer' ? 'truck' : ($userType === 'sales' ? 'chart-line' : 'bullhorn')) }} me-2"></i>
                                                {{ $userType === 'admin' ? 'الإداريين' : ($userType === 'importer' ? 'المستوردين' : ($userType === 'sales' ? 'فريق المبيعات' : 'فريق التسويق')) }}
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="permissions-list">
                                                @foreach($userPermissions as $permission => $description)
                                                    <div class="form-check mb-2">
                                                        <input 
                                                            class="form-check-input" 
                                                            type="checkbox" 
                                                            name="permissions[{{ $userType }}][{{ $permission }}]" 
                                                            value="1" 
                                                            id="{{ $userType }}_{{ $permission }}"
                                                            {{ isset($currentPermissions[$userType]) && in_array($permission, $currentPermissions[$userType]) ? 'checked' : '' }}
                                                        >
                                                        <label class="form-check-label" for="{{ $userType }}_{{ $permission }}">
                                                            {{ $description }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            
                                            <div class="mt-3">
                                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAll('{{ $userType }}')">
                                                    <i class="fas fa-check-double me-1"></i>
                                                    تحديد الكل
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAll('{{ $userType }}')">
                                                    <i class="fas fa-times me-1"></i>
                                                    إلغاء الكل
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-info" onclick="showUserTypeDemo('{{ $userType }}')">
                                                    <i class="fas fa-desktop me-1"></i>
                                                    عرض الديمو
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reset Confirmation Modal -->
<div class="modal fade" id="resetModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                    تأكيد إعادة التعيين
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>هل أنت متأكد من إعادة تعيين جميع الصلاحيات للقيم الافتراضية؟</p>
                <p class="text-muted small">سيتم فقدان جميع التغييرات الحالية.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <form method="POST" action="{{ route('admin.permissions.reset') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-undo me-1"></i>
                        إعادة تعيين
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Demo Dashboards Modal -->
<div class="modal fade" id="demoModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-desktop text-info me-2"></i>
                    <span id="demoModalTitle">عرض ديمو لوحات التحكم</span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3" id="demoDashboards">
                    <!-- Demo content will be loaded here -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-primary" onclick="openAllDemos()">
                    <i class="fas fa-external-link-alt me-1"></i>
                    فتح جميع الديمو
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Demo data for different user types
const demoData = {
    admin: {
        title: 'لوحة تحكم الإداريين',
        description: 'لوحة تحكم شاملة لجميع العمليات الإدارية',
        features: [
            'إدارة المستخدمين والإداريين',
            'إدارة الطلبات والفئات',
            'إدارة المحتوى والمعرض',
            'التقارير والإحصائيات',
            'إعدادات النظام والصلاحيات'
        ],
        url: '/admin/dashboard',
        color: 'primary'
    },
    importer: {
        title: 'لوحة تحكم المستوردين',
        description: 'لوحة تحكم مخصصة للمستوردين لإدارة طلباتهم',
        features: [
            'عرض وإدارة الطلبات',
            'إنشاء تصميمات مخصصة',
            'عرض معرض الأعمال',
            'إنشاء الشهادات',
            'التقارير الشخصية'
        ],
        url: '/importer/dashboard',
        color: 'success'
    },
    sales: {
        title: 'لوحة تحكم فريق المبيعات',
        description: 'لوحة تحكم متخصصة لفريق المبيعات',
        features: [
            'إدارة العملاء والطلبات',
            'إدارة العملاء المحتملين',
            'تقارير المبيعات',
            'إدارة الأهداف',
            'المهام والتتبع'
        ],
        url: '/sales/dashboard',
        color: 'info'
    },
    marketing: {
        title: 'لوحة تحكم فريق التسويق',
        description: 'لوحة تحكم متخصصة لفريق التسويق',
        features: [
            'إنشاء وإدارة المحتوى',
            'إدارة وسائل التواصل الاجتماعي',
            'إدارة الحملات التسويقية',
            'إدارة معرض الأعمال',
            'إدارة SEO والسلايدر'
        ],
        url: '/marketing/dashboard',
        color: 'warning'
    }
};

function selectAll(userType) {
    const checkboxes = document.querySelectorAll(`input[name^="permissions[${userType}]"]`);
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
    showNotification(`تم تحديد جميع صلاحيات ${getUserTypeName(userType)}`, 'success');
}

function deselectAll(userType) {
    const checkboxes = document.querySelectorAll(`input[name^="permissions[${userType}]"]`);
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    showNotification(`تم إلغاء جميع صلاحيات ${getUserTypeName(userType)}`, 'warning');
}

function savePermissions() {
    const form = document.getElementById('permissionsForm');
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>جاري الحفظ...';
    submitBtn.disabled = true;
    
    form.submit();
}

function resetPermissions() {
    const modal = new bootstrap.Modal(document.getElementById('resetModal'));
    modal.show();
}

function showDemoDashboards() {
    const modal = new bootstrap.Modal(document.getElementById('demoModal'));
    document.getElementById('demoModalTitle').textContent = 'عرض ديمو جميع لوحات التحكم';
    
    const demoContent = document.getElementById('demoDashboards');
    demoContent.innerHTML = '';
    
    Object.keys(demoData).forEach(userType => {
        const data = demoData[userType];
        const card = createDemoCard(userType, data);
        demoContent.appendChild(card);
    });
    
    modal.show();
}

function showUserTypeDemo(userType) {
    const modal = new bootstrap.Modal(document.getElementById('demoModal'));
    const data = demoData[userType];
    
    document.getElementById('demoModalTitle').textContent = `ديمو ${data.title}`;
    
    const demoContent = document.getElementById('demoDashboards');
    demoContent.innerHTML = '';
    
    const card = createDemoCard(userType, data);
    demoContent.appendChild(card);
    
    modal.show();
}

function createDemoCard(userType, data) {
    const col = document.createElement('div');
    col.className = 'col-md-6 col-lg-4';
    
    col.innerHTML = `
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-header bg-${data.color} text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-${getUserTypeIcon(userType)} me-2"></i>
                    ${data.title}
                </h6>
            </div>
            <div class="card-body">
                <p class="text-muted small">${data.description}</p>
                <ul class="list-unstyled small">
                    ${data.features.map(feature => `<li><i class="fas fa-check text-${data.color} me-2"></i>${feature}</li>`).join('')}
                </ul>
            </div>
            <div class="card-footer bg-transparent">
                <div class="d-grid gap-2">
                    <button class="btn btn-${data.color} btn-sm" onclick="openDemo('${userType}')">
                        <i class="fas fa-external-link-alt me-1"></i>
                        فتح الديمو
                    </button>
                    <button class="btn btn-outline-${data.color} btn-sm" onclick="simulateLogin('${userType}')">
                        <i class="fas fa-user me-1"></i>
                        محاكاة تسجيل الدخول
                    </button>
                </div>
            </div>
        </div>
    `;
    
    return col;
}

function openDemo(userType) {
    const data = demoData[userType];
    const url = data.url;
    
    // Open in new tab
    window.open(url, '_blank');
    
    showNotification(`تم فتح ديمو ${data.title} في تبويب جديد`, 'info');
}

function simulateLogin(userType) {
    const data = demoData[userType];
    
    // Show loading
    showNotification(`جاري محاكاة تسجيل الدخول كـ ${getUserTypeName(userType)}...`, 'info');
    
    // Simulate login process
    setTimeout(() => {
        showNotification(`تم تسجيل الدخول بنجاح كـ ${getUserTypeName(userType)}`, 'success');
        
        // Redirect to appropriate dashboard
        setTimeout(() => {
            window.location.href = data.url;
        }, 1000);
    }, 2000);
}

function openAllDemos() {
    Object.keys(demoData).forEach((userType, index) => {
        setTimeout(() => {
            openDemo(userType);
        }, index * 500);
    });
    
    showNotification('تم فتح جميع الديمو في تبويبات جديدة', 'success');
}

function getUserTypeName(userType) {
    const names = {
        'admin': 'الإداريين',
        'importer': 'المستوردين',
        'sales': 'فريق المبيعات',
        'marketing': 'فريق التسويق'
    };
    return names[userType] || userType;
}

function getUserTypeIcon(userType) {
    const icons = {
        'admin': 'user-shield',
        'importer': 'truck',
        'sales': 'chart-line',
        'marketing': 'bullhorn'
    };
    return icons[userType] || 'user';
}

function showNotification(message, type) {
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'warning' ? 'alert-warning' : 
                      type === 'info' ? 'alert-info' : 'alert-danger';
    
    const icon = type === 'success' ? 'fa-check-circle' : 
                type === 'warning' ? 'fa-exclamation-triangle' : 
                type === 'info' ? 'fa-info-circle' : 'fa-exclamation-circle';
    
    const alertHtml = `
        <div class="alert ${alertClass} alert-dismissible fade show position-fixed" 
             style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;">
            <i class="fas ${icon} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    document.body.insertAdjacentHTML('beforeend', alertHtml);
    
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
            alert.classList.remove('show');
            setTimeout(() => alert.remove(), 300);
        }
    }, 5000);
}

// Enhanced auto-save functionality
let autoSaveTimeout;
document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        clearTimeout(autoSaveTimeout);
        
        // Show visual feedback
        this.parentElement.classList.add('bg-light');
        
        autoSaveTimeout = setTimeout(() => {
            // Optional: Auto-save after 3 seconds of inactivity
            // savePermissions();
            this.parentElement.classList.remove('bg-light');
        }, 3000);
    });
});

// Add keyboard shortcuts
document.addEventListener('keydown', function(e) {
    if (e.ctrlKey || e.metaKey) {
        switch(e.key) {
            case 's':
                e.preventDefault();
                savePermissions();
                break;
            case 'r':
                e.preventDefault();
                resetPermissions();
                break;
            case 'd':
                e.preventDefault();
                showDemoDashboards();
                break;
        }
    }
});
</script>
@endsection

@section('styles')
<style>
:root {
    --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    --success-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    --info-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
}

.permissions-list {
    max-height: 400px;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: #667eea #f1f1f1;
}

.permissions-list::-webkit-scrollbar {
    width: 6px;
}

.permissions-list::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 3px;
}

.permissions-list::-webkit-scrollbar-thumb {
    background: #667eea;
    border-radius: 3px;
}

.permissions-list::-webkit-scrollbar-thumb:hover {
    background: #5a67d8;
}

.form-check-label {
    font-size: 0.9rem;
    line-height: 1.4;
    transition: all 0.3s ease;
    cursor: pointer;
}

.form-check-label:hover {
    color: #667eea;
    transform: translateX(5px);
}

.form-check-input:checked + .form-check-label {
    color: #667eea;
    font-weight: 600;
}

.card.border {
    border-color: #dee2e6 !important;
    transition: all 0.3s ease;
    border-radius: 15px;
}

.card.border:hover {
    border-color: #667eea !important;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.15);
    transform: translateY(-5px);
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    background: var(--primary-gradient) !important;
    border: none;
}

.page-title-box {
    margin-bottom: 1.5rem;
}

.btn-group .btn {
    margin-left: 0.25rem;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn-group .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.btn-info {
    background: var(--info-gradient);
    border: none;
}

.btn-success {
    background: var(--success-gradient);
    border: none;
}

.btn-warning {
    background: var(--warning-gradient);
    border: none;
}

/* Demo Modal Styles */
.modal-xl {
    max-width: 1200px;
}

.demo-card {
    transition: all 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
}

.demo-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.demo-card .card-header {
    background: var(--primary-gradient);
    border: none;
}

/* Permission Checkbox Animation */
.form-check-input {
    width: 1.2em;
    height: 1.2em;
    border-radius: 0.25em;
    transition: all 0.3s ease;
}

.form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
    transform: scale(1.1);
}

.form-check-input:focus {
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

/* Loading Animation */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.btn-loading {
    animation: pulse 1.5s infinite;
}

/* Notification Styles */
.alert {
    border-radius: 10px;
    border: none;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

/* Responsive Design */
@media (max-width: 768px) {
    .btn-group {
        flex-direction: column;
        width: 100%;
    }
    
    .btn-group .btn {
        margin-left: 0;
        margin-bottom: 0.25rem;
    }
    
    .permissions-list {
        max-height: 300px;
    }
    
    .card.border:hover {
        transform: none;
    }
}

@media (max-width: 576px) {
    .modal-xl {
        max-width: 95%;
        margin: 0.5rem;
    }
    
    .demo-card .card-body {
        padding: 1rem;
    }
}

/* Dark mode support */
@media (prefers-color-scheme: dark) {
    .card.border {
        background-color: #2d3748;
        border-color: #4a5568 !important;
    }
    
    .form-check-label {
        color: #e2e8f0;
    }
    
    .permissions-list {
        scrollbar-color: #667eea #2d3748;
    }
}

/* Accessibility improvements */
.form-check-input:focus-visible {
    outline: 2px solid #667eea;
    outline-offset: 2px;
}

.btn:focus-visible {
    outline: 2px solid #667eea;
    outline-offset: 2px;
}

/* Animation for permission changes */
.permission-changed {
    animation: highlight 0.5s ease-in-out;
}

@keyframes highlight {
    0% { background-color: transparent; }
    50% { background-color: rgba(102, 126, 234, 0.1); }
    100% { background-color: transparent; }
}
</style>
@endsection