@extends('layouts.dashboard')

@section('title', 'إدارة المشرفين')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>إدارة المشرفين</h1>
        <a href="{{ route('admin.admins.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة مشرف جديد
        </a>
    </div>

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
                                    <span class="badge bg-info">{{ $admin->role ?? 'مشرف' }}</span>
                                </td>
                                <td>{{ $admin->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <a href="{{ route('admin.admins.edit', $admin) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($admin->id !== auth('admin')->id())
                                    <form method="POST" 
                                          action="{{ route('admin.admins.destroy', $admin) }}" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('هل أنت متأكد؟')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    @endif
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