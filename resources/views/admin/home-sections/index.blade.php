@extends('layouts.dashboard')

@section('title', 'إدارة أقسام الصفحة الرئيسية')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>إدارة أقسام الصفحة الرئيسية</h1>
        <a href="{{ route('admin.home-sections.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة قسم جديد
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($sections->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>الاسم</th>
                                <th>العنوان</th>
                                <th>نوع القسم</th>
                                <th>عدد العناصر</th>
                                <th>الترتيب</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sections as $section)
                            <tr>
                                <td>{{ $section->name }}</td>
                                <td>{{ $section->title }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $section->section_type }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $section->allContents->count() }}</span>
                                    <a href="{{ route('admin.section-contents.index', $section) }}" class="btn btn-sm btn-outline-primary ms-2">
                                        إدارة المحتوى
                                    </a>
                                </td>
                                <td>{{ $section->order }}</td>
                                <td>
                                    <span class="badge {{ $section->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $section->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.home-sections.edit', $section) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" 
                                          action="{{ route('admin.home-sections.destroy', $section) }}" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('هل أنت متأكد؟')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.home-sections.toggle-active', $section) }}" 
                                       class="btn btn-sm {{ $section->is_active ? 'btn-secondary' : 'btn-success' }}">
                                        {{ $section->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <h4>لا توجد أقسام</h4>
                    <p>ابدأ بإضافة أول قسم للصفحة الرئيسية</p>
                    <a href="{{ route('admin.home-sections.create') }}" class="btn btn-primary">
                        إضافة قسم جديد
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection