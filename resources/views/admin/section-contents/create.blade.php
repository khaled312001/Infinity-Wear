@extends('layouts.dashboard')

@section('title', 'إضافة محتوى جديد للقسم: ' . $homeSection->name)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>إضافة محتوى جديد</h1>
        <a href="{{ route('admin.section-contents.index', $homeSection) }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> العودة
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>قسم: {{ $homeSection->name }} ({{ $homeSection->section_type }})</h5>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.section-contents.store', $homeSection) }}" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label for="type" class="form-label">نوع المحتوى *</label>
                            <select class="form-control @error('type') is-invalid @enderror" 
                                    id="type" name="type" required>
                                <option value="">اختر نوع المحتوى</option>
                                <option value="card" {{ old('type') == 'card' ? 'selected' : '' }}>بطاقة</option>
                                <option value="feature" {{ old('type') == 'feature' ? 'selected' : '' }}>ميزة</option>
                                <option value="service" {{ old('type') == 'service' ? 'selected' : '' }}>خدمة</option>
                                <option value="testimonial" {{ old('type') == 'testimonial' ? 'selected' : '' }}>شهادة</option>
                                <option value="team_member" {{ old('type') == 'team_member' ? 'selected' : '' }}>عضو فريق</option>
                                <option value="stat" {{ old('type') == 'stat' ? 'selected' : '' }}>إحصائية</option>
                                <option value="step" {{ old('type') == 'step' ? 'selected' : '' }}>خطوة</option>
                                <option value="portfolio_item" {{ old('type') == 'portfolio_item' ? 'selected' : '' }}>عمل سابق</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">العنوان *</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">الوصف</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="button_text" class="form-label">نص الزر</label>
                                    <input type="text" class="form-control @error('button_text') is-invalid @enderror" 
                                           id="button_text" name="button_text" value="{{ old('button_text') }}">
                                    @error('button_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="button_url" class="form-label">رابط الزر</label>
                                    <input type="url" class="form-control @error('button_url') is-invalid @enderror" 
                                           id="button_url" name="button_url" value="{{ old('button_url') }}">
                                    @error('button_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- حقول إضافية حسب النوع -->
                        <div id="extra-fields" style="display: none;">
                            <!-- حقول للشهادات -->
                            <div class="extra-field" data-type="testimonial">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="rating" class="form-label">التقييم (1-5)</label>
                                            <select class="form-control" name="extra_data[rating]">
                                                <option value="5">5 نجوم</option>
                                                <option value="4">4 نجوم</option>
                                                <option value="3">3 نجوم</option>
                                                <option value="2">2 نجوم</option>
                                                <option value="1">1 نجمة</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="position" class="form-label">المنصب</label>
                                            <input type="text" class="form-control" name="extra_data[position]" 
                                                   placeholder="مثل: مدير شركة">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- حقول للإحصائيات -->
                            <div class="extra-field" data-type="stat">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="number" class="form-label">الرقم</label>
                                            <input type="number" class="form-control" name="extra_data[number]" 
                                                   placeholder="500">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="suffix" class="form-label">اللاحقة</label>
                                            <input type="text" class="form-control" name="extra_data[suffix]" 
                                                   placeholder="+ أو %">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">الصورة</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="icon" class="form-label">الأيقونة (Font Awesome)</label>
                            <input type="text" class="form-control @error('icon') is-invalid @enderror" 
                                   id="icon" name="icon" value="{{ old('icon') }}" 
                                   placeholder="fas fa-star">
                            <small class="form-text text-muted">مثل: fas fa-star أو fas fa-home</small>
                            @error('icon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="icon_color" class="form-label">لون الأيقونة</label>
                            <input type="color" class="form-control @error('icon_color') is-invalid @enderror" 
                                   id="icon_color" name="icon_color" value="{{ old('icon_color', '#3b82f6') }}">
                            @error('icon_color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="order" class="form-label">الترتيب</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" 
                                   id="order" name="order" value="{{ old('order', 0) }}">
                            @error('order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" 
                                       name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    نشط
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> حفظ
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeSelect = document.getElementById('type');
    const extraFields = document.getElementById('extra-fields');
    
    typeSelect.addEventListener('change', function() {
        // إخفاء جميع الحقول الإضافية
        extraFields.style.display = 'none';
        document.querySelectorAll('.extra-field').forEach(field => {
            field.style.display = 'none';
        });
        
        // عرض الحقول المناسبة للنوع المختار
        const selectedType = this.value;
        if (selectedType) {
            const targetField = document.querySelector(`[data-type="${selectedType}"]`);
            if (targetField) {
                extraFields.style.display = 'block';
                targetField.style.display = 'block';
            }
        }
    });
});
</script>
@endsection