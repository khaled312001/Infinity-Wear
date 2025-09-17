@extends('layouts.dashboard')

@section('title', 'إنشاء خطة جديدة')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'إنشاء خطة جديدة')
@section('page-subtitle', 'إنشاء خطة استراتيجية جديدة مع تحليل SWOT')

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('content')
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">
                <i class="fas fa-plus-circle me-2 text-primary"></i>
                إنشاء خطة استراتيجية جديدة
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.company-plans.store') }}" method="POST" id="planForm">
                @csrf
                
                <!-- المعلومات الأساسية -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            المعلومات الأساسية
                        </h6>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">عنوان الخطة <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="type" class="form-label">نوع الخطة <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" 
                                    id="type" name="type" required>
                                <option value="">اختر نوع الخطة</option>
                                <option value="quarterly" {{ old('type') == 'quarterly' ? 'selected' : '' }}>ربع سنوية (3 أشهر)</option>
                                <option value="semi_annual" {{ old('type') == 'semi_annual' ? 'selected' : '' }}>نصف سنوية (6 أشهر)</option>
                                <option value="annual" {{ old('type') == 'annual' ? 'selected' : '' }}>سنوية (12 شهر)</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">تاريخ البداية <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                   id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="end_date" class="form-label">تاريخ النهاية <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                   id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="budget" class="form-label">الميزانية (ر.س)</label>
                            <input type="number" class="form-control @error('budget') is-invalid @enderror" 
                                   id="budget" name="budget" value="{{ old('budget') }}" step="0.01" min="0">
                            @error('budget')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="assigned_to" class="form-label">المسؤول عن الخطة</label>
                            <select class="form-select @error('assigned_to') is-invalid @enderror" 
                                    id="assigned_to" name="assigned_to">
                                <option value="">اختر المسؤول</option>
                                @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}" {{ old('assigned_to') == $admin->id ? 'selected' : '' }}>
                                        {{ $admin->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('assigned_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">وصف الخطة</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- الأهداف -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-bullseye me-2"></i>
                            الأهداف الاستراتيجية
                        </h6>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">الأهداف <span class="text-danger">*</span></label>
                    <div id="objectives-container">
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="objectives[]" placeholder="أدخل الهدف الأول" required>
                            <button type="button" class="btn btn-outline-danger" onclick="removeObjective(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm" onclick="addObjective()">
                        <i class="fas fa-plus me-1"></i>إضافة هدف
                    </button>
                </div>
                
                <!-- تحليل SWOT -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-chart-pie me-2"></i>
                            تحليل SWOT
                        </h6>
                    </div>
                </div>
                
                <div class="row">
                    <!-- نقاط القوة -->
                    <div class="col-md-6">
                        <div class="card border-success">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-thumbs-up me-2"></i>
                                    نقاط القوة (Strengths)
                                </h6>
                            </div>
                            <div class="card-body">
                                <div id="strengths-container">
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="strengths[]" placeholder="أدخل نقطة قوة" required>
                                        <button type="button" class="btn btn-outline-danger" onclick="removeStrength(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-success btn-sm" onclick="addStrength()">
                                    <i class="fas fa-plus me-1"></i>إضافة نقطة قوة
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- نقاط الضعف -->
                    <div class="col-md-6">
                        <div class="card border-warning">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0">
                                    <i class="fas fa-thumbs-down me-2"></i>
                                    نقاط الضعف (Weaknesses)
                                </h6>
                            </div>
                            <div class="card-body">
                                <div id="weaknesses-container">
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="weaknesses[]" placeholder="أدخل نقطة ضعف" required>
                                        <button type="button" class="btn btn-outline-danger" onclick="removeWeakness(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-warning btn-sm" onclick="addWeakness()">
                                    <i class="fas fa-plus me-1"></i>إضافة نقطة ضعف
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <!-- الفرص -->
                    <div class="col-md-6">
                        <div class="card border-info">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-lightbulb me-2"></i>
                                    الفرص (Opportunities)
                                </h6>
                            </div>
                            <div class="card-body">
                                <div id="opportunities-container">
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="opportunities[]" placeholder="أدخل فرصة" required>
                                        <button type="button" class="btn btn-outline-danger" onclick="removeOpportunity(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-info btn-sm" onclick="addOpportunity()">
                                    <i class="fas fa-plus me-1"></i>إضافة فرصة
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- التهديدات -->
                    <div class="col-md-6">
                        <div class="card border-danger">
                            <div class="card-header bg-danger text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    التهديدات (Threats)
                                </h6>
                            </div>
                            <div class="card-body">
                                <div id="threats-container">
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="threats[]" placeholder="أدخل تهديد" required>
                                        <button type="button" class="btn btn-outline-danger" onclick="removeThreat(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline-danger btn-sm" onclick="addThreat()">
                                    <i class="fas fa-plus me-1"></i>إضافة تهديد
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- الاستراتيجيات وعناصر العمل -->
                <div class="row mb-4 mt-4">
                    <div class="col-12">
                        <h6 class="text-primary mb-3">
                            <i class="fas fa-cogs me-2"></i>
                            الاستراتيجيات وعناصر العمل
                        </h6>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">الاستراتيجيات <span class="text-danger">*</span></label>
                            <div id="strategies-container">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="strategies[]" placeholder="أدخل الاستراتيجية الأولى" required>
                                    <button type="button" class="btn btn-outline-danger" onclick="removeStrategy(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addStrategy()">
                                <i class="fas fa-plus me-1"></i>إضافة استراتيجية
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">عناصر العمل <span class="text-danger">*</span></label>
                            <div id="action-items-container">
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="action_items[]" placeholder="أدخل عنصر العمل الأول" required>
                                    <button type="button" class="btn btn-outline-danger" onclick="removeActionItem(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm" onclick="addActionItem()">
                                <i class="fas fa-plus me-1"></i>إضافة عنصر عمل
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- ملاحظات -->
                <div class="mb-3">
                    <label for="notes" class="form-label">ملاحظات إضافية</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" 
                              id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.company-plans.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right me-2"></i>
                        إلغاء
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        حفظ الخطة
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // إضافة أهداف
    function addObjective() {
        const container = document.getElementById('objectives-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" class="form-control" name="objectives[]" placeholder="أدخل هدف جديد" required>
            <button type="button" class="btn btn-outline-danger" onclick="removeObjective(this)">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(div);
    }

    function removeObjective(button) {
        button.parentElement.remove();
    }

    // إضافة نقاط القوة
    function addStrength() {
        const container = document.getElementById('strengths-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" class="form-control" name="strengths[]" placeholder="أدخل نقطة قوة جديدة" required>
            <button type="button" class="btn btn-outline-danger" onclick="removeStrength(this)">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(div);
    }

    function removeStrength(button) {
        button.parentElement.remove();
    }

    // إضافة نقاط الضعف
    function addWeakness() {
        const container = document.getElementById('weaknesses-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" class="form-control" name="weaknesses[]" placeholder="أدخل نقطة ضعف جديدة" required>
            <button type="button" class="btn btn-outline-danger" onclick="removeWeakness(this)">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(div);
    }

    function removeWeakness(button) {
        button.parentElement.remove();
    }

    // إضافة الفرص
    function addOpportunity() {
        const container = document.getElementById('opportunities-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" class="form-control" name="opportunities[]" placeholder="أدخل فرصة جديدة" required>
            <button type="button" class="btn btn-outline-danger" onclick="removeOpportunity(this)">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(div);
    }

    function removeOpportunity(button) {
        button.parentElement.remove();
    }

    // إضافة التهديدات
    function addThreat() {
        const container = document.getElementById('threats-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" class="form-control" name="threats[]" placeholder="أدخل تهديد جديد" required>
            <button type="button" class="btn btn-outline-danger" onclick="removeThreat(this)">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(div);
    }

    function removeThreat(button) {
        button.parentElement.remove();
    }

    // إضافة الاستراتيجيات
    function addStrategy() {
        const container = document.getElementById('strategies-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" class="form-control" name="strategies[]" placeholder="أدخل استراتيجية جديدة" required>
            <button type="button" class="btn btn-outline-danger" onclick="removeStrategy(this)">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(div);
    }

    function removeStrategy(button) {
        button.parentElement.remove();
    }

    // إضافة عناصر العمل
    function addActionItem() {
        const container = document.getElementById('action-items-container');
        const div = document.createElement('div');
        div.className = 'input-group mb-2';
        div.innerHTML = `
            <input type="text" class="form-control" name="action_items[]" placeholder="أدخل عنصر عمل جديد" required>
            <button type="button" class="btn btn-outline-danger" onclick="removeActionItem(this)">
                <i class="fas fa-trash"></i>
            </button>
        `;
        container.appendChild(div);
    }

    function removeActionItem(button) {
        button.parentElement.remove();
    }

    // تحديث تاريخ النهاية تلقائياً حسب نوع الخطة
    document.getElementById('type').addEventListener('change', function() {
        const startDate = document.getElementById('start_date').value;
        if (startDate) {
            const start = new Date(startDate);
            let end = new Date(start);
            
            switch(this.value) {
                case 'quarterly':
                    end.setMonth(end.getMonth() + 3);
                    break;
                case 'semi_annual':
                    end.setMonth(end.getMonth() + 6);
                    break;
                case 'annual':
                    end.setFullYear(end.getFullYear() + 1);
                    break;
            }
            
            document.getElementById('end_date').value = end.toISOString().split('T')[0];
        }
    });
</script>
@endpush