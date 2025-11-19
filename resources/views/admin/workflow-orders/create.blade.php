@extends('layouts.dashboard')

@section('title', 'إنشاء طلب جديد')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h3 mb-0">
                    <i class="fas fa-plus-circle me-2 text-primary"></i>
                    إنشاء طلب جديد
                </h2>
                <a href="{{ route('admin.workflow-orders.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-right me-2"></i>العودة
                </a>
            </div>

            <form action="{{ route('admin.workflow-orders.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <!-- Customer Information -->
                    <div class="col-md-6">
                        <div class="dashboard-card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-user me-2"></i>معلومات العميل</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">اسم العميل *</label>
                                    <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">البريد الإلكتروني *</label>
                                    <input type="email" name="customer_email" class="form-control" value="{{ old('customer_email') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">رقم الهاتف *</label>
                                    <input type="text" name="customer_phone" class="form-control" value="{{ old('customer_phone') }}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">العنوان</label>
                                    <textarea name="customer_address" class="form-control" rows="3">{{ old('customer_address') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">المستورد (اختياري)</label>
                                    <select name="importer_id" class="form-select">
                                        <option value="">اختر مستورد</option>
                                        @foreach($importers as $importer)
                                            <option value="{{ $importer->id }}" {{ old('importer_id') == $importer->id ? 'selected' : '' }}>
                                                {{ $importer->name }} - {{ $importer->company_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="col-md-6">
                        <div class="dashboard-card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="fas fa-shopping-bag me-2"></i>تفاصيل الطلب</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">الكمية *</label>
                                    <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 1) }}" min="1" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">التكلفة المقدرة</label>
                                    <input type="number" name="estimated_cost" class="form-control" value="{{ old('estimated_cost') }}" step="0.01" min="0">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">المتطلبات</label>
                                    <textarea name="requirements" class="form-control" rows="4" placeholder="وصف متطلبات الطلب...">{{ old('requirements') }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">تعيين لمستخدم التسويق</label>
                                    <select name="marketing_user_id" class="form-select">
                                        <option value="">اختر مستخدم التسويق</option>
                                        @foreach($marketingUsers as $user)
                                            <option value="{{ $user->id }}" {{ old('marketing_user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.workflow-orders.index') }}" class="btn btn-secondary">إلغاء</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>إنشاء الطلب
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

