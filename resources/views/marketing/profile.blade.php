@extends('layouts.marketing-dashboard')

@section('title', 'الملف الشخصي - فريق التسويق')
@section('dashboard-title', 'الملف الشخصي')
@section('page-title', 'الملف الشخصي')
@section('page-subtitle', 'إدارة معلوماتك الشخصية')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user me-2"></i>
                    معلومات الملف الشخصي
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('marketing.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">الاسم الكامل *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="phone" class="form-label">رقم الهاتف</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="city" class="form-label">المدينة</label>
                            <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                   id="city" name="city" value="{{ old('city', $user->city) }}">
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="address" class="form-label">العنوان</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  id="address" name="address" rows="3">{{ old('address', $user->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="bio" class="form-label">نبذة شخصية</label>
                        <textarea class="form-control @error('bio') is-invalid @enderror" 
                                  id="bio" name="bio" rows="4">{{ old('bio', $user->bio) }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    معلومات الحساب
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label text-muted">نوع المستخدم</label>
                    <p class="mb-0">
                        <span class="badge bg-primary">فريق التسويق</span>
                    </p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted">تاريخ الانضمام</label>
                    <p class="mb-0">{{ $user->created_at->format('Y-m-d') }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted">آخر تحديث</label>
                    <p class="mb-0">{{ $user->updated_at->format('Y-m-d H:i') }}</p>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted">حالة الحساب</label>
                    <p class="mb-0">
                        <span class="badge bg-success">نشط</span>
                    </p>
                </div>
            </div>
        </div>
        
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    إحصائيات سريعة
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6 mb-3">
                        <h4 class="text-primary mb-1">{{ \App\Models\PortfolioItem::count() }}</h4>
                        <small class="text-muted">مشاريع المعرض</small>
                    </div>
                    <div class="col-6 mb-3">
                        <h4 class="text-success mb-1">{{ \App\Models\Testimonial::count() }}</h4>
                        <small class="text-muted">التقييمات</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-warning mb-1">{{ \App\Models\Task::where('department', 'marketing')->count() }}</h4>
                        <small class="text-muted">المهام</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-info mb-1">{{ \App\Models\WhatsAppMessage::count() }}</h4>
                        <small class="text-muted">رسائل الواتساب</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
