@extends('layouts.marketing-dashboard')

@section('title', 'تفاصيل جهة الاتصال - فريق التسويق')
@section('dashboard-title', 'تفاصيل جهة الاتصال')
@section('page-title', 'تفاصيل جهة الاتصال')
@section('page-subtitle', 'عرض وتحديث تفاصيل جهة الاتصال')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <!-- Contact Details -->
        <div class="dashboard-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2 text-primary"></i>
                    تفاصيل جهة الاتصال
                </h5>
                <div class="d-flex gap-2">
                    @switch($contact->status)
                        @case('new')
                            <span class="badge bg-warning">جديدة</span>
                            @break
                        @case('read')
                            <span class="badge bg-info">مقروءة</span>
                            @break
                        @case('replied')
                            <span class="badge bg-success">تم الرد عليها</span>
                            @break
                        @case('closed')
                            <span class="badge bg-secondary">مغلقة</span>
                            @break
                    @endswitch
                    <span class="badge bg-info">مشترك</span>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">الاسم:</label>
                            <p class="contact-value">{{ $contact->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">البريد الإلكتروني:</label>
                            <p class="contact-value">
                                <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                    <i class="fas fa-envelope me-1"></i>
                                    {{ $contact->email }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">الهاتف:</label>
                            <p class="contact-value">
                                @if($contact->phone)
                                    <a href="tel:{{ $contact->phone }}" class="text-decoration-none">
                                        <i class="fas fa-phone me-1"></i>
                                        {{ $contact->phone }}
                                    </a>
                                @else
                                    <span class="text-muted">غير محدد</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">الشركة:</label>
                            <p class="contact-value">{{ $contact->company ?? 'غير محدد' }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">الموضوع:</label>
                            <p class="contact-value">{{ $contact->subject }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">الرسالة:</label>
                            <div class="contact-message">
                                {{ $contact->message }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">تاريخ الإرسال:</label>
                            <p class="contact-value">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $contact->created_at->format('Y-m-d H:i') }}
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">آخر تحديث:</label>
                            <p class="contact-value">
                                <i class="fas fa-clock me-1"></i>
                                {{ $contact->updated_at->format('Y-m-d H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
                
                @if($contact->read_at)
                <div class="row">
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">تاريخ القراءة:</label>
                            <p class="contact-value">
                                <i class="fas fa-eye me-1"></i>
                                {{ $contact->read_at->format('Y-m-d H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif
                
                @if($contact->replied_at)
                <div class="row">
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">تاريخ الرد:</label>
                            <p class="contact-value">
                                <i class="fas fa-reply me-1"></i>
                                {{ $contact->replied_at->format('Y-m-d H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <!-- Update Status -->
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-edit me-2 text-warning"></i>
                    تحديث الحالة
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('marketing.contacts.update', $contact) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">الحالة</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="new" {{ $contact->status === 'new' ? 'selected' : '' }}>جديدة</option>
                            <option value="read" {{ $contact->status === 'read' ? 'selected' : '' }}>مقروءة</option>
                            <option value="replied" {{ $contact->status === 'replied' ? 'selected' : '' }}>تم الرد عليها</option>
                            <option value="closed" {{ $contact->status === 'closed' ? 'selected' : '' }}>مغلقة</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">ملاحظات الفريق</label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="4" 
                                  placeholder="أضف ملاحظات حول هذه جهة الاتصال...">{{ $contact->admin_notes }}</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-1"></i>
                        حفظ التحديثات
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2 text-info"></i>
                    إجراءات سريعة
                </h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @if($contact->status === 'new')
                        <form action="{{ route('marketing.contacts.mark-read', $contact) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-info w-100">
                                <i class="fas fa-check me-1"></i>
                                وضع علامة مقروء
                            </button>
                        </form>
                    @endif
                    
                    @if($contact->status !== 'replied')
                        <form action="{{ route('marketing.contacts.mark-replied', $contact) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-reply me-1"></i>
                                وضع علامة تم الرد
                            </button>
                        </form>
                    @endif
                    
                    @if($contact->status !== 'closed')
                        <form action="{{ route('marketing.contacts.mark-closed', $contact) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-secondary w-100">
                                <i class="fas fa-times me-1"></i>
                                إغلاق جهة الاتصال
                            </button>
                        </form>
                    @endif
                    
                    <a href="mailto:{{ $contact->email }}" class="btn btn-outline-primary w-100">
                        <i class="fas fa-envelope me-1"></i>
                        إرسال بريد إلكتروني
                    </a>
                    
                    @if($contact->phone)
                        <a href="tel:{{ $contact->phone }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-phone me-1"></i>
                            الاتصال
                        </a>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Back Button -->
        <div class="dashboard-card">
            <div class="card-body text-center">
                <a href="{{ route('marketing.contacts') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-right me-1"></i>
                    العودة إلى القائمة
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
.contact-info-item {
    margin-bottom: 1.5rem;
}

.contact-value {
    margin: 0;
    padding: 0.5rem 0;
    color: #495057;
    font-size: 1rem;
}

.contact-message {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 1rem;
    white-space: pre-wrap;
    line-height: 1.6;
    color: #495057;
}

.form-label {
    color: #374151;
    margin-bottom: 0.5rem;
}

.dashboard-card {
    margin-bottom: 1.5rem;
}

.btn-group-vertical .btn {
    margin-bottom: 0.5rem;
}

@media (max-width: 768px) {
    .contact-info-item {
        margin-bottom: 1rem;
    }
    
    .contact-value {
        font-size: 0.9rem;
    }
    
    .contact-message {
        padding: 0.75rem;
        font-size: 0.9rem;
    }
}
</style>
@endsection
