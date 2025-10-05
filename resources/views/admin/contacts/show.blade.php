@extends('layouts.dashboard')

@section('title', 'عرض الرسالة')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'عرض الرسالة')
@section('page-subtitle', 'تفاصيل رسالة التواصل')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <!-- تفاصيل الرسالة -->
        <div class="dashboard-card">
            <div class="card-header bg-white border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-envelope me-2 text-primary"></i>
                        تفاصيل الرسالة
                    </h5>
                    <div>
                        @switch($contact->status)
                            @case('new')
                                <span class="badge bg-warning fs-6">جديدة</span>
                                @break
                            @case('read')
                                <span class="badge bg-info fs-6">مقروءة</span>
                                @break
                            @case('replied')
                                <span class="badge bg-success fs-6">تم الرد عليها</span>
                                @break
                            @case('closed')
                                <span class="badge bg-secondary fs-6">مغلقة</span>
                                @break
                        @endswitch
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- معلومات المرسل -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">الاسم:</label>
                            <p class="mb-0">{{ $contact->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">البريد الإلكتروني:</label>
                            <p class="mb-0">
                                <a href="mailto:{{ $contact->email }}" class="text-primary">
                                    {{ $contact->email }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    @if($contact->phone)
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">رقم الهاتف:</label>
                            <p class="mb-0">
                                <a href="tel:{{ $contact->phone }}" class="text-primary">
                                    {{ $contact->phone }}
                                </a>
                            </p>
                        </div>
                    </div>
                    @endif
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">الموضوع:</label>
                            <p class="mb-0">
                                <span class="badge bg-light text-dark fs-6">{{ $contact->subject }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">تاريخ الإرسال:</label>
                            <p class="mb-0">{{ $contact->created_at->format('Y-m-d H:i') }}</p>
                        </div>
                    </div>
                    @if($contact->read_at)
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">تاريخ القراءة:</label>
                            <p class="mb-0">{{ $contact->read_at->format('Y-m-d H:i') }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- نص الرسالة -->
                <div class="message-content">
                    <label class="form-label fw-bold">نص الرسالة:</label>
                    <div class="bg-light p-3 rounded">
                        <p class="mb-0" style="white-space: pre-wrap;">{{ $contact->message }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- إدارة الرسالة -->
        <div class="dashboard-card">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">
                    <i class="fas fa-cogs me-2 text-primary"></i>
                    إدارة الرسالة
                </h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.contacts.update', $contact) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">تغيير الحالة</label>
                        <select class="form-select" name="status">
                            <option value="new" {{ $contact->status === 'new' ? 'selected' : '' }}>جديدة</option>
                            <option value="read" {{ $contact->status === 'read' ? 'selected' : '' }}>مقروءة</option>
                            <option value="replied" {{ $contact->status === 'replied' ? 'selected' : '' }}>تم الرد عليها</option>
                            <option value="closed" {{ $contact->status === 'closed' ? 'selected' : '' }}>مغلقة</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">ملاحظات الإدارة</label>
                        <textarea class="form-control" name="admin_notes" rows="4" 
                                  placeholder="أضف ملاحظات أو تعليقات...">{{ $contact->admin_notes }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>
                        حفظ التغييرات
                    </button>
                </form>

                <hr>

                <!-- إجراءات سريعة -->
                <div class="d-grid gap-2">
                    @if($contact->status === 'new')
                        <form method="POST" action="{{ route('admin.contacts.mark-read', $contact) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-info w-100">
                                <i class="fas fa-check me-2"></i>
                                تمييز كمقروءة
                            </button>
                        </form>
                    @endif

                    @if($contact->status !== 'replied')
                        <form method="POST" action="{{ route('admin.contacts.mark-replied', $contact) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-reply me-2"></i>
                                تمييز كرد عليها
                            </button>
                        </form>
                    @endif

                    @if($contact->status !== 'closed')
                        <form method="POST" action="{{ route('admin.contacts.mark-closed', $contact) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-secondary w-100">
                                <i class="fas fa-lock me-2"></i>
                                إغلاق الرسالة
                            </button>
                        </form>
                    @endif

                    <a href="mailto:{{ $contact->email }}?subject=رد على: {{ $contact->subject }}" 
                       class="btn btn-outline-primary w-100">
                        <i class="fas fa-envelope me-2"></i>
                        الرد بالبريد الإلكتروني
                    </a>

                    <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" 
                          onsubmit="return confirm('هل أنت متأكد من حذف هذه الرسالة؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-2"></i>
                            حذف الرسالة
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- معلومات إضافية -->
        <div class="dashboard-card mt-4">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    معلومات إضافية
                </h5>
            </div>
            <div class="card-body">
                <div class="info-item mb-3">
                    <label class="form-label fw-bold">معرف الرسالة:</label>
                    <p class="mb-0 text-muted">#{{ $contact->id }}</p>
                </div>
                
                @if($contact->replied_at)
                <div class="info-item mb-3">
                    <label class="form-label fw-bold">تاريخ الرد:</label>
                    <p class="mb-0 text-muted">{{ $contact->replied_at->format('Y-m-d H:i') }}</p>
                </div>
                @endif

                <div class="info-item">
                    <label class="form-label fw-bold">آخر تحديث:</label>
                    <p class="mb-0 text-muted">{{ $contact->updated_at->format('Y-m-d H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.contacts.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-right me-2"></i>
                العودة للقائمة
            </a>
        </div>
    </div>
</div>
@endsection
