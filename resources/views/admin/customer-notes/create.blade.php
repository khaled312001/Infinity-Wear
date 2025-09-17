@extends('layouts.dashboard')

@section('title', 'إضافة ملاحظة جديدة')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'إضافة ملاحظة جديدة')
@section('page-subtitle', 'إضافة ملاحظة على عميل في قاعدة البيانات')
@section('profile-route', '#')
@section('settings-route', '#')

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-plus me-2 text-primary"></i>
                        إضافة ملاحظة جديدة
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.customer-notes.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-3">
                            <!-- العميل -->
                            <div class="col-md-6">
                                <label for="customer_id" class="form-label">العميل <span class="text-danger">*</span></label>
                                <select name="customer_id" id="customer_id" class="form-select @error('customer_id') is-invalid @enderror" required>
                                    <option value="">اختر العميل</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->name }} ({{ $customer->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- نوع الملاحظة -->
                            <div class="col-md-6">
                                <label for="note_type" class="form-label">نوع الملاحظة <span class="text-danger">*</span></label>
                                <select name="note_type" id="note_type" class="form-select @error('note_type') is-invalid @enderror" required>
                                    <option value="">اختر النوع</option>
                                    <option value="marketing" {{ old('note_type') == 'marketing' ? 'selected' : '' }}>تسويق</option>
                                    <option value="sales" {{ old('note_type') == 'sales' ? 'selected' : '' }}>مبيعات</option>
                                    <option value="general" {{ old('note_type') == 'general' ? 'selected' : '' }}>عام</option>
                                </select>
                                @error('note_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- العنوان -->
                            <div class="col-12">
                                <label for="title" class="form-label">عنوان الملاحظة <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                       value="{{ old('title') }}" placeholder="أدخل عنوان الملاحظة" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- المحتوى -->
                            <div class="col-12">
                                <label for="content" class="form-label">محتوى الملاحظة <span class="text-danger">*</span></label>
                                <textarea name="content" id="content" rows="6" class="form-control @error('content') is-invalid @enderror" 
                                          placeholder="أدخل تفاصيل الملاحظة" required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- الأولوية -->
                            <div class="col-md-6">
                                <label for="priority" class="form-label">الأولوية <span class="text-danger">*</span></label>
                                <select name="priority" id="priority" class="form-select @error('priority') is-invalid @enderror" required>
                                    <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>منخفضة</option>
                                    <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>متوسطة</option>
                                    <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>عالية</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- تاريخ المتابعة -->
                            <div class="col-md-6">
                                <label for="follow_up_date" class="form-label">تاريخ المتابعة</label>
                                <input type="datetime-local" name="follow_up_date" id="follow_up_date" 
                                       class="form-control @error('follow_up_date') is-invalid @enderror" 
                                       value="{{ old('follow_up_date') }}">
                                @error('follow_up_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- التصنيفات -->
                            <div class="col-12">
                                <label for="tags" class="form-label">التصنيفات</label>
                                <input type="text" name="tags" id="tags" class="form-control @error('tags') is-invalid @enderror" 
                                       value="{{ old('tags') }}" placeholder="أدخل التصنيفات مفصولة بفواصل (مثال: مهم، متابعة، عاجل)">
                                <div class="form-text">أدخل التصنيفات مفصولة بفواصل لسهولة البحث والتصنيف</div>
                                @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- أزرار الإجراءات -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.customer-notes.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>
                                إلغاء
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                حفظ الملاحظة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // تعيين الحد الأدنى لتاريخ المتابعة إلى اليوم
    document.addEventListener('DOMContentLoaded', function() {
        const followUpDateInput = document.getElementById('follow_up_date');
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        
        followUpDateInput.min = `${year}-${month}-${day}T${hours}:${minutes}`;
    });

    // تحسين تجربة المستخدم
    document.getElementById('note_type').addEventListener('change', function() {
        const contentTextarea = document.getElementById('content');
        const placeholder = {
            'marketing': 'أدخل تفاصيل الحملة التسويقية أو الاستراتيجية...',
            'sales': 'أدخل تفاصيل المبيعات أو المتابعة مع العميل...',
            'general': 'أدخل تفاصيل الملاحظة العامة...'
        };
        
        contentTextarea.placeholder = placeholder[this.value] || 'أدخل تفاصيل الملاحظة';
    });
</script>
@endpush