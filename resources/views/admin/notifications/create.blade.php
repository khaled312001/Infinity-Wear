@extends('layouts.dashboard')

@section('title', 'إنشاء إشعار جديد')
@section('dashboard-title', 'إنشاء إشعار جديد')
@section('page-title', 'إرسال إشعار جديد')
@section('page-subtitle', 'إنشاء وإرسال إشعار مخصص للمستخدمين')

@section('content')
<!-- Header Section -->
<div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-plus me-2"></i>
                        إنشاء إشعار جديد
                    </h1>
                    <p class="text-muted">إرسال إشعار أو إيميل للمستخدمين</p>
                </div>
                <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-right me-2"></i>
                    العودة للقائمة
                </a>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.notifications.store') }}" id="notificationForm">
        @csrf
        
        <div class="row">
            <!-- Basic Information -->
            <div class="col-lg-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">معلومات الإشعار</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title" class="font-weight-bold">عنوان الإشعار <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                           id="title" name="title" value="{{ old('title') }}" 
                                           placeholder="أدخل عنوان الإشعار" required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category" class="font-weight-bold">الفئة</label>
                                    <input type="text" class="form-control @error('category') is-invalid @enderror" 
                                           id="category" name="category" value="{{ old('category') }}" 
                                           placeholder="مثال: تسويق، إعلان، تنبيه">
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="message" class="font-weight-bold">محتوى الإشعار <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                      id="message" name="message" rows="4" 
                                      placeholder="أدخل محتوى الإشعار" required>{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email_content" class="font-weight-bold">محتوى الإيميل</label>
                            <textarea class="form-control @error('email_content') is-invalid @enderror" 
                                      id="email_content" name="email_content" rows="6" 
                                      placeholder="أدخل محتوى الإيميل (اختياري)">{{ old('email_content') }}</textarea>
                            <small class="form-text text-muted">هذا المحتوى سيظهر في الإيميل فقط</small>
                            @error('email_content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Target Selection -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">اختيار المستهدفين</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-bold">نوع المستهدفين <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="target_type" 
                                               id="target_all" value="all" {{ old('target_type') == 'all' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="target_all">
                                            <i class="fas fa-users me-2"></i>جميع المستخدمين
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="target_type" 
                                               id="target_user_type" value="user_type" {{ old('target_type') == 'user_type' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="target_user_type">
                                            <i class="fas fa-user-tag me-2"></i>نوع مستخدم محدد
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="target_type" 
                                               id="target_specific" value="specific_users" {{ old('target_type') == 'specific_users' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="target_specific">
                                            <i class="fas fa-user-check me-2"></i>مستخدمين محددين
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('target_type')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- User Types Selection -->
                        <div id="user_types_section" class="form-group" style="display: none;">
                            <label class="font-weight-bold">اختيار أنواع المستخدمين</label>
                            <div class="row">
                                @foreach($userTypes as $type => $label)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input user-type-checkbox" type="checkbox" 
                                                   name="target_user_types[]" value="{{ $type }}" 
                                                   id="user_type_{{ $type }}"
                                                   {{ in_array($type, old('target_user_types', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="user_type_{{ $type }}">
                                                {{ $label }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('target_user_types')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Specific Users Selection -->
                        <div id="specific_users_section" class="form-group" style="display: none;">
                            <label class="font-weight-bold">اختيار المستخدمين</label>
                            <div class="row">
                                @foreach($users as $userType => $typeUsers)
                                    <div class="col-md-6 mb-3">
                                        <h6 class="text-primary">{{ $userTypes[$userType] ?? $userType }}</h6>
                                        <div style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; padding: 10px; border-radius: 5px;">
                                            @foreach($typeUsers as $user)
                                                <div class="form-check">
                                                    <input class="form-check-input specific-user-checkbox" type="checkbox" 
                                                           name="target_users[]" value="{{ $user->id }}" 
                                                           id="user_{{ $user->id }}"
                                                           {{ in_array($user->id, old('target_users', [])) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="user_{{ $user->id }}">
                                                        {{ $user->name }} ({{ $user->email }})
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('target_users')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Sidebar -->
            <div class="col-lg-4">
                <!-- Send Type -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">نوع الإرسال</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-bold">طريقة الإرسال <span class="text-danger">*</span></label>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="type" 
                                       id="type_notification" value="notification" {{ old('type', 'notification') == 'notification' ? 'checked' : '' }}>
                                <label class="form-check-label" for="type_notification">
                                    <i class="fas fa-bell me-2"></i>إشعار فقط
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="type" 
                                       id="type_email" value="email" {{ old('type') == 'email' ? 'checked' : '' }}>
                                <label class="form-check-label" for="type_email">
                                    <i class="fas fa-envelope me-2"></i>إيميل فقط
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="type" 
                                       id="type_both" value="both" {{ old('type') == 'both' ? 'checked' : '' }}>
                                <label class="form-check-label" for="type_both">
                                    <i class="fas fa-bell me-2"></i><i class="fas fa-envelope me-2"></i>إشعار وإيميل
                                </label>
                            </div>
                            @error('type')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Priority -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">الأولوية</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label class="font-weight-bold">أولوية الإشعار <span class="text-danger">*</span></label>
                            <select name="priority" id="priority" class="form-control @error('priority') is-invalid @enderror">
                                <option value="low" {{ old('priority', 'normal') == 'low' ? 'selected' : '' }}>منخفضة</option>
                                <option value="normal" {{ old('priority', 'normal') == 'normal' ? 'selected' : '' }}>عادية</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>عالية</option>
                                <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>عاجلة</option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Scheduling -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">جدولة الإرسال</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_scheduled" 
                                       id="is_scheduled" value="1" {{ old('is_scheduled') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_scheduled">
                                    جدولة الإرسال
                                </label>
                            </div>
                        </div>
                        
                        <div id="scheduling_section" class="form-group" style="display: none;">
                            <label for="scheduled_at" class="font-weight-bold">تاريخ ووقت الإرسال</label>
                            <input type="datetime-local" class="form-control @error('scheduled_at') is-invalid @enderror" 
                                   id="scheduled_at" name="scheduled_at" 
                                   value="{{ old('scheduled_at') }}"
                                   min="{{ now()->format('Y-m-d\TH:i') }}">
                            @error('scheduled_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Preview -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">معاينة الإشعار</h6>
                    </div>
                    <div class="card-body">
                        <div id="notification_preview" class="border rounded p-3 bg-light">
                            <div class="text-center text-muted">
                                <i class="fas fa-eye fa-2x mb-2"></i>
                                <p>ستظهر معاينة الإشعار هنا</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Buttons -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow">
                    <div class="card-body text-center">
                        <button type="submit" class="btn btn-primary btn-lg me-3">
                            <i class="fas fa-paper-plane me-2"></i>
                            إرسال الإشعار
                        </button>
                        <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-times me-2"></i>
                            إلغاء
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Handle target type change
    $('input[name="target_type"]').change(function() {
        const targetType = $(this).val();
        
        // Hide all sections
        $('#user_types_section, #specific_users_section').hide();
        
        // Show relevant section
        if (targetType === 'user_type') {
            $('#user_types_section').show();
        } else if (targetType === 'specific_users') {
            $('#specific_users_section').show();
        }
    });

    // Handle scheduling checkbox
    $('#is_scheduled').change(function() {
        if ($(this).is(':checked')) {
            $('#scheduling_section').show();
        } else {
            $('#scheduling_section').hide();
        }
    });

    // Handle send type change
    $('input[name="type"]').change(function() {
        updatePreview();
    });

    // Update preview on input change
    $('#title, #message, #email_content, #priority').on('input change', function() {
        updatePreview();
    });

    // Initialize on page load
    $('input[name="target_type"]:checked').trigger('change');
    $('#is_scheduled').trigger('change');
    updatePreview();

    function updatePreview() {
        const title = $('#title').val() || 'عنوان الإشعار';
        const message = $('#message').val() || 'محتوى الإشعار';
        const priority = $('#priority').val();
        const type = $('input[name="type"]:checked').val();
        
        const priorityLabels = {
            'low': 'منخفضة',
            'normal': 'عادية',
            'high': 'عالية',
            'urgent': 'عاجلة'
        };
        
        const typeLabels = {
            'notification': 'إشعار فقط',
            'email': 'إيميل فقط',
            'both': 'إشعار وإيميل'
        };
        
        const priorityColors = {
            'low': 'success',
            'normal': 'primary',
            'high': 'warning',
            'urgent': 'danger'
        };
        
        const preview = `
            <div class="notification-preview">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0 font-weight-bold">${title}</h6>
                    <span class="badge badge-${priorityColors[priority]} badge-sm">${priorityLabels[priority]}</span>
                </div>
                <p class="mb-2">${message}</p>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">${typeLabels[type]}</small>
                    <small class="text-muted">الآن</small>
                </div>
            </div>
        `;
        
        $('#notification_preview').html(preview);
    }
});
</script>
@endpush
