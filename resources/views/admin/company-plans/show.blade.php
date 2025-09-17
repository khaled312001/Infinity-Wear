@extends('layouts.dashboard')

@section('title', 'عرض الخطة - ' . $companyPlan->title)
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'عرض الخطة')
@section('page-subtitle', $companyPlan->title)

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('page-actions')
    <a href="{{ route('admin.company-plans.edit', $companyPlan) }}" class="btn btn-primary">
        <i class="fas fa-edit me-2"></i>
        تعديل الخطة
    </a>
    <a href="{{ route('admin.company-plans.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-right me-2"></i>
        العودة للقائمة
    </a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- معلومات الخطة الأساسية -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-chart-line me-2 text-primary"></i>
                            {{ $companyPlan->title }}
                        </h5>
                        <div>
                            <span class="badge bg-{{ $companyPlan->status_color }} fs-6">{{ $companyPlan->status_label }}</span>
                            <span class="badge bg-info fs-6">{{ $companyPlan->type_label }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if($companyPlan->description)
                        <p class="text-muted mb-3">{{ $companyPlan->description }}</p>
                    @endif
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>تاريخ البداية:</strong>
                                <span class="text-primary">{{ $companyPlan->start_date->format('Y-m-d') }}</span>
                            </div>
                            <div class="mb-3">
                                <strong>تاريخ النهاية:</strong>
                                <span class="text-primary">{{ $companyPlan->end_date->format('Y-m-d') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <strong>المسؤول عن الخطة:</strong>
                                <span class="text-primary">{{ $companyPlan->assignee->name ?? 'غير محدد' }}</span>
                            </div>
                            <div class="mb-3">
                                <strong>منشئ الخطة:</strong>
                                <span class="text-primary">{{ $companyPlan->creator->name ?? 'غير محدد' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    @if($companyPlan->notes)
                        <div class="alert alert-info">
                            <strong>ملاحظات:</strong><br>
                            {{ $companyPlan->notes }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- إحصائيات سريعة -->
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-pie me-2 text-primary"></i>
                        إحصائيات الخطة
                    </h6>
                </div>
                <div class="card-body">
                    <!-- التقدم -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span>التقدم</span>
                            <span>{{ $companyPlan->progress_percentage }}%</span>
                        </div>
                        <div class="progress" style="height: 20px;">
                            <div class="progress-bar bg-{{ $companyPlan->progress_percentage >= 100 ? 'success' : ($companyPlan->progress_percentage >= 75 ? 'info' : ($companyPlan->progress_percentage >= 50 ? 'warning' : 'danger')) }}" 
                                 role="progressbar" 
                                 style="width: {{ $companyPlan->progress_percentage }}%">
                                {{ $companyPlan->progress_percentage }}%
                            </div>
                        </div>
                    </div>
                    
                    <!-- الأيام المتبقية -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <span>الأيام المتبقية:</span>
                            <span class="text-{{ $companyPlan->days_remaining > 30 ? 'success' : ($companyPlan->days_remaining > 7 ? 'warning' : 'danger') }}">
                                {{ $companyPlan->days_remaining }} يوم
                            </span>
                        </div>
                    </div>
                    
                    <!-- الميزانية -->
                    @if($companyPlan->budget)
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>الميزانية:</span>
                                <span class="text-primary">{{ number_format($companyPlan->budget, 2) }} ر.س</span>
                            </div>
                            @if($companyPlan->actual_cost)
                                <div class="d-flex justify-content-between">
                                    <span>التكلفة الفعلية:</span>
                                    <span class="text-{{ $companyPlan->cost_percentage > 100 ? 'danger' : 'success' }}">
                                        {{ number_format($companyPlan->actual_cost, 2) }} ر.س
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span>نسبة التكلفة:</span>
                                    <span class="text-{{ $companyPlan->cost_percentage > 100 ? 'danger' : 'success' }}">
                                        {{ $companyPlan->cost_percentage }}%
                                    </span>
                                </div>
                            @endif
                        </div>
                    @endif
                    
                    @if($companyPlan->is_overdue)
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            هذه الخطة متأخرة عن الموعد المحدد
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- الأهداف -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="fas fa-bullseye me-2 text-primary"></i>
                        الأهداف الاستراتيجية
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($companyPlan->objectives as $index => $objective)
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <span class="badge bg-primary rounded-circle">{{ $index + 1 }}</span>
                                </div>
                                <div>
                                    <p class="mb-0">{{ $objective }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- تحليل SWOT -->
    <div class="row mb-4">
        <div class="col-12">
            <h5 class="text-primary mb-3">
                <i class="fas fa-chart-pie me-2"></i>
                تحليل SWOT
            </h5>
        </div>
    </div>
    
    <div class="row">
        <!-- نقاط القوة -->
        <div class="col-md-6 mb-4">
            <div class="card border-success h-100">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-thumbs-up me-2"></i>
                        نقاط القوة (Strengths)
                    </h6>
                </div>
                <div class="card-body">
                    @foreach($companyPlan->strengths as $index => $strength)
                    <div class="d-flex align-items-start mb-2">
                        <div class="me-2">
                            <i class="fas fa-check-circle text-success"></i>
                        </div>
                        <div>
                            <p class="mb-0">{{ $strength }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- نقاط الضعف -->
        <div class="col-md-6 mb-4">
            <div class="card border-warning h-100">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-thumbs-down me-2"></i>
                        نقاط الضعف (Weaknesses)
                    </h6>
                </div>
                <div class="card-body">
                    @foreach($companyPlan->weaknesses as $index => $weakness)
                    <div class="d-flex align-items-start mb-2">
                        <div class="me-2">
                            <i class="fas fa-exclamation-circle text-warning"></i>
                        </div>
                        <div>
                            <p class="mb-0">{{ $weakness }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <!-- الفرص -->
        <div class="col-md-6 mb-4">
            <div class="card border-info h-100">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-lightbulb me-2"></i>
                        الفرص (Opportunities)
                    </h6>
                </div>
                <div class="card-body">
                    @foreach($companyPlan->opportunities as $index => $opportunity)
                    <div class="d-flex align-items-start mb-2">
                        <div class="me-2">
                            <i class="fas fa-star text-info"></i>
                        </div>
                        <div>
                            <p class="mb-0">{{ $opportunity }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <!-- التهديدات -->
        <div class="col-md-6 mb-4">
            <div class="card border-danger h-100">
                <div class="card-header bg-danger text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        التهديدات (Threats)
                    </h6>
                </div>
                <div class="card-body">
                    @foreach($companyPlan->threats as $index => $threat)
                    <div class="d-flex align-items-start mb-2">
                        <div class="me-2">
                            <i class="fas fa-times-circle text-danger"></i>
                        </div>
                        <div>
                            <p class="mb-0">{{ $threat }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- الاستراتيجيات وعناصر العمل -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="fas fa-cogs me-2 text-primary"></i>
                        الاستراتيجيات
                    </h6>
                </div>
                <div class="card-body">
                    @foreach($companyPlan->strategies as $index => $strategy)
                    <div class="d-flex align-items-start mb-3">
                        <div class="me-3">
                            <span class="badge bg-primary rounded-circle">{{ $index + 1 }}</span>
                        </div>
                        <div>
                            <p class="mb-0">{{ $strategy }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h6 class="mb-0">
                        <i class="fas fa-tasks me-2 text-primary"></i>
                        عناصر العمل
                    </h6>
                </div>
                <div class="card-body">
                    @foreach($companyPlan->action_items as $index => $actionItem)
                    <div class="d-flex align-items-start mb-3">
                        <div class="me-3">
                            <span class="badge bg-success rounded-circle">{{ $index + 1 }}</span>
                        </div>
                        <div>
                            <p class="mb-0">{{ $actionItem }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- تحديث حالة الخطة -->
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <h6 class="mb-0">
                <i class="fas fa-cog me-2 text-primary"></i>
                تحديث حالة الخطة
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.company-plans.update-status', $companyPlan) }}" method="POST" class="d-inline">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4">
                        <select name="status" class="form-select" required>
                            <option value="draft" {{ $companyPlan->status === 'draft' ? 'selected' : '' }}>مسودة</option>
                            <option value="active" {{ $companyPlan->status === 'active' ? 'selected' : '' }}>نشطة</option>
                            <option value="completed" {{ $companyPlan->status === 'completed' ? 'selected' : '' }}>مكتملة</option>
                            <option value="cancelled" {{ $companyPlan->status === 'cancelled' ? 'selected' : '' }}>ملغية</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>
                            تحديث الحالة
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection