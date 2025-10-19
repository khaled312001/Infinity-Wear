@extends('layouts.dashboard')

@section('title', 'عرض جهة الاتصال')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'عرض جهة الاتصال')
@section('page-subtitle', 'تفاصيل جهة الاتصال')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <!-- تفاصيل الجهة -->
        <div class="dashboard-card">
            <div class="card-header bg-white border-bottom">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <i class="fas fa-address-book me-2 text-primary"></i>
                        تفاصيل الجهة
                    </h5>
                    <div class="d-flex gap-2">
                        <span class="badge bg-{{ $contact->priority_badge }} fs-6">
                            {{ $contact->priority_text }}
                        </span>
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
                <!-- معلومات أساسية -->
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
                    @if($contact->company)
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">الشركة:</label>
                            <p class="mb-0">{{ $contact->company }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- معلومات الجهة -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">نوع الجهة:</label>
                            <p class="mb-0">
                                <span class="badge bg-{{ $contact->contact_type === 'inquiry' ? 'info' : 'warning' }}">
                                    {{ $contact->contact_type === 'inquiry' ? 'استفسار' : 'مخصص' }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">المصدر:</label>
                            <p class="mb-0">{{ $contact->source_text }}</p>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">التعيين:</label>
                            <p class="mb-0">
                                <span class="badge bg-{{ $contact->assigned_to === 'marketing' ? 'primary' : ($contact->assigned_to === 'sales' ? 'success' : 'info') }}">
                                    {{ $contact->assigned_to_text }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">الموضوع:</label>
                            <p class="mb-0">
                                <span class="badge bg-light text-dark fs-6">{{ $contact->subject }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                @if($contact->tags && count($contact->tags) > 0)
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">العلامات:</label>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($contact->tags as $tag)
                                    <span class="badge bg-secondary">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                @if($contact->follow_up_date)
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="contact-info-item">
                            <label class="form-label fw-bold">موعد المتابعة:</label>
                            <p class="mb-0 text-warning">
                                <i class="fas fa-clock me-1"></i>
                                {{ $contact->follow_up_date->format('Y-m-d H:i') }}
                            </p>
                        </div>
                    </div>
                </div>
                @endif

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
        <!-- إدارة الجهة -->
        <div class="dashboard-card">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">
                    <i class="fas fa-cogs me-2 text-primary"></i>
                    إدارة الجهة
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
                        <label class="form-label">نوع الجهة</label>
                        <select class="form-select" name="contact_type">
                            <option value="inquiry" {{ $contact->contact_type === 'inquiry' ? 'selected' : '' }}>استفسار</option>
                            <option value="custom" {{ $contact->contact_type === 'custom' ? 'selected' : '' }}>مخصص</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">التعيين</label>
                        <select class="form-select" name="assigned_to">
                            <option value="marketing" {{ $contact->assigned_to === 'marketing' ? 'selected' : '' }}>فريق التسويق</option>
                            <option value="sales" {{ $contact->assigned_to === 'sales' ? 'selected' : '' }}>فريق المبيعات</option>
                            <option value="both" {{ $contact->assigned_to === 'both' ? 'selected' : '' }}>كلا الفريقين</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">الأولوية</label>
                        <select class="form-select" name="priority">
                            <option value="low" {{ $contact->priority === 'low' ? 'selected' : '' }}>منخفض</option>
                            <option value="medium" {{ $contact->priority === 'medium' ? 'selected' : '' }}>متوسط</option>
                            <option value="high" {{ $contact->priority === 'high' ? 'selected' : '' }}>عالي</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">موعد المتابعة</label>
                        <input type="datetime-local" class="form-control" name="follow_up_date" 
                               value="{{ $contact->follow_up_date ? $contact->follow_up_date->format('Y-m-d\TH:i') : '' }}">
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
                                إغلاق الجهة
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('admin.contacts.edit', $contact) }}" 
                       class="btn btn-outline-warning w-100">
                        <i class="fas fa-edit me-2"></i>
                        تعديل الجهة
                    </a>

                    <a href="mailto:{{ $contact->email }}?subject=رد على: {{ $contact->subject }}" 
                       class="btn btn-outline-primary w-100">
                        <i class="fas fa-envelope me-2"></i>
                        الرد بالبريد الإلكتروني
                    </a>

                    @if($contact->phone)
                    <a href="tel:{{ $contact->phone }}" 
                       class="btn btn-outline-success w-100">
                        <i class="fas fa-phone me-2"></i>
                        الاتصال بالهاتف
                    </a>
                    @endif

                    <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" 
                          onsubmit="return confirm('هل أنت متأكد من حذف هذه الجهة؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <i class="fas fa-trash me-2"></i>
                            حذف الجهة
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
                    <label class="form-label fw-bold">معرف الجهة:</label>
                    <p class="mb-0 text-muted">#{{ $contact->id }}</p>
                </div>

                <div class="info-item mb-3">
                    <label class="form-label fw-bold">عدد مرات التواصل:</label>
                    <p class="mb-0 text-muted">{{ $contact->contact_count ?? 0 }} مرة</p>
                </div>

                @if($contact->last_contact_date)
                <div class="info-item mb-3">
                    <label class="form-label fw-bold">آخر تواصل:</label>
                    <p class="mb-0 text-muted">{{ $contact->last_contact_date->format('Y-m-d H:i') }}</p>
                </div>
                @endif
                
                @if($contact->replied_at)
                <div class="info-item mb-3">
                    <label class="form-label fw-bold">تاريخ الرد:</label>
                    <p class="mb-0 text-muted">{{ $contact->replied_at->format('Y-m-d H:i') }}</p>
                </div>
                @endif

                @if($contact->creator)
                <div class="info-item mb-3">
                    <label class="form-label fw-bold">أنشأ بواسطة:</label>
                    <p class="mb-0 text-muted">{{ $contact->creator->name }}</p>
                </div>
                @endif

                @if($contact->updater)
                <div class="info-item mb-3">
                    <label class="form-label fw-bold">آخر تحديث بواسطة:</label>
                    <p class="mb-0 text-muted">{{ $contact->updater->name }}</p>
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
