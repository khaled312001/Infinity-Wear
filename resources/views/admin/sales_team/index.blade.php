@extends('layouts.dashboard')

@section('title', 'فريق المبيعات')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'فريق المبيعات')
@section('page-subtitle', 'إدارة فريق المبيعات ومتابعة الأداء')

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('page-actions')
    <a href="#" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        إضافة عضو جديد
    </a>
@endsection

@section('content')
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">
                <i class="fas fa-users me-2 text-primary"></i>
                أعضاء فريق المبيعات
            </h5>
        </div>
        <div class="card-body">
            @if($salesTeam->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>المنصب</th>
                                <th>القسم</th>
                                <th>الهاتف</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($salesTeam as $member)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-3">
                                            <i class="fas fa-user text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $member->admin->name ?? 'غير محدد' }}</h6>
                                            <small class="text-muted">{{ $member->bio ?? 'لا يوجد وصف' }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $member->position ?? 'غير محدد' }}</td>
                                <td>{{ $member->department ?? 'غير محدد' }}</td>
                                <td>{{ $member->phone ?? 'غير محدد' }}</td>
                                <td>
                                    <span class="badge bg-{{ $member->is_active ? 'success' : 'secondary' }}">
                                        {{ $member->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $salesTeam->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">لا يوجد أعضاء في فريق المبيعات</h4>
                    <p class="text-muted mb-4">ابدأ بإضافة أعضاء جدد لفريق المبيعات</p>
                    <a href="#" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        إضافة عضو جديد
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection