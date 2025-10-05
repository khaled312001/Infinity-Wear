@extends('layouts.marketing-dashboard')

@section('title', 'جهات الاتصال المشتركة - فريق التسويق')
@section('dashboard-title', 'جهات الاتصال المشتركة')
@section('page-title', 'جهات الاتصال المشتركة')
@section('page-subtitle', 'إدارة جهات الاتصال المشتركة مع الإدارة والمبيعات')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="stats-card enhanced">
            <div class="stats-content text-center">
                <h3 class="stats-number text-primary">{{ $stats['total'] }}</h3>
                <p class="stats-label">إجمالي الرسائل</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="stats-card enhanced">
            <div class="stats-content text-center">
                <h3 class="stats-number text-warning">{{ $stats['new'] }}</h3>
                <p class="stats-label">رسائل جديدة</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="stats-card enhanced">
            <div class="stats-content text-center">
                <h3 class="stats-number text-info">{{ $stats['read'] }}</h3>
                <p class="stats-label">مقروءة</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="stats-card enhanced">
            <div class="stats-content text-center">
                <h3 class="stats-number text-success">{{ $stats['replied'] }}</h3>
                <p class="stats-label">تم الرد عليها</p>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
        <div class="stats-card enhanced">
            <div class="stats-content text-center">
                <h3 class="stats-number text-secondary">{{ $stats['closed'] }}</h3>
                <p class="stats-label">مغلقة</p>
            </div>
        </div>
    </div>
</div>

<!-- Filters and Search -->
<div class="row mb-4">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-body">
                <form method="GET" action="{{ route('marketing.contacts') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="search" class="form-label">البحث</label>
                        <input type="text" class="form-control" id="search" name="search" 
                               value="{{ request('search') }}" placeholder="البحث في الاسم، البريد الإلكتروني، أو الموضوع">
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">الحالة</label>
                        <select class="form-select" id="status" name="status">
                            <option value="">جميع الحالات</option>
                            <option value="new" {{ request('status') == 'new' ? 'selected' : '' }}>جديدة</option>
                            <option value="read" {{ request('status') == 'read' ? 'selected' : '' }}>مقروءة</option>
                            <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>تم الرد عليها</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>مغلقة</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search me-1"></i>
                            بحث
                        </button>
                        <a href="{{ route('marketing.contacts') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-1"></i>
                            مسح
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Contacts List -->
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-address-book me-2 text-primary"></i>
                    جهات الاتصال المشتركة
                </h5>
                <div class="d-flex gap-2">
                    <span class="badge bg-info">مشترك مع الإدارة والمبيعات</span>
                </div>
            </div>
            <div class="card-body">
                @if($contacts->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الهاتف</th>
                                    <th>الموضوع</th>
                                    <th>الحالة</th>
                                    <th>التاريخ</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($contacts as $contact)
                                <tr class="contact-row {{ $contact->status === 'new' ? 'table-warning' : '' }}">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="contact-avatar me-3">
                                                <i class="fas fa-user"></i>
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
                                        <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                            {{ $contact->email }}
                                        </a>
                                    </td>
                                    <td>
                                        @if($contact->phone)
                                            <a href="tel:{{ $contact->phone }}" class="text-decoration-none">
                                                {{ $contact->phone }}
                                            </a>
                                        @else
                                            <span class="text-muted">غير محدد</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="contact-subject">{{ Str::limit($contact->subject, 50) }}</span>
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
                                            <small class="text-muted">{{ $contact->created_at->format('Y-m-d') }}</small>
                                            <br>
                                            <small class="text-muted">{{ $contact->created_at->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('marketing.contacts.show', $contact) }}" 
                                               class="btn btn-sm btn-outline-primary" title="عرض التفاصيل">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($contact->status === 'new')
                                                <form action="{{ route('marketing.contacts.mark-read', $contact) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-info" title="وضع علامة مقروء">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @if($contact->status !== 'replied')
                                                <form action="{{ route('marketing.contacts.mark-replied', $contact) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-success" title="وضع علامة تم الرد">
                                                        <i class="fas fa-reply"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            @if($contact->status !== 'closed')
                                                <form action="{{ route('marketing.contacts.mark-closed', $contact) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-outline-secondary" title="إغلاق">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-center mt-4">
                        {{ $contacts->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-address-book fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">لا توجد جهات اتصال</h5>
                        <p class="text-muted">لا توجد جهات اتصال مشتركة حالياً</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles -->
<style>
.contact-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1rem;
}

.contact-row.table-warning {
    background-color: rgba(255, 193, 7, 0.1) !important;
}

.contact-subject {
    font-weight: 500;
    color: #495057;
}

.stats-card.enhanced {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.stats-card.enhanced:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
}

.stats-number {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.stats-label {
    color: #64748b;
    font-weight: 500;
    margin: 0;
}

.table th {
    background-color: #f8fafc;
    border-bottom: 2px solid #e2e8f0;
    font-weight: 600;
    color: #374151;
}

.table td {
    vertical-align: middle;
    border-bottom: 1px solid #e2e8f0;
}

.btn-group .btn {
    margin: 0 1px;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .contact-avatar {
        width: 30px;
        height: 30px;
        font-size: 0.8rem;
    }
    
    .btn-group .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
    }
}
</style>
@endsection
