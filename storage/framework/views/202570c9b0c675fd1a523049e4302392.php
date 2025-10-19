<?php $__env->startSection('title', 'تعديل الخطة - ' . $companyPlan->title); ?>
<?php $__env->startSection('dashboard-title', 'لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'تعديل الخطة'); ?>
<?php $__env->startSection('page-subtitle', $companyPlan->title); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('partials.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="dashboard-card">
        <div class="card-header bg-white border-bottom">
            <h5 class="mb-0">
                <i class="fas fa-edit me-2 text-primary"></i>
                تعديل الخطة الاستراتيجية
            </h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('admin.company-plans.update', $companyPlan)); ?>" method="POST" id="planForm">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
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
                            <input type="text" class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="title" name="title" value="<?php echo e(old('title', $companyPlan->title)); ?>" required>
                            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="type" class="form-label">نوع الخطة <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="type" name="type" required>
                                <option value="">اختر نوع الخطة</option>
                                <option value="quarterly" <?php echo e(old('type', $companyPlan->type) == 'quarterly' ? 'selected' : ''); ?>>ربع سنوية (3 أشهر)</option>
                                <option value="semi_annual" <?php echo e(old('type', $companyPlan->type) == 'semi_annual' ? 'selected' : ''); ?>>نصف سنوية (6 أشهر)</option>
                                <option value="annual" <?php echo e(old('type', $companyPlan->type) == 'annual' ? 'selected' : ''); ?>>سنوية (12 شهر)</option>
                            </select>
                            <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="status" class="form-label">حالة الخطة <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="status" name="status" required>
                                <option value="draft" <?php echo e(old('status', $companyPlan->status) == 'draft' ? 'selected' : ''); ?>>مسودة</option>
                                <option value="active" <?php echo e(old('status', $companyPlan->status) == 'active' ? 'selected' : ''); ?>>نشطة</option>
                                <option value="completed" <?php echo e(old('status', $companyPlan->status) == 'completed' ? 'selected' : ''); ?>>مكتملة</option>
                                <option value="cancelled" <?php echo e(old('status', $companyPlan->status) == 'cancelled' ? 'selected' : ''); ?>>ملغية</option>
                            </select>
                            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="start_date" class="form-label">تاريخ البداية <span class="text-danger">*</span></label>
                            <input type="date" class="form-control <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="start_date" name="start_date" value="<?php echo e(old('start_date', $companyPlan->start_date->format('Y-m-d'))); ?>" required>
                            <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="end_date" class="form-label">تاريخ النهاية <span class="text-danger">*</span></label>
                            <input type="date" class="form-control <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="end_date" name="end_date" value="<?php echo e(old('end_date', $companyPlan->end_date->format('Y-m-d'))); ?>" required>
                            <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="budget" class="form-label">الميزانية (ر.س)</label>
                            <input type="number" class="form-control <?php $__errorArgs = ['budget'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="budget" name="budget" value="<?php echo e(old('budget', $companyPlan->budget)); ?>" step="0.01" min="0">
                            <?php $__errorArgs = ['budget'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="actual_cost" class="form-label">التكلفة الفعلية (ر.س)</label>
                            <input type="number" class="form-control <?php $__errorArgs = ['actual_cost'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="actual_cost" name="actual_cost" value="<?php echo e(old('actual_cost', $companyPlan->actual_cost)); ?>" step="0.01" min="0">
                            <?php $__errorArgs = ['actual_cost'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="progress_percentage" class="form-label">نسبة التقدم (%) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control <?php $__errorArgs = ['progress_percentage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="progress_percentage" name="progress_percentage" value="<?php echo e(old('progress_percentage', $companyPlan->progress_percentage)); ?>" min="0" max="100" required>
                            <?php $__errorArgs = ['progress_percentage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="assigned_to" class="form-label">المسؤول عن الخطة</label>
                            <select class="form-select <?php $__errorArgs = ['assigned_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="assigned_to" name="assigned_to">
                                <option value="">اختر المسؤول</option>
                                <?php $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($admin->id); ?>" <?php echo e(old('assigned_to', $companyPlan->assigned_to) == $admin->id ? 'selected' : ''); ?>>
                                        <?php echo e($admin->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['assigned_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">وصف الخطة</label>
                    <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                              id="description" name="description" rows="3"><?php echo e(old('description', $companyPlan->description)); ?></textarea>
                    <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
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
                        <?php $__currentLoopData = old('objectives', $companyPlan->objectives); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $objective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" name="objectives[]" value="<?php echo e($objective); ?>" placeholder="أدخل الهدف" required>
                            <button type="button" class="btn btn-outline-danger" onclick="removeObjective(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                    <?php $__currentLoopData = old('strengths', $companyPlan->strengths); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $strength): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="strengths[]" value="<?php echo e($strength); ?>" placeholder="أدخل نقطة قوة" required>
                                        <button type="button" class="btn btn-outline-danger" onclick="removeStrength(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                    <?php $__currentLoopData = old('weaknesses', $companyPlan->weaknesses); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $weakness): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="weaknesses[]" value="<?php echo e($weakness); ?>" placeholder="أدخل نقطة ضعف" required>
                                        <button type="button" class="btn btn-outline-danger" onclick="removeWeakness(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                    <?php $__currentLoopData = old('opportunities', $companyPlan->opportunities); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $opportunity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="opportunities[]" value="<?php echo e($opportunity); ?>" placeholder="أدخل فرصة" required>
                                        <button type="button" class="btn btn-outline-danger" onclick="removeOpportunity(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                    <?php $__currentLoopData = old('threats', $companyPlan->threats); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $threat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="input-group mb-2">
                                        <input type="text" class="form-control" name="threats[]" value="<?php echo e($threat); ?>" placeholder="أدخل تهديد" required>
                                        <button type="button" class="btn btn-outline-danger" onclick="removeThreat(this)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                <?php $__currentLoopData = old('strategies', $companyPlan->strategies); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $strategy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="strategies[]" value="<?php echo e($strategy); ?>" placeholder="أدخل الاستراتيجية" required>
                                    <button type="button" class="btn btn-outline-danger" onclick="removeStrategy(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                <?php $__currentLoopData = old('action_items', $companyPlan->action_items); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $actionItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" name="action_items[]" value="<?php echo e($actionItem); ?>" placeholder="أدخل عنصر العمل" required>
                                    <button type="button" class="btn btn-outline-danger" onclick="removeActionItem(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <textarea class="form-control <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                              id="notes" name="notes" rows="3"><?php echo e(old('notes', $companyPlan->notes)); ?></textarea>
                    <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <div class="d-flex justify-content-between">
                    <a href="<?php echo e(route('admin.company-plans.show', $companyPlan)); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-right me-2"></i>
                        إلغاء
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        حفظ التغييرات
                    </button>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\company-plans\edit.blade.php ENDPATH**/ ?>