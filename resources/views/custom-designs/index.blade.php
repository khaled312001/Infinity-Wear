@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">تصاميمي المخصصة</h1>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <p>عرض {{ $designs->count() }} من {{ $designs->total() }} تصميم</p>
                <a href="{{ route('custom-designs.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>تصميم جديد
                </a>
            </div>
            
            @if($designs->count() > 0)
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    @foreach($designs as $design)
                        <div class="col">
                            <div class="card h-100 shadow-sm">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $design->name }}</h5>
                                    <p class="card-text text-muted small">
                                        تم الإنشاء: {{ $design->created_at->format('Y/m/d') }}
                                    </p>
                                    @if($design->description)
                                        <p class="card-text">{{ Str::limit($design->description, 100) }}</p>
                                    @else
                                        <p class="card-text text-muted">لا يوجد وصف</p>
                                    @endif
                                </div>
                                <div class="card-footer bg-transparent border-top-0">
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('custom-designs.show', $design) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye me-1"></i>عرض
                                        </a>
                                        <a href="{{ route('custom-designs.edit', $design) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-edit me-1"></i>تعديل
                                        </a>
                                        <form action="{{ route('custom-designs.destroy', $design) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف هذا التصميم؟')">
                                                <i class="fas fa-trash-alt me-1"></i>حذف
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="mt-4">
                    {{ $designs->links() }}
                </div>
            @else
                <div class="alert alert-info">
                    <p class="mb-0">لا توجد تصاميم مخصصة حتى الآن. <a href="{{ route('custom-designs.create') }}">إنشاء تصميم جديد</a></p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection