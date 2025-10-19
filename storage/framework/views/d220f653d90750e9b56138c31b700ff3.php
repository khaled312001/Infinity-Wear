

<?php $__env->startSection('title', 'تعديل المعاملة المالية'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة الإدارة'); ?>
<?php $__env->startSection('page-title', 'تعديل المعاملة المالية'); ?>
<?php $__env->startSection('page-subtitle', 'تعديل معاملة رقم ' . $transaction->id); ?>
<?php $__env->startSection('profile-route', '#'); ?>
<?php $__env->startSection('settings-route', '#'); ?>

<?php $__env->startSection('sidebar-menu'); ?>
    <?php echo $__env->make('partials.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-edit me-2 text-primary"></i>
                            تعديل المعاملة المالية
                        </h5>
                        <div>
                            <a href="<?php echo e(route('admin.finance.show', $transaction)); ?>" class="btn btn-outline-info me-2">
                                <i class="fas fa-eye me-2"></i>
                                عرض
                            </a>
                            <a href="<?php echo e(route('admin.finance.transactions')); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>
                                العودة
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.finance.update', $transaction)); ?>" method="POST" id="transactionForm">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        
                        <!-- نوع المعاملة -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <label class="form-label">نوع المعاملة <span class="text-danger">*</span></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check form-check-card">
                                            <input class="form-check-input" type="radio" name="type" id="income" value="income" 
                                                   <?php echo e($transaction->type === 'income' ? 'checked' : ''); ?> required>
                                            <label class="form-check-label" for="income">
                                                <div class="card border-success">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-arrow-up fa-2x text-success mb-2"></i>
                                                        <h6 class="card-title text-success">إيراد</h6>
                                                        <p class="card-text small text-muted">دخل أو مبيعات</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check form-check-card">
                                            <input class="form-check-input" type="radio" name="type" id="expense" value="expense" 
                                                   <?php echo e($transaction->type === 'expense' ? 'checked' : ''); ?> required>
                                            <label class="form-check-label" for="expense">
                                                <div class="card border-danger">
                                                    <div class="card-body text-center">
                                                        <i class="fas fa-arrow-down fa-2x text-danger mb-2"></i>
                                                        <h6 class="card-title text-danger">مصروف</h6>
                                                        <p class="card-text small text-muted">تكلفة أو نفقة</p>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- الفئة -->
                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">الفئة <span class="text-danger">*</span></label>
                                <select class="form-select" id="category" name="category" required>
                                    <option value="">اختر الفئة</option>
                                    <optgroup label="الإيرادات" id="income-categories" style="<?php echo e($transaction->type === 'income' ? '' : 'display: none;'); ?>">
                                        <?php $__currentLoopData = $incomeCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category); ?>" <?php echo e($transaction->category === $category ? 'selected' : ''); ?>>
                                                <?php echo e($category); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </optgroup>
                                    <optgroup label="المصروفات" id="expense-categories" style="<?php echo e($transaction->type === 'expense' ? '' : 'display: none;'); ?>">
                                        <?php $__currentLoopData = $expenseCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category); ?>" <?php echo e($transaction->category === $category ? 'selected' : ''); ?>>
                                                <?php echo e($category); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </optgroup>
                                </select>
                                <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- المبلغ -->
                            <div class="col-md-6 mb-3">
                                <label for="amount" class="form-label">المبلغ (ريال) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="amount" name="amount" 
                                           step="0.01" min="0.01" value="<?php echo e($transaction->amount); ?>" required>
                                    <span class="input-group-text">ريال</span>
                                </div>
                                <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- الوصف -->
                        <div class="mb-3">
                            <label for="description" class="form-label">الوصف <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="3" 
                                      placeholder="وصف تفصيلي للمعاملة" required><?php echo e($transaction->description); ?></textarea>
                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="row">
                            <!-- تاريخ المعاملة -->
                            <div class="col-md-6 mb-3">
                                <label for="transaction_date" class="form-label">تاريخ المعاملة <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="transaction_date" name="transaction_date" 
                                       value="<?php echo e($transaction->transaction_date->format('Y-m-d')); ?>" required>
                                <?php $__errorArgs = ['transaction_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- طريقة الدفع -->
                            <div class="col-md-6 mb-3">
                                <label for="payment_method" class="form-label">طريقة الدفع</label>
                                <select class="form-select" id="payment_method" name="payment_method">
                                    <option value="">اختر طريقة الدفع</option>
                                    <?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($method); ?>" <?php echo e($transaction->payment_method === $method ? 'selected' : ''); ?>>
                                            <?php echo e($method); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="row">
                            <!-- الحالة -->
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">الحالة <span class="text-danger">*</span></label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="completed" <?php echo e($transaction->status === 'completed' ? 'selected' : ''); ?>>مكتملة</option>
                                    <option value="pending" <?php echo e($transaction->status === 'pending' ? 'selected' : ''); ?>>معلقة</option>
                                    <option value="cancelled" <?php echo e($transaction->status === 'cancelled' ? 'selected' : ''); ?>>ملغية</option>
                                </select>
                                <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- المرجع -->
                            <div class="col-md-6 mb-3">
                                <label for="reference_type" class="form-label">نوع المرجع</label>
                                <select class="form-select" id="reference_type" name="reference_type">
                                    <option value="general" <?php echo e($transaction->reference_type === 'general' ? 'selected' : ''); ?>>عام</option>
                                    <option value="order" <?php echo e($transaction->reference_type === 'order' ? 'selected' : ''); ?>>طلب</option>
                                    <option value="invoice" <?php echo e($transaction->reference_type === 'invoice' ? 'selected' : ''); ?>>فاتورة</option>
                                    <option value="refund" <?php echo e($transaction->reference_type === 'refund' ? 'selected' : ''); ?>>استرداد</option>
                                </select>
                                <?php $__errorArgs = ['reference_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <!-- معرف المرجع -->
                        <?php if($transaction->reference_id): ?>
                        <div class="mb-3">
                            <label for="reference_id" class="form-label">معرف المرجع</label>
                            <input type="text" class="form-control" id="reference_id" name="reference_id" 
                                   value="<?php echo e($transaction->reference_id); ?>" placeholder="معرف المرجع">
                            <?php $__errorArgs = ['reference_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <?php endif; ?>

                        <!-- ملاحظات -->
                        <div class="mb-4">
                            <label for="notes" class="form-label">ملاحظات إضافية</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" 
                                      placeholder="أي ملاحظات إضافية حول المعاملة"><?php echo e($transaction->notes); ?></textarea>
                            <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- أزرار الإجراءات -->
                        <div class="d-flex justify-content-between">
                            <a href="<?php echo e(route('admin.finance.show', $transaction)); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>
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
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
.form-check-card {
    margin-bottom: 0;
}

.form-check-card .form-check-input {
    position: absolute;
    opacity: 0;
}

.form-check-card .form-check-input:checked + .form-check-label .card {
    border-width: 2px;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

.form-check-card .form-check-label {
    cursor: pointer;
    width: 100%;
}

.form-check-card .card {
    transition: all 0.3s ease;
    border: 2px solid #e9ecef;
}

.form-check-card .card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
}

.dashboard-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    border: none;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    padding: 1.5rem;
}

.card-body {
    padding: 2rem;
}

.form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border-radius: 10px;
    border: 2px solid #e5e7eb;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
}

.btn {
    border-radius: 10px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #1d4ed8);
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #1d4ed8, #1e40af);
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeRadios = document.querySelectorAll('input[name="type"]');
    const categorySelect = document.getElementById('category');
    const incomeCategories = document.getElementById('income-categories');
    const expenseCategories = document.getElementById('expense-categories');

    // تحديث الفئات عند تغيير نوع المعاملة
    typeRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'income') {
                incomeCategories.style.display = 'block';
                expenseCategories.style.display = 'none';
            } else if (this.value === 'expense') {
                incomeCategories.style.display = 'none';
                expenseCategories.style.display = 'block';
            }
        });
    });

    // تنسيق المبلغ
    const amountInput = document.getElementById('amount');
    amountInput.addEventListener('input', function() {
        let value = this.value;
        if (value && !isNaN(value)) {
            this.value = parseFloat(value).toFixed(2);
        }
    });

    // التحقق من صحة النموذج قبل الإرسال
    document.getElementById('transactionForm').addEventListener('submit', function(e) {
        const type = document.querySelector('input[name="type"]:checked');
        const category = document.getElementById('category').value;
        const amount = document.getElementById('amount').value;
        const description = document.getElementById('description').value;

        if (!type || !category || !amount || !description) {
            e.preventDefault();
            alert('يرجى ملء جميع الحقول المطلوبة');
            return false;
        }

        if (parseFloat(amount) <= 0) {
            e.preventDefault();
            alert('المبلغ يجب أن يكون أكبر من صفر');
            return false;
        }
    });

    // إضافة تأثيرات بصرية للأزرار
    document.querySelectorAll('.btn').forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\finance\edit.blade.php ENDPATH**/ ?>