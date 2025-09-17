@extends('layouts.dashboard')

@section('title', 'إضافة عضو جديد لفريق التسويق')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'إضافة عضو جديد لفريق التسويق')
@section('page-subtitle', 'إضافة عضو جديد لفريق التسويق')

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('content')
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">
                <i class="fas fa-user-plus me-2 text-primary"></i>
                إضافة عضو جديد لفريق التسويق
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.marketing.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="admin_id" class="form-label">المشرف <span class="text-danger">*</span></label>
                            <select class="form-select @error('admin_id') is-invalid @enderror" 
                                    id="admin_id" name="admin_id" required>
                                <option value="">اختر المشرف</option>
                                @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}" {{ old('admin_id') == $admin->id ? 'selected' : '' }}>
                                        {{ $admin->name }} ({{ $admin->email }})
                                    </option>
                                @endforeach
                            </select>
                            @error('admin_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="department" class="form-label">القسم <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('department') is-invalid @enderror" 
                                   id="department" name="department" value="{{ old('department', 'التسويق') }}" required>
                            @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="position" class="form-label">المنصب <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('position') is-invalid @enderror" 
                                   id="position" name="position" value="{{ old('position') }}" required>
                            @error('position')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="phone" class="form-label">الهاتف</label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="bio" class="form-label">نبذة شخصية</label>
                    <textarea class="form-control @error('bio') is-invalid @enderror" 
                              id="bio" name="bio" rows="4">{{ old('bio') }}</textarea>
                    @error('bio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.marketing.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right me-2"></i>
                        إلغاء
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        حفظ العضو
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection