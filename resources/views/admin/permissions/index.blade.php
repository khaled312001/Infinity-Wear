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
@endsection

@section('scripts')
<script>
function selectAll(userType) {
    const checkboxes = document.querySelectorAll(`input[name^="permissions[${userType}]"]`);
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
}

function deselectAll(userType) {
    const checkboxes = document.querySelectorAll(`input[name^="permissions[${userType}]"]`);
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
}

function savePermissions() {
    document.getElementById('permissionsForm').submit();
}

function resetPermissions() {
    const modal = new bootstrap.Modal(document.getElementById('resetModal'));
    modal.show();
}

// Auto-save functionality (optional)
let autoSaveTimeout;
document.querySelectorAll('input[type="checkbox"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        clearTimeout(autoSaveTimeout);
        autoSaveTimeout = setTimeout(() => {
            // Optional: Auto-save after 2 seconds of inactivity
            // savePermissions();
        }, 2000);
    });
});
</script>
@endsection

@section('styles')
<style>
.permissions-list {
    max-height: 400px;
    overflow-y: auto;
}

.form-check-label {
    font-size: 0.9rem;
    line-height: 1.4;
}

.card.border {
    border-color: #dee2e6 !important;
}

.card.border:hover {
    border-color: #007bff !important;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 123, 255, 0.075);
}

.page-title-box {
    margin-bottom: 1.5rem;
}

.btn-group .btn {
    margin-left: 0.25rem;
}

@media (max-width: 768px) {
    .btn-group {
        flex-direction: column;
        width: 100%;
    }
    
    .btn-group .btn {
        margin-left: 0;
        margin-bottom: 0.25rem;
    }
}
</style>
@endsection