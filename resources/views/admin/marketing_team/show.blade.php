@extends('layouts.dashboard')

@section('title', 'عرض بيانات عضو فريق التسويق')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'عرض بيانات عضو فريق التسويق')
@section('page-subtitle', 'عرض بيانات عضو فريق التسويق: ' . $member->name)

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('content')
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-user me-2 text-primary"></i>
                    بيانات عضو فريق التسويق
                </h5>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.marketing.edit', $member->id) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit me-1"></i>
                        تعديل
                    </a>
                    <a href="{{ route('admin.marketing.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-right me-1"></i>
                        العودة
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">الاسم:</label>
                                <p class="form-control-plaintext">{{ $member->name }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">البريد الإلكتروني:</label>
                                <p class="form-control-plaintext">{{ $member->email }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">المنصب:</label>
                                <p class="form-control-plaintext">{{ $member->position ?? 'غير محدد' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">القسم:</label>
                                <p class="form-control-plaintext">
                                    <span class="badge bg-info">{{ $member->department ?? 'غير محدد' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">الهاتف:</label>
                                <p class="form-control-plaintext">{{ $member->phone ?? 'غير محدد' }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">الحالة:</label>
                                <p class="form-control-plaintext">
                                    @if($member->is_active)
                                        <span class="badge bg-success">نشط</span>
                                    @else
                                        <span class="badge bg-secondary">غير نشط</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    @if($member->bio)
                    <div class="mb-3">
                        <label class="form-label fw-bold">نبذة شخصية:</label>
                        <p class="form-control-plaintext">{{ $member->bio }}</p>
                    </div>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">تاريخ الانضمام:</label>
                                <p class="form-control-plaintext">{{ $member->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label fw-bold">آخر تحديث:</label>
                                <p class="form-control-plaintext">{{ $member->updated_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card bg-light">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                @if($member->avatar)
                                    <img src="{{ asset('storage/' . $member->avatar) }}" 
                                         alt="{{ $member->name }}" 
                                         class="rounded-circle" 
                                         style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                    <i class="fas fa-user-circle fa-5x text-primary"></i>
                                @endif
                            </div>
                            <h5>{{ $member->name }}</h5>
                            <p class="text-muted">{{ $member->position ?? 'عضو فريق التسويق' }}</p>
                            <span class="badge bg-info">{{ $member->department ?? 'التسويق' }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            @if(isset($taskStats) && $taskStats['total'] > 0)
            <div class="mt-4">
                <h6 class="mb-3">إحصائيات المهام</h6>
                <div class="row">
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center">
                                <h4>{{ $taskStats['total'] }}</h4>
                                <p class="mb-0">إجمالي المهام</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body text-center">
                                <h4>{{ $taskStats['pending'] ?? 0 }}</h4>
                                <p class="mb-0">قيد الانتظار</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center">
                                <h4>{{ $taskStats['in_progress'] ?? 0 }}</h4>
                                <p class="mb-0">قيد التنفيذ</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <h4>{{ $taskStats['completed'] ?? 0 }}</h4>
                                <p class="mb-0">مكتملة</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            @if(isset($member->tasks) && $member->tasks->count() > 0)
            <div class="mt-4">
                <h6 class="mb-3">المهام الأخيرة</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>عنوان المهمة</th>
                                <th>الحالة</th>
                                <th>الأولوية</th>
                                <th>تاريخ الإنشاء</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($member->tasks as $task)
                            <tr>
                                <td>{{ $task->title }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ $task->status_label }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $task->priority_label }}</span>
                                </td>
                                <td>{{ $task->created_at->format('Y-m-d') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection