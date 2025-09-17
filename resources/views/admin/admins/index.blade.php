@extends('layouts.dashboard')

@section('title', 'إدارة المشرفين')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'إدارة المشرفين')
@section('page-subtitle', 'إدارة وعرض جميع المشرفين في النظام')

@section('page-actions')
    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        إضافة مشرف جديد
    </a>
@endsection

@section('content')

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($admins->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>البريد الإلكتروني</th>
                                <th>الدور</th>
                                <th>تاريخ الإنشاء</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $admin)
                            <tr>
                                <td>{{ $admin->name }}</td>
                                <td>{{ $admin->email }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $admin->role_label ?? 'مشرف' }}</span>
                                </td>
                                <td>{{ $admin->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.admins.show', $admin) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.admins.edit', $admin) }}" 
                                           class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($admin->id !== auth('admin')->id())
                                        <form method="POST" 
                                              action="{{ route('admin.admins.destroy', $admin) }}" 
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('هل أنت متأكد من حذف هذا المشرف؟')">
                                                <i class="fas fa-trash"></i>
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
                
                <div class="d-flex justify-content-center">
                    {{ $admins->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <h4>لا يوجد مشرفين</h4>
                    <p>ابدأ بإضافة أول مشرف للنظام</p>
                    <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
                        إضافة مشرف جديد
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection