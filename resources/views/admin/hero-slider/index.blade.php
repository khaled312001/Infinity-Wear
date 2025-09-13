@extends('layouts.dashboard')

@section('title', 'إدارة السلايدر الرئيسي')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>إدارة السلايدر الرئيسي</h1>
        <a href="{{ route('admin.hero-slider.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> إضافة سلايد جديد
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            @if($sliders->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>الصورة</th>
                                <th>العنوان</th>
                                <th>العنوان الفرعي</th>
                                <th>الترتيب</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sliders as $slider)
                            <tr>
                                <td>
                                    @if($slider->image)
                                        <img src="{{ asset('storage/' . $slider->image) }}" 
                                             alt="{{ $slider->title }}" 
                                             style="width: 80px; height: 50px; object-fit: cover;">
                                    @endif
                                </td>
                                <td>{{ $slider->title }}</td>
                                <td>{{ $slider->subtitle }}</td>
                                <td>{{ $slider->order }}</td>
                                <td>
                                    <span class="badge {{ $slider->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $slider->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.hero-slider.edit', $slider) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" 
                                          action="{{ route('admin.hero-slider.destroy', $slider) }}" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('هل أنت متأكد؟')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.hero-slider.toggle-active', $slider) }}" 
                                       class="btn btn-sm {{ $slider->is_active ? 'btn-secondary' : 'btn-success' }}">
                                        {{ $slider->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <h4>لا توجد سلايدات</h4>
                    <p>ابدأ بإضافة أول سلايد للصفحة الرئيسية</p>
                    <a href="{{ route('admin.hero-slider.create') }}" class="btn btn-primary">
                        إضافة سلايد جديد
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection