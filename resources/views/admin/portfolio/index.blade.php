@extends('layouts.dashboard')

@section('title', 'إدارة معرض الأعمال')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>إدارة معرض الأعمال</h1>
        <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة عمل جديد
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($portfolioItems->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>الصورة</th>
                                <th>العنوان</th>
                                <th>الفئة</th>
                                <th>العميل</th>
                                <th>تاريخ الإنجاز</th>
                                <th>مميز</th>
                                <th>الترتيب</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($portfolioItems as $item)
                            <tr>
                                <td>
                                    @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" 
                                             class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                                    @else
                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                             style="width: 60px; height: 60px;">
                                            <i class="fas fa-image text-muted"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>{{ $item->title }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $item->category }}</span>
                                </td>
                                <td>{{ $item->client_name ?? 'غير محدد' }}</td>
                                <td>{{ $item->completion_date ? $item->completion_date->format('Y-m-d') : 'غير محدد' }}</td>
                                <td>
                                    <span class="badge {{ $item->is_featured ? 'bg-warning' : 'bg-secondary' }}">
                                        {{ $item->is_featured ? 'مميز' : 'عادي' }}
                                    </span>
                                </td>
                                <td>{{ $item->sort_order }}</td>
                                <td>
                                    <span class="badge {{ $item->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $item->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.portfolio.edit', $item) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" 
                                          action="{{ route('admin.portfolio.destroy', $item) }}" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('هل أنت متأكد؟')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('portfolio.show', $item) }}" 
                                       class="btn btn-sm btn-info" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $portfolioItems->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <h4>لا توجد أعمال في المعرض</h4>
                    <p>ابدأ بإضافة أول عمل لمعرض الأعمال</p>
                    <a href="{{ route('admin.portfolio.create') }}" class="btn btn-primary">
                        إضافة عمل جديد
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection