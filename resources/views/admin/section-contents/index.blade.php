@extends('layouts.dashboard')

@section('title', 'إدارة محتوى القسم: ' . $homeSection->name)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>إدارة محتوى القسم: {{ $homeSection->name }}</h1>
        <div>
            <a href="{{ route('admin.section-contents.create', $homeSection) }}" class="btn btn-primary me-2">
                <i class="fas fa-plus"></i> إضافة محتوى جديد
            </a>
            <a href="{{ route('admin.home-sections.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> العودة للأقسام
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- معلومات القسم -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>معلومات القسم</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <strong>الاسم:</strong> {{ $homeSection->name }}
                </div>
                <div class="col-md-3">
                    <strong>النوع:</strong> {{ $homeSection->section_type }}
                </div>
                <div class="col-md-3">
                    <strong>التخطيط:</strong> {{ $homeSection->layout_type }}
                </div>
                <div class="col-md-3">
                    <strong>الحالة:</strong> 
                    <span class="badge {{ $homeSection->is_active ? 'bg-success' : 'bg-secondary' }}">
                        {{ $homeSection->is_active ? 'نشط' : 'غير نشط' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- محتوى القسم -->
    <div class="card">
        <div class="card-body">
            @if($contents->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>الصورة/الأيقونة</th>
                                <th>العنوان</th>
                                <th>النوع</th>
                                <th>الترتيب</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contents as $content)
                            <tr>
                                <td>
                                    @if($content->image)
                                        <img src="{{ asset('storage/' . $content->image) }}" 
                                             alt="{{ $content->title }}" 
                                             style="width: 60px; height: 40px; object-fit: cover;">
                                    @elseif($content->icon)
                                        <i class="{{ $content->icon }} fa-2x" style="color: {{ $content->icon_color }};"></i>
                                    @else
                                        <span class="text-muted">لا توجد</span>
                                    @endif
                                </td>
                                <td>{{ $content->title }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $content->type }}</span>
                                </td>
                                <td>{{ $content->order }}</td>
                                <td>
                                    <span class="badge {{ $content->is_active ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $content->is_active ? 'نشط' : 'غير نشط' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.section-contents.edit', [$homeSection, $content]) }}" 
                                       class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" 
                                          action="{{ route('admin.section-contents.destroy', [$homeSection, $content]) }}" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                                onclick="return confirm('هل أنت متأكد؟')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.section-contents.toggle-active', $content) }}" 
                                       class="btn btn-sm {{ $content->is_active ? 'btn-secondary' : 'btn-success' }}">
                                        {{ $content->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-5">
                    <h4>لا يوجد محتوى في هذا القسم</h4>
                    <p>ابدأ بإضافة أول محتوى لهذا القسم</p>
                    <a href="{{ route('admin.section-contents.create', $homeSection) }}" class="btn btn-primary">
                        إضافة محتوى جديد
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection