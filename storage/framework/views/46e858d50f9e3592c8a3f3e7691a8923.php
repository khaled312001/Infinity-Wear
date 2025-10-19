

<?php $__env->startSection('title', 'طرق الدفع - لوحة تحكم المستورد'); ?>
<?php $__env->startSection('dashboard-title', 'لوحة المستورد'); ?>
<?php $__env->startSection('page-title', 'طرق الدفع'); ?>
<?php $__env->startSection('page-subtitle', 'إدارة طرق الدفع المفضلة لديك'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- معلومات الحساب البنكي -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-university me-2"></i>
                        معلومات الحساب البنكي
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="border rounded p-3 mb-3">
                                <h6 class="text-primary mb-3">تفاصيل الحساب</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <td><strong>اسم البنك:</strong></td>
                                        <td><?php echo e($bankAccount['bank_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>اسم الحساب:</strong></td>
                                        <td><?php echo e($bankAccount['account_name']); ?></td>
                                    </tr>
                                    <tr>
                                        <td><strong>رقم الحساب:</strong></td>
                                        <td>
                                            <code><?php echo e($bankAccount['account_number']); ?></code>
                                            <button class="btn btn-sm btn-outline-secondary ms-2" onclick="copyToClipboard('<?php echo e($bankAccount['account_number']); ?>')">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>رقم الآيبان:</strong></td>
                                        <td>
                                            <code><?php echo e($bankAccount['iban']); ?></code>
                                            <button class="btn btn-sm btn-outline-secondary ms-2" onclick="copyToClipboard('<?php echo e($bankAccount['iban']); ?>')">
                                                <i class="fas fa-copy"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>رمز السويفت:</strong></td>
                                        <td><code><?php echo e($bankAccount['swift_code']); ?></code></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="border rounded p-3 mb-3">
                                <h6 class="text-primary mb-3">تعليمات التحويل</h6>
                                <ol class="mb-0">
                                    <li>قم بالتحويل إلى الحساب المذكور أعلاه</li>
                                    <li>أدخل رقم الطلب في خانة المرجع</li>
                                    <li>احتفظ بإيصال التحويل</li>
                                    <li>أرسل الإيصال عبر الواتساب أو البريد الإلكتروني</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- طرق الدفع المتاحة -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-credit-card me-2"></i>
                        طرق الدفع المتاحة
                    </h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPaymentMethodModal">
                        <i class="fas fa-plus me-2"></i>
                        إضافة طريقة دفع
                    </button>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $method): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="card border-0 shadow-sm h-100">
                                    <div class="card-body d-flex flex-column">
                                        <div class="d-flex align-items-center mb-3">
                                            <div class="payment-method-icon me-3">
                                                <i class="<?php echo e($method['icon']); ?> fa-2x text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="card-title mb-1"><?php echo e($method['name']); ?></h6>
                                                <span class="badge bg-<?php echo e($method['status'] == 'active' ? 'success' : 'warning'); ?>">
                                                    <?php echo e($method['status'] == 'active' ? 'متاح' : 'متاح عند الطلب'); ?>

                                                </span>
                                            </div>
                                        </div>
                                        
                                        <p class="card-text text-muted mb-3"><?php echo e($method['description']); ?></p>
                                        
                                        <div class="mt-auto">
                                            <div class="row text-center mb-3">
                                                <div class="col-6">
                                                    <small class="text-muted d-block">وقت المعالجة</small>
                                                    <strong><?php echo e($method['processing_time']); ?></strong>
                                                </div>
                                                <div class="col-6">
                                                    <small class="text-muted d-block">الرسوم</small>
                                                    <strong class="<?php echo e($method['fees'] == 'مجاني' ? 'text-success' : 'text-warning'); ?>">
                                                        <?php echo e($method['fees']); ?>

                                                    </strong>
                                                </div>
                                            </div>
                                            
                                            <div class="d-grid gap-2">
                                                <?php if($method['status'] == 'active'): ?>
                                                    <button class="btn btn-outline-primary btn-sm" onclick="selectPaymentMethod('<?php echo e($method['id']); ?>')">
                                                        <i class="fas fa-check me-1"></i>
                                                        اختيار
                                                    </button>
                                                <?php else: ?>
                                                    <button class="btn btn-outline-secondary btn-sm" onclick="requestPaymentMethod('<?php echo e($method['id']); ?>')">
                                                        <i class="fas fa-envelope me-1"></i>
                                                        طلب التفعيل
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- طرق الدفع المحفوظة -->
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bookmark me-2"></i>
                        طرق الدفع المحفوظة
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="text-center py-5">
                        <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">لا توجد طرق دفع محفوظة</h5>
                        <p class="text-muted">قم بإضافة طرق دفع لتسهيل عملية الدفع في المستقبل</p>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPaymentMethodModal">
                            <i class="fas fa-plus me-2"></i>
                            إضافة طريقة دفع
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal إضافة طريقة دفع -->
<div class="modal fade" id="addPaymentMethodModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إضافة طريقة دفع جديدة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?php echo e(route('importers.payment-methods.add')); ?>">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="method_type" class="form-label">نوع طريقة الدفع <span class="text-danger">*</span></label>
                        <select class="form-select <?php $__errorArgs = ['method_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="method_type" name="method_type" required onchange="togglePaymentFields()">
                            <option value="">اختر طريقة الدفع</option>
                            <option value="credit_card">بطاقة ائتمان</option>
                            <option value="stc_pay">STC Pay</option>
                            <option value="apple_pay">Apple Pay</option>
                        </select>
                        <?php $__errorArgs = ['method_type'];
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
                    
                    <!-- حقول بطاقة الائتمان -->
                    <div id="credit_card_fields" style="display: none;">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="card_number" class="form-label">رقم البطاقة <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['card_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="card_number" name="card_number" placeholder="1234 5678 9012 3456">
                                    <?php $__errorArgs = ['card_number'];
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
                                    <label for="cvv" class="form-label">CVV <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['cvv'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="cvv" name="cvv" placeholder="123" maxlength="4">
                                    <?php $__errorArgs = ['cvv'];
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
                                    <label for="expiry_date" class="form-label">تاريخ الانتهاء <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['expiry_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="expiry_date" name="expiry_date" placeholder="MM/YY">
                                    <?php $__errorArgs = ['expiry_date'];
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
                                    <label for="cardholder_name" class="form-label">اسم حامل البطاقة <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control <?php $__errorArgs = ['cardholder_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="cardholder_name" name="cardholder_name" placeholder="الاسم كما هو مكتوب على البطاقة">
                                    <?php $__errorArgs = ['cardholder_name'];
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
                    </div>
                    
                    <!-- حقول STC Pay -->
                    <div id="stc_pay_fields" style="display: none;">
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">رقم الهاتف <span class="text-danger">*</span></label>
                            <input type="text" class="form-control <?php $__errorArgs = ['phone_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="phone_number" name="phone_number" placeholder="05xxxxxxxx">
                            <?php $__errorArgs = ['phone_number'];
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
                    
                    <!-- Apple Pay -->
                    <div id="apple_pay_fields" style="display: none;">
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            سيتم ربط حسابك بـ Apple Pay تلقائياً عند تأكيد الطلب
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_default" name="is_default" value="1">
                            <label class="form-check-label" for="is_default">
                                جعل هذه الطريقة الافتراضية للدفع
                            </label>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning">
                        <i class="fas fa-shield-alt me-2"></i>
                        <strong>أمان البيانات:</strong> جميع بيانات الدفع محمية بتشفير SSL وتخزن بأمان
                    </div>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>
                        حفظ طريقة الدفع
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.payment-method-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #007bff, #0056b3);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

code {
    background-color: #f8f9fa;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 0.9em;
}
</style>

<script>
function togglePaymentFields() {
    const methodType = document.getElementById('method_type').value;
    
    // إخفاء جميع الحقول
    document.getElementById('credit_card_fields').style.display = 'none';
    document.getElementById('stc_pay_fields').style.display = 'none';
    document.getElementById('apple_pay_fields').style.display = 'none';
    
    // إظهار الحقول المناسبة
    if (methodType === 'credit_card') {
        document.getElementById('credit_card_fields').style.display = 'block';
    } else if (methodType === 'stc_pay') {
        document.getElementById('stc_pay_fields').style.display = 'block';
    } else if (methodType === 'apple_pay') {
        document.getElementById('apple_pay_fields').style.display = 'block';
    }
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // إظهار رسالة نجاح
        const button = event.target.closest('button');
        const originalIcon = button.innerHTML;
        button.innerHTML = '<i class="fas fa-check"></i>';
        button.classList.add('btn-success');
        button.classList.remove('btn-outline-secondary');
        
        setTimeout(function() {
            button.innerHTML = originalIcon;
            button.classList.remove('btn-success');
            button.classList.add('btn-outline-secondary');
        }, 2000);
    });
}

function selectPaymentMethod(methodId) {
    alert('تم اختيار طريقة الدفع: ' + methodId);
    // يمكن إضافة منطق اختيار طريقة الدفع
}

function requestPaymentMethod(methodId) {
    alert('تم إرسال طلب تفعيل طريقة الدفع: ' + methodId);
    // يمكن إضافة منطق طلب التفعيل
}

// تنسيق رقم البطاقة
document.getElementById('card_number').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
    let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
    e.target.value = formattedValue;
});

// تنسيق تاريخ الانتهاء
document.getElementById('expiry_date').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.length >= 2) {
        value = value.substring(0, 2) + '/' + value.substring(2, 4);
    }
    e.target.value = value;
});

// تنسيق رقم الهاتف
document.getElementById('phone_number').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    if (value.startsWith('966')) {
        value = value.substring(3);
    }
    if (value.startsWith('0')) {
        value = value.substring(1);
    }
    e.target.value = value;
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\importers\payment-methods.blade.php ENDPATH**/ ?>