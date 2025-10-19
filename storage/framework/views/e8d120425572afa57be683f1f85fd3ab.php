<?php $__env->startSection('title', 'إدارة SEO - Infinity Wear Admin'); ?>

<?php $__env->startSection('styles'); ?>
<style>
    .seo-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        margin-bottom: 30px;
        border-left: 4px solid var(--primary-color);
    }

    .seo-preview {
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 20px;
        margin-top: 15px;
    }

    .seo-preview-title {
        color: #1a73e8;
        font-size: 18px;
        font-weight: 500;
        margin-bottom: 5px;
        text-decoration: none;
    }

    .seo-preview-url {
        color: #006621;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .seo-preview-description {
        color: #4d5156;
        font-size: 14px;
        line-height: 1.4;
    }

    .char-counter {
        font-size: 12px;
        color: #6b7280;
        margin-top: 5px;
    }

    .char-counter.warning {
        color: #f59e0b;
    }

    .char-counter.danger {
        color: #ef4444;
    }

    .analytics-card {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 30px;
    }

    .analytics-icon {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-bottom: 15px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-label {
        font-weight: 600;
        color: var(--primary-color);
        margin-bottom: 8px;
        display: block;
    }

    .form-control {
        border: 2px solid #e5e7eb;
        border-radius: 10px;
        padding: 12px 15px;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(30, 58, 138, 0.1);
    }

    .btn-seo {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        border-radius: 10px;
        padding: 12px 25px;
        color: white;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-seo:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(30, 58, 138, 0.3);
        color: white;
    }

    .seo-score {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        font-size: 24px;
        font-weight: bold;
        color: white;
        margin: 0 auto 15px;
    }

    .seo-score.excellent {
        background: linear-gradient(135deg, #10b981, #34d399);
    }

    .seo-score.good {
        background: linear-gradient(135deg, #3b82f6, #60a5fa);
    }

    .seo-score.fair {
        background: linear-gradient(135deg, #f59e0b, #fbbf24);
    }

    .seo-score.poor {
        background: linear-gradient(135deg, #ef4444, #f87171);
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-search me-3 text-primary"></i>
                        إدارة تحسين محركات البحث (SEO)
                    </h1>
                    <p class="text-muted mb-0">تحسين ظهور موقعك في نتائج البحث</p>
                </div>
                <div>
                    <button class="btn btn-outline-primary me-2" onclick="generateSitemap()">
                        <i class="fas fa-sitemap me-2"></i>
                        إنشاء خريطة الموقع
                    </button>
                    <button class="btn btn-outline-secondary" onclick="clearCache()">
                        <i class="fas fa-trash me-2"></i>
                        مسح الكاش
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- نتيجة SEO -->
    <div class="row mb-4">
        <div class="col-lg-3">
            <div class="seo-card text-center">
                <div class="seo-score excellent">
                    85
                </div>
                <h5>نتيجة SEO</h5>
                <p class="text-muted mb-0">ممتاز - موقعك محسن بشكل جيد</p>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="analytics-card">
                <div class="row align-items-center">
                    <div class="col-md-2">
                        <div class="analytics-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <h4 class="mb-2">Google Analytics & Search Console</h4>
                        <p class="mb-3 opacity-90">ربط موقعك بأدوات Google لتتبع الأداء والزيارات</p>
                        <div class="row">
                            <div class="col-md-6">
                                <small class="opacity-75">الزيارات الشهرية</small>
                                <div class="h5">12,450</div>
                            </div>
                            <div class="col-md-6">
                                <small class="opacity-75">الكلمات المفتاحية</small>
                                <div class="h5">847</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- نموذج إعدادات SEO -->
    <form action="<?php echo e(route('admin.content.seo.update')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="row">
            <!-- الإعدادات العامة -->
            <div class="col-lg-8">
                <div class="seo-card">
                    <h5 class="mb-4">
                        <i class="fas fa-globe me-2 text-primary"></i>
                        الإعدادات العامة للموقع
                    </h5>

                    <div class="form-group">
                        <label class="form-label">عنوان الموقع الرئيسي</label>
                        <input type="text" class="form-control" name="site_title" 
                               value="<?php echo e($seoData['site_title'] ?? ''); ?>" 
                               maxlength="60" 
                               onkeyup="updateCharCount(this, 'title-count', 60)">
                        <div class="char-counter" id="title-count"></div>
                        <div class="seo-preview">
                            <div class="seo-preview-title" id="title-preview"><?php echo e($seoData['site_title'] ?? 'Infinity Wear - مؤسسة الزي اللامحدود'); ?></div>
                            <div class="seo-preview-url">https://infinitywear.sa</div>
                            <div class="seo-preview-description" id="description-preview"><?php echo e($seoData['site_description'] ?? 'مؤسسة متخصصة في توريد الملابس الرياضية...'); ?></div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">وصف الموقع الرئيسي</label>
                        <textarea class="form-control" name="site_description" rows="3" 
                                  maxlength="160" 
                                  onkeyup="updateCharCount(this, 'desc-count', 160); updatePreview()"><?php echo e($seoData['site_description'] ?? ''); ?></textarea>
                        <div class="char-counter" id="desc-count"></div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">الكلمات المفتاحية الرئيسية</label>
                        <textarea class="form-control" name="site_keywords" rows="2" 
                                  placeholder="ملابس رياضية، زي موحد، أكاديميات رياضية، السعودية"><?php echo e($seoData['site_keywords'] ?? ''); ?></textarea>
                        <small class="text-muted">افصل بين الكلمات بفاصلة</small>
                    </div>
                </div>

                <!-- إعدادات الصفحات -->
                <div class="seo-card">
                    <h5 class="mb-4">
                        <i class="fas fa-file-alt me-2 text-primary"></i>
                        إعدادات الصفحات الفردية
                    </h5>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">الصفحة الرئيسية - العنوان</label>
                                <input type="text" class="form-control" name="home_title" 
                                       value="<?php echo e($seoData['home_title'] ?? ''); ?>" maxlength="60">
                            </div>
                            <div class="form-group">
                                <label class="form-label">الصفحة الرئيسية - الوصف</label>
                                <textarea class="form-control" name="home_description" rows="2" 
                                          maxlength="160"><?php echo e($seoData['home_description'] ?? ''); ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">من نحن - العنوان</label>
                                <input type="text" class="form-control" name="about_title" 
                                       value="<?php echo e($seoData['about_title'] ?? ''); ?>" maxlength="60">
                            </div>
                            <div class="form-group">
                                <label class="form-label">من نحن - الوصف</label>
                                <textarea class="form-control" name="about_description" rows="2" 
                                          maxlength="160"><?php echo e($seoData['about_description'] ?? ''); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">خدماتنا - العنوان</label>
                                <input type="text" class="form-control" name="services_title" 
                                       value="<?php echo e($seoData['services_title'] ?? ''); ?>" maxlength="60">
                            </div>
                            <div class="form-group">
                                <label class="form-label">خدماتنا - الوصف</label>
                                <textarea class="form-control" name="services_description" rows="2" 
                                          maxlength="160"><?php echo e($seoData['services_description'] ?? ''); ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">اتصل بنا - العنوان</label>
                                <input type="text" class="form-control" name="contact_title" 
                                       value="<?php echo e($seoData['contact_title'] ?? ''); ?>" maxlength="60">
                            </div>
                            <div class="form-group">
                                <label class="form-label">اتصل بنا - الوصف</label>
                                <textarea class="form-control" name="contact_description" rows="2" 
                                          maxlength="160"><?php echo e($seoData['contact_description'] ?? ''); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">معرض الأعمال - العنوان</label>
                                <input type="text" class="form-control" name="portfolio_title" 
                                       value="<?php echo e($seoData['portfolio_title'] ?? ''); ?>" maxlength="60">
                            </div>
                            <div class="form-group">
                                <label class="form-label">معرض الأعمال - الوصف</label>
                                <textarea class="form-control" name="portfolio_description" rows="2" 
                                          maxlength="160"><?php echo e($seoData['portfolio_description'] ?? ''); ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- أدوات التتبع -->
            <div class="col-lg-4">
                <div class="seo-card">
                    <h5 class="mb-4">
                        <i class="fas fa-chart-pie me-2 text-primary"></i>
                        أدوات التتبع والتحليل
                    </h5>

                    <div class="form-group">
                        <label class="form-label">Google Analytics ID</label>
                        <input type="text" class="form-control" name="google_analytics_id" 
                               value="<?php echo e($seoData['google_analytics_id'] ?? ''); ?>" 
                               placeholder="G-XXXXXXXXXX">
                        <small class="text-muted">معرف Google Analytics 4</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Facebook Pixel ID</label>
                        <input type="text" class="form-control" name="facebook_pixel_id" 
                               value="<?php echo e($seoData['facebook_pixel_id'] ?? ''); ?>" 
                               placeholder="123456789012345">
                        <small class="text-muted">معرف Facebook Pixel</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Google Site Verification</label>
                        <input type="text" class="form-control" name="google_site_verification" 
                               value="<?php echo e($seoData['google_site_verification'] ?? ''); ?>" 
                               placeholder="verification-code">
                        <small class="text-muted">رمز التحقق من Google Search Console</small>
                    </div>
                </div>

                <!-- نصائح SEO -->
                <div class="seo-card">
                    <h5 class="mb-4">
                        <i class="fas fa-lightbulb me-2 text-warning"></i>
                        نصائح لتحسين SEO
                    </h5>

                    <div class="mb-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <small>استخدم عناوين وصفية (50-60 حرف)</small>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <small>اكتب أوصاف جذابة (150-160 حرف)</small>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                            <small>استخدم كلمات مفتاحية ذات صلة</small>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <i class="fas fa-clock text-info me-2"></i>
                            <small>حدث المحتوى بانتظام</small>
                        </div>
                    </div>
                </div>

                <!-- حفظ الإعدادات -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-seo">
                        <i class="fas fa-save me-2"></i>
                        حفظ إعدادات SEO
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    // تحديث عداد الأحرف
    function updateCharCount(input, counterId, maxLength) {
        const counter = document.getElementById(counterId);
        const currentLength = input.value.length;
        const remaining = maxLength - currentLength;
        
        counter.textContent = `${currentLength}/${maxLength} حرف`;
        
        if (remaining < 10) {
            counter.className = 'char-counter danger';
        } else if (remaining < 20) {
            counter.className = 'char-counter warning';
        } else {
            counter.className = 'char-counter';
        }
        
        if (input.name === 'site_title') {
            updatePreview();
        }
    }

    // تحديث معاينة البحث
    function updatePreview() {
        const title = document.querySelector('input[name="site_title"]').value;
        const description = document.querySelector('textarea[name="site_description"]').value;
        
        document.getElementById('title-preview').textContent = title || 'Infinity Wear - مؤسسة الزي اللامحدود';
        document.getElementById('description-preview').textContent = description || 'مؤسسة متخصصة في توريد الملابس الرياضية والزي الموحد للأكاديميات الرياضية في المملكة العربية السعودية';
    }

    // إنشاء خريطة الموقع
    function generateSitemap() {
        fetch('/admin/content/generate-sitemap', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('تم إنشاء خريطة الموقع بنجاح!');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ في إنشاء خريطة الموقع');
        });
    }

    // مسح الكاش
    function clearCache() {
        if (confirm('هل تريد مسح جميع ملفات الكاش؟')) {
            fetch('/admin/content/clear-cache', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('تم مسح الكاش بنجاح!');
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('حدث خطأ في مسح الكاش');
            });
        }
    }

    // تهيئة عدادات الأحرف
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.querySelector('input[name="site_title"]');
        const descInput = document.querySelector('textarea[name="site_description"]');
        
        if (titleInput) {
            updateCharCount(titleInput, 'title-count', 60);
        }
        
        if (descInput) {
            updateCharCount(descInput, 'desc-count', 160);
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\content\seo.blade.php ENDPATH**/ ?>