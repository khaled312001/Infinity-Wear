@extends('layouts.sales-dashboard')

@section('title', 'جهات الاتصال - فريق المبيعات')
@section('dashboard-title', 'جهات الاتصال')
@section('page-title', 'قائمة جهات الاتصال')
@section('page-subtitle', 'إدارة وتتبع جميع جهات الاتصال')

@section('content')
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

<!-- إحصائيات سريعة -->
<div class="row g-4 mb-4">
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon primary">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ $stats['total'] }}</h3>
                    <p class="mb-0 text-muted">إجمالي الجهات</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ $stats['new'] }}</h3>
                    <p class="mb-0 text-muted">جديدة</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon info">
                    <i class="fas fa-eye"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ $stats['read'] }}</h3>
                    <p class="mb-0 text-muted">مقروءة</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon success">
                    <i class="fas fa-reply"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ $stats['replied'] }}</h3>
                    <p class="mb-0 text-muted">تم الرد عليها</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon danger">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ $stats['high_priority'] }}</h3>
                    <p class="mb-0 text-muted">أولوية عالية</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6">
        <div class="stats-card">
            <div class="d-flex align-items-center">
                <div class="stats-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="ms-3">
                    <h3 class="mb-0">{{ $stats['follow_up_today'] }}</h3>
                    <p class="mb-0 text-muted">متابعة اليوم</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- فلترة جهات الاتصال -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('sales.contacts') }}" class="row g-3">
            <div class="col-md-3">
                <label for="status" class="form-label">الحالة</label>
                <select name="status" id="status" class="form-select">
                    <option value="">جميع الحالات</option>
                    <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>جديدة</option>
                    <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>مقروءة</option>
                    <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>تم الرد عليها</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>مغلقة</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="contact_type" class="form-label">نوع الجهة</label>
                <select name="contact_type" id="contact_type" class="form-select">
                    <option value="">جميع الأنواع</option>
                    <option value="inquiry" {{ request('contact_type') == 'inquiry' ? 'selected' : '' }}>استفسار</option>
                    <option value="custom" {{ request('contact_type') == 'custom' ? 'selected' : '' }}>مخصص</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="priority" class="form-label">الأولوية</label>
                <select name="priority" id="priority" class="form-select">
                    <option value="">جميع الأولويات</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>عالية</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>متوسطة</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>منخفضة</option>
                </select>
            </div>
            <div class="col-md-3">
                <label for="source" class="form-label">المصدر</label>
                <select name="source" id="source" class="form-select">
                    <option value="">جميع المصادر</option>
                    <option value="website" {{ request('source') == 'website' ? 'selected' : '' }}>الموقع</option>
                    <option value="phone" {{ request('source') == 'phone' ? 'selected' : '' }}>هاتف</option>
                    <option value="email" {{ request('source') == 'email' ? 'selected' : '' }}>بريد إلكتروني</option>
                    <option value="referral" {{ request('source') == 'referral' ? 'selected' : '' }}>إحالة</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="search" class="form-label">البحث</label>
                <input type="text" name="search" id="search" class="form-control" 
                       placeholder="البحث بالاسم، البريد الإلكتروني، أو الموضوع..." 
                       value="{{ request('search') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">&nbsp;</label>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>فلترة
                    </button>
                    <a href="{{ route('sales.contacts') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>مسح
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- قائمة جهات الاتصال -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-address-book me-2"></i>
            جهات الاتصال
        </h5>
    </div>
    <div class="card-body">
        @if($contacts->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>الجهة</th>
                            <th>المعلومات</th>
                            <th>النوع</th>
                            <th>الأولوية</th>
                            <th>الحالة</th>
                            <th>التاريخ</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contacts as $contact)
                            <tr data-status="{{ $contact->status }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-user-circle text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $contact->name }}</h6>
                                            @if($contact->company)
                                                <small class="text-muted">{{ $contact->company }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                            {{ $contact->email }}
                                        </a>
                                        @if($contact->phone)
                                            <br><small class="text-muted">
                                                <i class="fas fa-phone me-1"></i>{{ $contact->phone }}
                                            </small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($contact->contact_type === 'inquiry')
                                        <span class="badge bg-info">استفسار</span>
                                    @else
                                        <span class="badge bg-secondary">مخصص</span>
                                    @endif
                                    @if($contact->source)
                                        <br><small class="text-muted">{{ $contact->source_text }}</small>
                                    @endif
                                </td>
                                <td>
                                    {!! $contact->priority_badge !!}
                                </td>
                                <td>
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
                                </td>
                                <td>
                                    <div>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($contact->created_at)->format('Y-m-d') }}
                                        </small>
                                        <br>
                                        <small class="text-muted">
                                            {{ \Carbon\Carbon::parse($contact->created_at)->format('H:i') }}
                                        </small>
                                        @if($contact->follow_up_date)
                                            <br><small class="text-warning">
                                                <i class="fas fa-clock me-1"></i>متابعة: {{ $contact->follow_up_date->format('m/d') }}
                                            </small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <a href="{{ route('sales.contacts.show', $contact->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $contacts->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-envelope fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">لا توجد جهات اتصال حالياً</h5>
            </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
function filterContacts(status) {
    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        if (status === 'all' || row.dataset.status === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
    
    // Update button states
    document.querySelectorAll('.btn-outline-primary, .btn-outline-warning, .btn-outline-info, .btn-outline-success, .btn-outline-secondary').forEach(btn => {
        btn.classList.remove('active');
    });
    
    event.target.classList.add('active');
}
</script>
@endsection
