@extends('layouts.dashboard')

@section('title', 'الإعدادات')
@section('dashboard-title', 'لوحة العميل')
@section('page-title', 'الإعدادات')
@section('page-subtitle', 'إدارة إعدادات حسابك وتفضيلاتك')
@section('profile-route', route('customer.profile'))
@section('settings-route', route('customer.settings'))

@section('sidebar-menu')
    <a href="{{ route('customer.dashboard') }}" class="nav-link">
        <i class="fas fa-tachometer-alt me-2"></i>
        الرئيسية
    </a>
    <a href="{{ route('customer.orders') }}" class="nav-link">
        <i class="fas fa-shopping-cart me-2"></i>
        طلباتي
    </a>
    <a href="{{ route('customer.designs') }}" class="nav-link">
        <i class="fas fa-palette me-2"></i>
        تصاميمي
    </a>
    <a href="{{ route('products.index') }}" class="nav-link">
        <i class="fas fa-tshirt me-2"></i>
        المنتجات
    </a>
    <a href="{{ route('custom-designs.create') }}" class="nav-link">
        <i class="fas fa-plus me-2"></i>
        تصميم جديد
    </a>
    <a href="{{ route('customer.profile') }}" class="nav-link">
        <i class="fas fa-user me-2"></i>
        الملف الشخصي
    </a>
    <a href="{{ route('customer.settings') }}" class="nav-link active">
        <i class="fas fa-cog me-2"></i>
        الإعدادات
    </a>
@endsection

@section('content')
    <div class="row g-4">
        <!-- Notification Settings -->
        <div class="col-lg-6">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-bell me-2 text-warning"></i>
                        إعدادات الإشعارات
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('customer.settings.notifications') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <h6 class="mb-3">إشعارات البريد الإلكتروني</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="email_orders" name="email_orders" checked>
                                <label class="form-check-label" for="email_orders">
                                    تحديثات الطلبات
                                    <small class="text-muted d-block">تلقي إشعارات عن حالة طلباتك</small>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="email_designs" name="email_designs" checked>
                                <label class="form-check-label" for="email_designs">
                                    تحديثات التصاميم
                                    <small class="text-muted d-block">تلقي إشعارات عن تصاميمك المخصصة</small>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="email_promotions" name="email_promotions">
                                <label class="form-check-label" for="email_promotions">
                                    العروض والخصومات
                                    <small class="text-muted d-block">تلقي إشعارات عن العروض الخاصة</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="email_newsletter" name="email_newsletter">
                                <label class="form-check-label" for="email_newsletter">
                                    النشرة الإخبارية
                                    <small class="text-muted d-block">تلقي أخبار المنتجات الجديدة</small>
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="mb-3">إشعارات الرسائل النصية</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="sms_orders" name="sms_orders">
                                <label class="form-check-label" for="sms_orders">
                                    تحديثات الطلبات
                                    <small class="text-muted d-block">تلقي رسائل نصية عن حالة طلباتك</small>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="sms_important" name="sms_important">
                                <label class="form-check-label" for="sms_important">
                                    الإشعارات المهمة فقط
                                    <small class="text-muted d-block">تلقي رسائل نصية للإشعارات المهمة فقط</small>
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>
                                حفظ الإعدادات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Privacy Settings -->
        <div class="col-lg-6">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-shield-alt me-2 text-success"></i>
                        إعدادات الخصوصية
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('customer.settings.privacy') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <h6 class="mb-3">مشاركة المعلومات</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="share_designs" name="share_designs">
                                <label class="form-check-label" for="share_designs">
                                    عرض تصاميمي في المعرض
                                    <small class="text-muted d-block">السماح بعرض تصاميمك في معرض الأعمال</small>
                                </label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="show_name" name="show_name">
                                <label class="form-check-label" for="show_name">
                                    عرض اسمي مع التصاميم
                                    <small class="text-muted d-block">عرض اسمك مع التصاميم المشتركة</small>
                                </label>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6 class="mb-3">إعدادات البيانات</h6>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" id="analytics" name="analytics" checked>
                                <label class="form-check-label" for="analytics">
                                    تحسين الخدمة
                                    <small class="text-muted d-block">السماح بجمع بيانات لتحسين الخدمة</small>
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-2"></i>
                                حفظ الإعدادات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Account Actions -->
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">
                        <i class="fas fa-exclamation-triangle me-2 text-danger"></i>
                        إجراءات الحساب
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="border rounded p-3">
                                <h6 class="text-warning mb-2">
                                    <i class="fas fa-download me-2"></i>
                                    تحميل بياناتي
                                </h6>
                                <p class="text-muted mb-3">احصل على نسخة من جميع بياناتك المخزنة في حسابك</p>
                                <button type="button" class="btn btn-outline-warning" onclick="downloadData()">
                                    <i class="fas fa-download me-2"></i>
                                    تحميل البيانات
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="border rounded p-3">
                                <h6 class="text-danger mb-2">
                                    <i class="fas fa-trash me-2"></i>
                                    حذف الحساب
                                </h6>
                                <p class="text-muted mb-3">حذف حسابك نهائياً مع جميع البيانات المرتبطة به</p>
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                    <i class="fas fa-trash me-2"></i>
                                    حذف الحساب
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="deleteAccountModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        تأكيد حذف الحساب
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <h6><i class="fas fa-warning me-2"></i>تحذير مهم!</h6>
                        <p class="mb-0">هذا الإجراء لا يمكن التراجع عنه. سيتم حذف:</p>
                        <ul class="mt-2 mb-0">
                            <li>جميع معلوماتك الشخصية</li>
                            <li>جميع طلباتك وتصاميمك</li>
                            <li>سجل المراسلات</li>
                            <li>جميع البيانات المرتبطة بحسابك</li>
                        </ul>
                    </div>
                    
                    <form method="POST" action="{{ route('customer.account.delete') }}" id="deleteAccountForm">
                        @csrf
                        @method('DELETE')
                        
                        <div class="mb-3">
                            <label for="delete_password" class="form-label">أدخل كلمة المرور للتأكيد</label>
                            <input type="password" class="form-control" id="delete_password" name="password" required>
                        </div>
                        
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="confirm_delete" required>
                            <label class="form-check-label" for="confirm_delete">
                                أؤكد أنني أريد حذف حسابي نهائياً
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" form="deleteAccountForm" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>
                        حذف الحساب نهائياً
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function downloadData() {
            // Here you would typically send a request to generate and download user data
            alert('سيتم إضافة وظيفة تحميل البيانات قريباً');
        }

        // Delete account form validation
        document.getElementById('deleteAccountForm').addEventListener('submit', function(e) {
            const password = document.getElementById('delete_password').value;
            const confirm = document.getElementById('confirm_delete').checked;
            
            if (!password || !confirm) {
                e.preventDefault();
                alert('يرجى إدخال كلمة المرور والتأكيد على الحذف');
                return;
            }
            
            if (!confirm('هل أنت متأكد من حذف حسابك نهائياً؟ لا يمكن التراجع عن هذا الإجراء!')) {
                e.preventDefault();
            }
        });

        // Settings form auto-save indication
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري الحفظ...';
                submitBtn.disabled = true;
                
                // Re-enable after 2 seconds (in real app, this would be handled by the response)
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 2000);
            });
        });
    </script>
@endpush