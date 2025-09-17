@extends('layouts.dashboard')

@section('title', 'ملاحظات العميل')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'ملاحظات العميل')
@section('page-subtitle', 'جميع ملاحظات ' . $customer->name)
@section('profile-route', '#')
@section('settings-route', '#')

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('page-actions')
    <a href="{{ route('admin.customer-notes.create') }}?customer_id={{ $customer->id }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        إضافة ملاحظة جديدة
    </a>
@endsection

@section('content')
    <!-- معلومات العميل -->
    <div class="dashboard-card mb-4">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">
                <i class="fas fa-user me-2 text-primary"></i>
                معلومات العميل
            </h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <div class="customer-avatar me-4">
                            <i class="fas fa-user-circle fa-4x text-primary"></i>
                        </div>
                        <div>
                            <h4 class="mb-1">{{ $customer->name }}</h4>
                            <p class="text-muted mb-2">{{ $customer->email }}</p>
                            <div class="row g-3">
                                @if($customer->phone)
                                <div class="col-auto">
                                    <small class="text-muted">
                                        <i class="fas fa-phone me-1"></i>
                                        {{ $customer->phone }}
                                    </small>
                                </div>
                                @endif
                                @if($customer->city)
                                <div class="col-auto">
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt me-1"></i>
                                        {{ $customer->city }}
                                    </small>
                                </div>
                                @endif
                                <div class="col-auto">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        عضو منذ {{ $customer->created_at->format('Y-m-d') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="text-end">
                        <div class="stats-summary">
                            <div class="stat-item">
                                <span class="stat-number">{{ $notes->total() }}</span>
                                <span class="stat-label">إجمالي الملاحظات</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- قائمة الملاحظات -->
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-sticky-note me-2 text-primary"></i>
                    ملاحظات {{ $customer->name }}
                </h5>
                <a href="{{ route('admin.customer-notes.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="fas fa-arrow-right me-1"></i>
                    العودة للقائمة
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($notes->count() > 0)
                <div class="notes-list">
                    @foreach($notes as $note)
                    <div class="note-item border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div class="d-flex align-items-center">
                                <h6 class="mb-0 me-3">{{ $note->title }}</h6>
                                <span class="badge bg-{{ $note->note_type_color }} me-2">
                                    {{ $note->note_type_label }}
                                </span>
                                <span class="badge bg-{{ $note->priority_color }}">
                                    {{ $note->priority_label }}
                                </span>
                            </div>
                            <div class="note-actions">
                                <a href="{{ route('admin.customer-notes.show', $note) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.customer-notes.edit', $note) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                        </div>
                        
                        <div class="note-content mb-3">
                            <p class="mb-0 text-muted">
                                {{ Str::limit($note->content, 200) }}
                            </p>
                        </div>
                        
                        <div class="note-meta d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <small class="text-muted me-3">
                                    <i class="fas fa-user me-1"></i>
                                    {{ $note->addedBy->name }}
                                </small>
                                <small class="text-muted me-3">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $note->created_at->format('Y-m-d H:i') }}
                                </small>
                                @if($note->follow_up_date)
                                <small class="text-warning">
                                    <i class="fas fa-clock me-1"></i>
                                    متابعة: {{ $note->follow_up_date->format('Y-m-d') }}
                                </small>
                                @endif
                            </div>
                            
                            @if($note->tags && count($note->tags) > 0)
                            <div class="note-tags">
                                @foreach(array_slice($note->tags, 0, 3) as $tag)
                                    <span class="badge bg-light text-dark me-1">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                                @if(count($note->tags) > 3)
                                    <span class="badge bg-light text-dark">
                                        +{{ count($note->tags) - 3 }}
                                    </span>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $notes->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-sticky-note fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">لا توجد ملاحظات لهذا العميل</h4>
                    <p class="text-muted mb-4">ابدأ بإضافة ملاحظة جديدة للعميل</p>
                    <a href="{{ route('admin.customer-notes.create') }}?customer_id={{ $customer->id }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        إضافة ملاحظة جديدة
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
<style>
.customer-avatar {
    text-align: center;
}

.stats-summary {
    background: #f8f9fa;
    padding: 1rem;
    border-radius: 0.5rem;
}

.stat-item {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: bold;
    color: #007bff;
}

.stat-label {
    font-size: 0.875rem;
    color: #6c757d;
}

.note-item {
    transition: all 0.3s ease;
}

.note-item:hover {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    transform: translateY(-1px);
}

.note-content {
    line-height: 1.6;
}

.note-meta {
    font-size: 0.875rem;
}

.note-actions .btn {
    margin-left: 0.25rem;
}

.note-tags .badge {
    font-size: 0.75rem;
}
</style>
@endpush