@extends('layouts.dashboard')

@section('title', 'تعديل جهة الاتصال')
@section('dashboard-title', 'تعديل جهة الاتصال')
@section('page-title', 'تعديل جهة الاتصال')
@section('page-subtitle', 'تعديل معلومات جهة الاتصال')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2 text-primary"></i>
                    تعديل جهة الاتصال: {{ $contact->name }}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.contacts.update', $contact) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <!-- المعلومات الأساسية -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-user me-2"></i>
                                المعلومات الأساسية
                            </h6>
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">الاسم <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $contact->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">البريد الإلكتروني <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $contact->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">الهاتف</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', $contact->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="company" class="form-label">الشركة</label>
                                <input type="text" class="form-control @error('company') is-invalid @enderror" 
                                       id="company" name="company" value="{{ old('company', $contact->company) }}">
                                @error('company')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- تفاصيل الرسالة -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-envelope me-2"></i>
                                تفاصيل الرسالة
                            </h6>

                            <div class="mb-3">
                                <label for="subject" class="form-label">الموضوع <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                       id="subject" name="subject" value="{{ old('subject', $contact->subject) }}" required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">الرسالة <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('message') is-invalid @enderror" 
                                          id="message" name="message" rows="4" required>{{ old('message', $contact->message) }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <!-- إعدادات الجهة -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-cog me-2"></i>
                                إعدادات الجهة
                            </h6>

                            <div class="mb-3">
                                <label for="status" class="form-label">الحالة <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" name="status" required>
                                    <option value="new" {{ old('status', $contact->status) == 'new' ? 'selected' : '' }}>جديدة</option>
                                    <option value="read" {{ old('status', $contact->status) == 'read' ? 'selected' : '' }}>مقروءة</option>
                                    <option value="replied" {{ old('status', $contact->status) == 'replied' ? 'selected' : '' }}>تم الرد عليها</option>
                                    <option value="closed" {{ old('status', $contact->status) == 'closed' ? 'selected' : '' }}>مغلقة</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="contact_type" class="form-label">نوع الجهة <span class="text-danger">*</span></label>
                                <select class="form-select @error('contact_type') is-invalid @enderror" 
                                        id="contact_type" name="contact_type" required>
                                    <option value="inquiry" {{ old('contact_type', $contact->contact_type) == 'inquiry' ? 'selected' : '' }}>استفسار</option>
                                    <option value="custom" {{ old('contact_type', $contact->contact_type) == 'custom' ? 'selected' : '' }}>مخصص</option>
                                </select>
                                @error('contact_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="assigned_to" class="form-label">التعيين <span class="text-danger">*</span></label>
                                <select class="form-select @error('assigned_to') is-invalid @enderror" 
                                        id="assigned_to" name="assigned_to" required>
                                    <option value="marketing" {{ old('assigned_to', $contact->assigned_to) == 'marketing' ? 'selected' : '' }}>فريق التسويق</option>
                                    <option value="sales" {{ old('assigned_to', $contact->assigned_to) == 'sales' ? 'selected' : '' }}>فريق المبيعات</option>
                                    <option value="both" {{ old('assigned_to', $contact->assigned_to) == 'both' ? 'selected' : '' }}>كلا الفريقين</option>
                                </select>
                                @error('assigned_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="priority" class="form-label">الأولوية <span class="text-danger">*</span></label>
                                <select class="form-select @error('priority') is-invalid @enderror" 
                                        id="priority" name="priority" required>
                                    <option value="low" {{ old('priority', $contact->priority) == 'low' ? 'selected' : '' }}>منخفض</option>
                                    <option value="medium" {{ old('priority', $contact->priority) == 'medium' ? 'selected' : '' }}>متوسط</option>
                                    <option value="high" {{ old('priority', $contact->priority) == 'high' ? 'selected' : '' }}>عالي</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="source" class="form-label">المصدر <span class="text-danger">*</span></label>
                                <select class="form-select @error('source') is-invalid @enderror" 
                                        id="source" name="source" required>
                                    <option value="website" {{ old('source', $contact->source) == 'website' ? 'selected' : '' }}>الموقع الإلكتروني</option>
                                    <option value="phone" {{ old('source', $contact->source) == 'phone' ? 'selected' : '' }}>الهاتف</option>
                                    <option value="email" {{ old('source', $contact->source) == 'email' ? 'selected' : '' }}>البريد الإلكتروني</option>
                                    <option value="referral" {{ old('source', $contact->source) == 'referral' ? 'selected' : '' }}>إحالة</option>
                                </select>
                                @error('source')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- إعدادات إضافية -->
                        <div class="col-md-6">
                            <h6 class="text-primary mb-3">
                                <i class="fas fa-tags me-2"></i>
                                إعدادات إضافية
                            </h6>

                            <div class="mb-3">
                                <label for="tags" class="form-label">العلامات</label>
                                <input type="text" class="form-control @error('tags') is-invalid @enderror" 
                                       id="tags" name="tags" value="{{ old('tags', is_array($contact->tags) ? implode(', ', $contact->tags) : $contact->tags) }}"
                                       placeholder="أدخل العلامات مفصولة بفاصلة">
                                <div class="form-text">مثال: عميل محتمل, مهم, متابعة</div>
                                @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="follow_up_date" class="form-label">موعد المتابعة</label>
                                <input type="datetime-local" class="form-control @error('follow_up_date') is-invalid @enderror" 
                                       id="follow_up_date" name="follow_up_date" 
                                       value="{{ old('follow_up_date', $contact->follow_up_date ? $contact->follow_up_date->format('Y-m-d\TH:i') : '') }}">
                                @error('follow_up_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="admin_notes" class="form-label">ملاحظات الأدمن</label>
                                <textarea class="form-control @error('admin_notes') is-invalid @enderror" 
                                          id="admin_notes" name="admin_notes" rows="3">{{ old('admin_notes', $contact->admin_notes) }}</textarea>
                                @error('admin_notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-secondary">
                                    <i class="fas fa-eye me-1"></i>
                                    عرض التفاصيل
                                </a>
                                <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i>
                                    إلغاء
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>
                                    حفظ التغييرات
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
.dashboard-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    border: none;
}

.card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px 12px 0 0;
    border: none;
    padding: 1.5rem;
}

.card-title {
    margin: 0;
    font-weight: 600;
}

.form-label {
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
}

.text-primary {
    color: #667eea !important;
    font-weight: 600;
}

.form-control, .form-select {
    border-radius: 8px;
    border: 1px solid #d1d5db;
    padding: 0.75rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.btn {
    border-radius: 8px;
    padding: 0.75rem 1.5rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
}

.btn-secondary {
    background: #6c757d;
    border: none;
}

.btn-secondary:hover {
    background: #5a6268;
    transform: translateY(-2px);
}

.btn-outline-secondary {
    border: 1px solid #6c757d;
    color: #6c757d;
}

.btn-outline-secondary:hover {
    background: #6c757d;
    color: white;
    transform: translateY(-2px);
}

.text-danger {
    color: #dc3545 !important;
}

.form-text {
    font-size: 0.875rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

@media (max-width: 768px) {
    .card-header {
        padding: 1rem;
    }
    
    .card-body {
        padding: 1rem;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }
}
</style>

<script>
// Handle tags input
document.getElementById('tags').addEventListener('input', function(e) {
    // Convert comma-separated values to array for validation
    const tags = e.target.value.split(',').map(tag => tag.trim()).filter(tag => tag);
    // You can add more validation here if needed
});
</script>
@endsection
