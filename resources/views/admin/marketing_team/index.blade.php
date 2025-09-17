@extends('layouts.dashboard')

@section('title', 'إدارة فريق التسويق')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'إدارة فريق التسويق')
@section('page-subtitle', 'عرض وإدارة جميع أعضاء فريق التسويق')
@section('profile-route', '#')
@section('settings-route', '#')

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('page-actions')
    <a href="{{ route('admin.marketing.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        إضافة عضو جديد
    </a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-users me-2 text-primary"></i>
                    فريق التسويق
                </h5>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control form-control-sm" placeholder="البحث في فريق التسويق..." id="searchInput">
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($marketingTeam->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>الصورة</th>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>المنصب</th>
                                <th>القسم</th>
                                <th>الهاتف</th>
                                <th>الحالة</th>
                                <th>تاريخ الانضمام</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($marketingTeam as $member)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($member->avatar)
                                            <img src="{{ asset('storage/' . $member->avatar) }}" 
                                                 alt="{{ $member->name }}" 
                                                 class="rounded-circle me-3" 
                                                 style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 40px; height: 40px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <h6 class="mb-0">{{ $member->name }}</h6>
                                    </div>
                                </td>
                                <td>{{ $member->email }}</td>
                                <td>{{ $member->position ?? 'غير محدد' }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $member->department ?? 'غير محدد' }}</span>
                                </td>
                                <td>{{ $member->phone ?? 'غير محدد' }}</td>
                                <td>
                                    @if($member->is_active)
                                        <span class="badge bg-success">نشط</span>
                                    @else
                                        <span class="badge bg-secondary">غير نشط</span>
                                    @endif
                                </td>
                                <td>{{ $member->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.marketing.show', $member->id) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.marketing.edit', $member->id) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.marketing.destroy', $member->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف هذا العضو؟')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $marketingTeam->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-users fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">لا يوجد أعضاء في فريق التسويق حتى الآن</h4>
                    <p class="text-muted mb-4">ابدأ بإضافة عضو جديد لفريق التسويق</p>
                    <a href="{{ route('admin.marketing.create') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-plus me-2"></i>
                        إضافة عضو جديد
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // البحث في فريق التسويق
    document.getElementById('searchInput').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endpush