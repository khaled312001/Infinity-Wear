@extends('layouts.dashboard')

@section('title', 'إنشاء طلب جديد')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'إنشاء طلب جديد')
@section('page-subtitle', 'إضافة طلب جديد للعميل')
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
                        إنشاء طلب جديد
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.store') }}" method="POST">
                        @csrf
                        
                        <div class="row g-3">
                            <!-- العميل -->
                            <div class="col-md-6">
                                <label for="user_id" class="form-label">العميل <span class="text-danger">*</span></label>
                                <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                                    <option value="">اختر العميل</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- حالة الطلب -->
                            <div class="col-md-6">
                                <label for="status" class="form-label">حالة الطلب <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                                    <option value="processing" {{ old('status') == 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                                    <option value="shipped" {{ old('status') == 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                                    <option value="delivered" {{ old('status') == 'delivered' ? 'selected' : '' }}>تم التسليم</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- ملاحظات -->
                            <div class="col-12">
                                <label for="notes" class="form-label">ملاحظات</label>
                                <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror" 
                                          placeholder="أدخل أي ملاحظات إضافية">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- عناصر الطلب -->
                        <div class="mt-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">عناصر الطلب</h6>
                                <button type="button" class="btn btn-sm btn-outline-primary" onclick="addOrderItem()">
                                    <i class="fas fa-plus me-1"></i>
                                    إضافة عنصر
                                </button>
                            </div>

                            <div id="orderItems">
                                <div class="order-item border rounded p-3 mb-3">
                                    <div class="row g-3">
                                        <div class="col-md-5">
                                            <label class="form-label">اسم المنتج</label>
                                            <input type="text" name="items[0][product_name]" class="form-control" placeholder="أدخل اسم المنتج" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">الكمية</label>
                                            <input type="number" name="items[0][quantity]" class="form-control" min="1" value="1" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label class="form-label">السعر (ر.س)</label>
                                            <input type="number" name="items[0][price]" class="form-control" min="0" step="0.01" placeholder="0.00" required>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">المجموع</label>
                                            <input type="text" class="form-control total-price" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- أزرار الإجراءات -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>
                                إلغاء
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                حفظ الطلب
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
    let itemIndex = 1;

    function addOrderItem() {
        const orderItems = document.getElementById('orderItems');
        const newItem = document.createElement('div');
        newItem.className = 'order-item border rounded p-3 mb-3';
        newItem.innerHTML = `
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">اسم المنتج</label>
                    <input type="text" name="items[${itemIndex}][product_name]" class="form-control" placeholder="أدخل اسم المنتج" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">الكمية</label>
                    <input type="number" name="items[${itemIndex}][quantity]" class="form-control" min="1" value="1" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">السعر (ر.س)</label>
                    <input type="number" name="items[${itemIndex}][price]" class="form-control" min="0" step="0.01" placeholder="0.00" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">المجموع</label>
                    <div class="d-flex gap-1">
                        <input type="text" class="form-control total-price" readonly>
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeOrderItem(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        orderItems.appendChild(newItem);
        itemIndex++;
        
        // إضافة مستمعي الأحداث للعنصر الجديد
        addEventListeners(newItem);
    }

    function removeOrderItem(button) {
        button.closest('.order-item').remove();
    }

    function addEventListeners(item) {
        const quantityInput = item.querySelector('input[name*="[quantity]"]');
        const priceInput = item.querySelector('input[name*="[price]"]');
        const totalInput = item.querySelector('.total-price');

        function calculateTotal() {
            const quantity = parseFloat(quantityInput.value) || 0;
            const price = parseFloat(priceInput.value) || 0;
            const total = quantity * price;
            totalInput.value = total.toFixed(2);
        }

        quantityInput.addEventListener('input', calculateTotal);
        priceInput.addEventListener('input', calculateTotal);
    }

    // إضافة مستمعي الأحداث للعنصر الأول
    document.addEventListener('DOMContentLoaded', function() {
        const firstItem = document.querySelector('.order-item');
        if (firstItem) {
            addEventListeners(firstItem);
        }
    });
</script>
@endpush