@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>تعديل التصميم</h1>
                <div>
                    <a href="{{ route('custom-designs.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>العودة للتصاميم
                    </a>
                </div>
            </div>
            
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form action="{{ route('custom-designs.update', $customDesign) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">اسم التصميم</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $customDesign->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">وصف التصميم (اختياري)</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $customDesign->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <!-- حقل مخفي لتخزين بيانات التصميم -->
                        <input type="hidden" id="design_data" name="design_data" value='{{ old('design_data', $customDesign->design_data) }}'>
                        @error('design_data')
                            <div class="text-danger small mb-3">{{ $message }}</div>
                        @enderror
                        
                        <div class="d-flex justify-content-between mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>حفظ التغييرات
                            </button>
                            <a href="{{ route('custom-designs.show', $customDesign) }}" class="btn btn-outline-secondary">
                                إلغاء
                            </a>
                        </div>
                    </form>
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
        const designDataInput = document.getElementById('design_data');
        
        // هنا يمكن إضافة الكود الخاص بتحميل محرر التصميم
        const editorElement = document.getElementById('design-editor');
        
        // تحميل محرر التصميم (يتم تنفيذه حسب المكتبة المستخدمة)
        editorElement.innerHTML = '<div class="alert alert-info">تم تحميل محرر التصميم</div>';
        // هنا يمكن إضافة كود لتحميل محرر التصميم الفعلي
        
        // مثال على تحديث حقل البيانات المخفي عند تغيير التصميم
        function updateDesignData(newDesignData) {
            designDataInput.value = JSON.stringify(newDesignData);
        }
        
        // يمكن استدعاء هذه الدالة عند تغيير التصميم
        // updateDesignData(designData);
    });
</script>
@endpush
@endsection