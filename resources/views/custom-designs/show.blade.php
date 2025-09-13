@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>{{ $customDesign->name }}</h1>
                <div>
                    <a href="{{ route('custom-designs.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>العودة للتصاميم
                    </a>
                </div>
            </div>
            
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-title">تفاصيل التصميم</h5>
                            <p class="text-muted small">تم الإنشاء: {{ $customDesign->created_at->format('Y/m/d') }}</p>
                            
                            @if($customDesign->description)
                                <div class="mb-4">
                                    <h6>الوصف:</h6>
                                    <p>{{ $customDesign->description }}</p>
                                </div>
                            @endif
                            
                            <div class="d-flex mt-4">
                                <a href="{{ route('custom-designs.edit', $customDesign) }}" class="btn btn-primary me-2">
                                    <i class="fas fa-edit me-1"></i>تعديل التصميم
                                </a>
                                <form action="{{ route('custom-designs.destroy', $customDesign) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('هل أنت متأكد من حذف هذا التصميم؟')">
                                        <i class="fas fa-trash-alt me-1"></i>حذف التصميم
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">معاينة التصميم</h6>
                                    <div id="design-preview" class="mt-3 border rounded p-3 text-center">
                                        <p class="text-muted">جاري تحميل المعاينة...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">محرر التصميم</h5>
                    <div id="design-editor" class="border rounded p-3" style="min-height: 400px;">
                        <!-- سيتم تحميل محرر التصميم هنا -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // استرجاع بيانات التصميم من قاعدة البيانات
        const designData = {!! $customDesign->design_data !!};
        
        // هنا يمكن إضافة الكود الخاص بتحميل محرر التصميم وعرض المعاينة
        // على سبيل المثال:
        const previewElement = document.getElementById('design-preview');
        const editorElement = document.getElementById('design-editor');
        
        // عرض معاينة بسيطة (يمكن تعديلها حسب نوع التصميم)
        if (designData) {
            previewElement.innerHTML = '<div class="alert alert-success">تم تحميل التصميم بنجاح</div>';
            // هنا يمكن إضافة كود لعرض معاينة التصميم بشكل أفضل
        } else {
            previewElement.innerHTML = '<div class="alert alert-warning">لا توجد بيانات للتصميم</div>';
        }
        
        // تحميل محرر التصميم (يتم تنفيذه حسب المكتبة المستخدمة)
        editorElement.innerHTML = '<div class="alert alert-info">تم تحميل محرر التصميم</div>';
        // هنا يمكن إضافة كود لتحميل محرر التصميم الفعلي
    });
</script>
@endpush
@endsection