@extends('layouts.dashboard')

@section('title', 'تفاصيل المستخدم')
@section('page-title', 'تفاصيل المستخدم')
@section('page-subtitle', $user->name)

@section('page-actions')
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-right"></i> العودة للقائمة
    </a>
    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
        <i class="fas fa-edit"></i> تعديل
    </a>
@endsection

@section('content')
<div class="row">
                <div class="col-lg-4">
                    <!-- User Profile Card -->
                    <div class="card">
                        <div class="card-body text-center">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" 
                                     alt="{{ $user->name }}" 
                                     class="rounded-circle mb-3" 
                                     width="120" height="120">
                            @else
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" 
                                     style="width: 120px; height: 120px; font-size: 2rem;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                            
                            <h4>{{ $user->name }}</h4>
                            <p class="text-muted">{{ $user->getUserTypeLabelAttribute() }}</p>
                            
                            <div class="d-flex justify-content-center mb-3">
                                @if($user->is_active)
                                    <span class="badge bg-success fs-6">نشط</span>
                                @else
                                    <span class="badge bg-danger fs-6">غير نشط</span>
                                @endif
                            </div>

                            @if($user->bio)
                                <p class="text-muted">{{ $user->bio }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="card-title mb-0">معلومات التواصل</h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex align-items-center">
                                    <i class="fas fa-envelope text-primary me-2"></i>
                                    <div>
                                        <small class="text-muted">البريد الإلكتروني</small>
                                        <div>{{ $user->email }}</div>
                                    </div>
                                </div>
                                
                                @if($user->phone)
                                    <div class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-phone text-success me-2"></i>
                                        <div>
                                            <small class="text-muted">رقم الهاتف</small>
                                            <div>{{ $user->phone }}</div>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($user->city)
                                    <div class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-map-marker-alt text-warning me-2"></i>
                                        <div>
                                            <small class="text-muted">المدينة</small>
                                            <div>{{ $user->city }}</div>
                                        </div>
                                    </div>
                                @endif
                                
                                @if($user->address)
                                    <div class="list-group-item d-flex align-items-center">
                                        <i class="fas fa-home text-info me-2"></i>
                                        <div>
                                            <small class="text-muted">العنوان</small>
                                            <div>{{ $user->address }}</div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Account Information -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="card-title mb-0">معلومات الحساب</h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between">
                                    <span>تاريخ الإنشاء:</span>
                                    <span>{{ $user->created_at->format('Y-m-d H:i') }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between">
                                    <span>آخر تحديث:</span>
                                    <span>{{ $user->updated_at->format('Y-m-d H:i') }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between">
                                    <span>تأكيد البريد:</span>
                                    <span>
                                        @if($user->email_verified_at)
                                            <span class="badge bg-success">مؤكد</span>
                                        @else
                                            <span class="badge bg-warning">غير مؤكد</span>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <!-- User Type Specific Information -->
                    @if($user->user_type === 'importer' && $user->importer)
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">بيانات المستورد</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>اسم الشركة:</strong>
                                        <p>{{ $user->importer->company_name ?: 'غير محدد' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>نوع الشركة:</strong>
                                        <p>
                                            @switch($user->importer->company_type)
                                                @case('individual')
                                                    فرد
                                                    @break
                                                @case('company')
                                                    شركة
                                                    @break
                                                @case('institution')
                                                    مؤسسة
                                                    @break
                                                @default
                                                    غير محدد
                                            @endswitch
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>رقم السجل التجاري:</strong>
                                        <p>{{ $user->importer->business_license ?: 'غير محدد' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>حالة التحقق:</strong>
                                        <p>
                                            @if($user->importer->is_verified)
                                                <span class="badge bg-success">محقق</span>
                                            @else
                                                <span class="badge bg-warning">غير محقق</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($user->user_type === 'marketing' && $user->marketingTeam)
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">بيانات فريق التسويق</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>القسم:</strong>
                                        <p>{{ $user->marketingTeam->department ?: 'غير محدد' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>المنصب:</strong>
                                        <p>{{ $user->marketingTeam->position ?: 'غير محدد' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>تاريخ التوظيف:</strong>
                                        <p>{{ $user->marketingTeam->hire_date ? $user->marketingTeam->hire_date->format('Y-m-d') : 'غير محدد' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>الحالة:</strong>
                                        <p>
                                            @if($user->marketingTeam->is_active)
                                                <span class="badge bg-success">نشط</span>
                                            @else
                                                <span class="badge bg-danger">غير نشط</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if($user->user_type === 'sales' && $user->salesTeam)
                        <div class="card">
                            <div class="card-header">
                                <h6 class="card-title mb-0">بيانات فريق المبيعات</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>القسم:</strong>
                                        <p>{{ $user->salesTeam->department ?: 'غير محدد' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>المنصب:</strong>
                                        <p>{{ $user->salesTeam->position ?: 'غير محدد' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>تاريخ التوظيف:</strong>
                                        <p>{{ $user->salesTeam->hire_date ? $user->salesTeam->hire_date->format('Y-m-d') : 'غير محدد' }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>الحالة:</strong>
                                        <p>
                                            @if($user->salesTeam->is_active)
                                                <span class="badge bg-success">نشط</span>
                                            @else
                                                <span class="badge bg-danger">غير نشط</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- User Actions -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h6 class="card-title mb-0">الإجراءات</h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> تعديل المستخدم
                                </a>
                                
                                <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="d-inline">
                                    @csrf
                                    <button type="submit" 
                                            class="btn btn-{{ $user->is_active ? 'warning' : 'success' }}"
                                            onclick="return confirm('هل أنت متأكد من تغيير حالة المستخدم؟')">
                                        <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                        {{ $user->is_active ? 'إلغاء تفعيل' : 'تفعيل' }}
                                    </button>
                                </form>

                                @if($user->user_type === 'importer')
                                    <a href="{{ route('admin.importers.show', $user->id) }}" class="btn btn-info">
                                        <i class="fas fa-truck"></i> عرض في المستوردين
                                    </a>
                                @endif

                                <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                      class="d-inline"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> حذف المستخدم
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection