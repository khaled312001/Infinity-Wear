/**
 * ملف اختبار شامل للنموذج - Infinity Wear
 * يمكن تشغيله في صفحة الموقع الفعلية
 */

// إعدادات الاختبار
const FormTester = {
    config: {
        baseUrl: 'https://infinitywearsa.com/importers/register',
        timeout: 10000,
        retries: 3,
        debug: true
    },
    
    results: {
        total: 0,
        passed: 0,
        failed: 0,
        skipped: 0,
        tests: []
    },
    
    // تسجيل النتائج
    log: function(message, type = 'info') {
        const timestamp = new Date().toLocaleTimeString();
        const icon = type === 'success' ? '✅' : 
                    type === 'error' ? '❌' : 
                    type === 'warning' ? '⚠️' : 'ℹ️';
        
        console.log(`${icon} [${timestamp}] ${message}`);
        
        if (this.config.debug) {
            // إضافة للصفحة إذا كان هناك عنصر للنتائج
            const resultsContainer = document.getElementById('test-results');
            if (resultsContainer) {
                const logEntry = document.createElement('div');
                logEntry.className = `log-entry log-${type}`;
                logEntry.innerHTML = `${icon} [${timestamp}] ${message}`;
                resultsContainer.appendChild(logEntry);
            }
        }
    },
    
    // تشغيل اختبار واحد
    runTest: async function(testName, testFunction) {
        this.log(`بدء اختبار: ${testName}`, 'info');
        
        try {
            const result = await testFunction();
            
            if (result.success) {
                this.log(`نجح: ${testName}`, 'success');
                this.results.passed++;
            } else {
                this.log(`فشل: ${testName} - ${result.error}`, 'error');
                this.results.failed++;
            }
            
            this.results.total++;
            this.results.tests.push({
                name: testName,
                success: result.success,
                error: result.error,
                timestamp: new Date()
            });
            
            return result;
            
        } catch (error) {
            this.log(`خطأ في اختبار: ${testName} - ${error.message}`, 'error');
            this.results.failed++;
            this.results.total++;
            this.results.tests.push({
                name: testName,
                success: false,
                error: error.message,
                timestamp: new Date()
            });
            
            return { success: false, error: error.message };
        }
    },
    
    // اختبار تحميل الصفحة
    testPageLoad: async function() {
        try {
            const response = await fetch(this.config.baseUrl);
            return { 
                success: response.ok, 
                error: response.ok ? null : `HTTP ${response.status}` 
            };
        } catch (error) {
            return { success: false, error: error.message };
        }
    },
    
    // اختبار هيكل النموذج
    testFormStructure: async function() {
        const requiredElements = [
            'registrationForm',
            'quantity',
            'design_option',
            'business_type',
            'company_name',
            'city',
            'name',
            'email',
            'phone'
        ];
        
        const missingElements = [];
        
        requiredElements.forEach(id => {
            const element = document.getElementById(id);
            if (!element) {
                missingElements.push(id);
            }
        });
        
        return {
            success: missingElements.length === 0,
            error: missingElements.length > 0 ? `عناصر مفقودة: ${missingElements.join(', ')}` : null
        };
    },
    
    // اختبار التنقل بين المراحل
    testStepNavigation: async function() {
        try {
            // التحقق من وجود أزرار التنقل
            const nextButtons = document.querySelectorAll('[id*="nextBtn"], .btn-next');
            const prevButtons = document.querySelectorAll('[id*="prevBtn"], .btn-prev');
            
            if (nextButtons.length === 0 && prevButtons.length === 0) {
                return { success: false, error: 'لم يتم العثور على أزرار التنقل' };
            }
            
            // اختبار التنقل للمرحلة التالية
            const firstNextButton = nextButtons[0];
            if (firstNextButton) {
                firstNextButton.click();
                await new Promise(resolve => setTimeout(resolve, 500));
            }
            
            return { success: true, error: null };
            
        } catch (error) {
            return { success: false, error: error.message };
        }
    },
    
    // اختبار حقل الكمية
    testQuantityInput: async function() {
        const quantityInput = document.getElementById('quantity');
        if (!quantityInput) {
            return { success: false, error: 'حقل الكمية غير موجود' };
        }
        
        // اختبار إدخال قيمة صحيحة
        quantityInput.value = '100';
        quantityInput.dispatchEvent(new Event('input', { bubbles: true }));
        
        if (quantityInput.value !== '100') {
            return { success: false, error: 'فشل في إدخال قيمة الكمية' };
        }
        
        // اختبار إدخال قيمة غير صحيحة
        quantityInput.value = '-5';
        quantityInput.dispatchEvent(new Event('input', { bubbles: true }));
        
        return { success: true, error: null };
    },
    
    // اختبار خيارات التصميم
    testDesignOptions: async function() {
        const designOptions = document.querySelectorAll('input[name="design_option"]');
        if (designOptions.length === 0) {
            return { success: false, error: 'خيارات التصميم غير موجودة' };
        }
        
        // اختبار كل خيار
        for (let i = 0; i < designOptions.length; i++) {
            const option = designOptions[i];
            option.checked = true;
            option.dispatchEvent(new Event('change', { bubbles: true }));
            
            await new Promise(resolve => setTimeout(resolve, 200));
            
            if (!option.checked) {
                return { success: false, error: `فشل في اختيار خيار التصميم ${i + 1}` };
            }
            
            option.checked = false;
        }
        
        return { success: true, error: null };
    },
    
    // اختبار واجهة التصميم المخصص
    testCustomDesignInterface: async function() {
        const customOption = document.querySelector('input[value="custom"]');
        if (!customOption) {
            return { success: false, error: 'خيار التصميم المخصص غير موجود' };
        }
        
        customOption.checked = true;
        customOption.dispatchEvent(new Event('change', { bubbles: true }));
        
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        // التحقق من ظهور واجهة التصميم
        const customInterface = document.querySelector('.custom-design-interface');
        if (!customInterface || customInterface.style.display === 'none') {
            return { success: false, error: 'واجهة التصميم المخصص لم تظهر' };
        }
        
        // اختبار اختيار قطع الملابس
        const clothingPieces = document.querySelectorAll('input[name="clothing_pieces[]"]');
        if (clothingPieces.length === 0) {
            return { success: false, error: 'قطع الملابس غير موجودة' };
        }
        
        // اختيار قطعة واحدة على الأقل
        clothingPieces[0].checked = true;
        clothingPieces[0].dispatchEvent(new Event('change', { bubbles: true }));
        
        return { success: true, error: null };
    },
    
    // اختبار نوع النشاط
    testBusinessType: async function() {
        const businessTypeSelect = document.getElementById('business_type');
        if (!businessTypeSelect) {
            return { success: false, error: 'قائمة نوع النشاط غير موجودة' };
        }
        
        // اختبار اختيار كل خيار
        const options = businessTypeSelect.querySelectorAll('option');
        for (let i = 1; i < options.length; i++) { // تخطي الخيار الفارغ
            businessTypeSelect.value = options[i].value;
            businessTypeSelect.dispatchEvent(new Event('change', { bubbles: true }));
            
            if (businessTypeSelect.value !== options[i].value) {
                return { success: false, error: `فشل في اختيار نوع النشاط: ${options[i].value}` };
            }
        }
        
        return { success: true, error: null };
    },
    
    // اختبار معلومات الشركة
    testCompanyInfo: async function() {
        const companyName = document.getElementById('company_name');
        const city = document.getElementById('city');
        
        if (!companyName || !city) {
            return { success: false, error: 'حقول معلومات الشركة غير موجودة' };
        }
        
        // اختبار إدخال البيانات
        companyName.value = 'شركة اختبار';
        companyName.dispatchEvent(new Event('input', { bubbles: true }));
        
        city.value = 'الرياض';
        city.dispatchEvent(new Event('input', { bubbles: true }));
        
        if (companyName.value !== 'شركة اختبار' || city.value !== 'الرياض') {
            return { success: false, error: 'فشل في إدخال معلومات الشركة' };
        }
        
        return { success: true, error: null };
    },
    
    // اختبار المعلومات الشخصية
    testPersonalInfo: async function() {
        const name = document.getElementById('name');
        const email = document.getElementById('email');
        const phone = document.getElementById('phone');
        
        if (!name || !email || !phone) {
            return { success: false, error: 'حقول المعلومات الشخصية غير موجودة' };
        }
        
        // اختبار إدخال البيانات
        name.value = 'أحمد محمد';
        name.dispatchEvent(new Event('input', { bubbles: true }));
        
        email.value = 'test@example.com';
        email.dispatchEvent(new Event('input', { bubbles: true }));
        
        phone.value = '0501234567';
        phone.dispatchEvent(new Event('input', { bubbles: true }));
        
        if (name.value !== 'أحمد محمد' || email.value !== 'test@example.com' || phone.value !== '0501234567') {
            return { success: false, error: 'فشل في إدخال المعلومات الشخصية' };
        }
        
        return { success: true, error: null };
    },
    
    // اختبار التحقق من صحة البيانات
    testFormValidation: async function() {
        // اختبار الحقول المطلوبة
        const requiredFields = [
            { id: 'quantity', value: '' },
            { id: 'business_type', value: '' },
            { id: 'company_name', value: '' },
            { id: 'city', value: '' },
            { id: 'name', value: '' },
            { id: 'email', value: '' },
            { id: 'phone', value: '' }
        ];
        
        for (const field of requiredFields) {
            const element = document.getElementById(field.id);
            if (element) {
                element.value = field.value;
                element.dispatchEvent(new Event('input', { bubbles: true }));
            }
        }
        
        // محاولة الانتقال للمرحلة التالية
        const nextButton = document.querySelector('[id*="nextBtn"], .btn-next');
        if (nextButton) {
            nextButton.click();
            await new Promise(resolve => setTimeout(resolve, 500));
            
            // التحقق من وجود رسائل خطأ
            const errorMessages = document.querySelectorAll('.is-invalid, .invalid-feedback');
            if (errorMessages.length === 0) {
                return { success: false, error: 'لم تظهر رسائل خطأ للحقول المطلوبة' };
            }
        }
        
        return { success: true, error: null };
    },
    
    // اختبار عرض الملخص
    testSummaryDisplay: async function() {
        // الانتقال للمرحلة الرابعة
        const step4Button = document.querySelector('[data-step="4"], .step-4');
        if (step4Button) {
            step4Button.click();
            await new Promise(resolve => setTimeout(resolve, 1000));
        }
        
        // التحقق من وجود عناصر الملخص
        const summaryElements = [
            'summary_quantity',
            'summary_design_option',
            'summary_company',
            'summary_business_type',
            'summary_city',
            'summary_name',
            'summary_email',
            'summary_phone'
        ];
        
        const missingElements = [];
        summaryElements.forEach(id => {
            const element = document.getElementById(id);
            if (!element) {
                missingElements.push(id);
            }
        });
        
        return {
            success: missingElements.length === 0,
            error: missingElements.length > 0 ? `عناصر الملخص مفقودة: ${missingElements.join(', ')}` : null
        };
    },
    
    // اختبار إرسال النموذج
    testFormSubmission: async function() {
        const form = document.getElementById('registrationForm');
        if (!form) {
            return { success: false, error: 'النموذج غير موجود' };
        }
        
        // ملء النموذج بالبيانات المطلوبة
        const testData = {
            quantity: '100',
            design_option: 'text',
            business_type: 'company',
            company_name: 'شركة اختبار',
            city: 'الرياض',
            name: 'أحمد محمد',
            email: 'test@example.com',
            phone: '0501234567'
        };
        
        Object.keys(testData).forEach(key => {
            const element = document.getElementById(key) || document.querySelector(`[name="${key}"]`);
            if (element) {
                if (element.type === 'radio') {
                    const radio = document.querySelector(`[name="${key}"][value="${testData[key]}"]`);
                    if (radio) radio.checked = true;
                } else {
                    element.value = testData[key];
                }
                element.dispatchEvent(new Event('input', { bubbles: true }));
            }
        });
        
        // محاولة الإرسال (بدون إرسال فعلي)
        const submitEvent = new Event('submit', { bubbles: true, cancelable: true });
        const prevented = !form.dispatchEvent(submitEvent);
        
        return { success: true, error: null };
    },
    
    // اختبار إعادة تعيين النموذج
    testFormReset: async function() {
        // التحقق من وجود دالة إعادة التعيين
        if (typeof window.multiStepForm !== 'undefined' && window.multiStepForm.resetForm) {
            try {
                window.multiStepForm.resetForm();
                await new Promise(resolve => setTimeout(resolve, 1000));
                
                // التحقق من إعادة التعيين
                const quantity = document.getElementById('quantity');
                if (quantity && quantity.value !== '') {
                    return { success: false, error: 'لم يتم إعادة تعيين حقل الكمية' };
                }
                
                return { success: true, error: null };
            } catch (error) {
                return { success: false, error: error.message };
            }
        } else {
            return { success: false, error: 'دالة إعادة التعيين غير موجودة' };
        }
    },
    
    // تشغيل جميع الاختبارات
    runAllTests: async function() {
        this.log('🚀 بدء الاختبارات الشاملة...', 'info');
        
        const tests = [
            { name: 'تحميل الصفحة', fn: () => this.testPageLoad() },
            { name: 'هيكل النموذج', fn: () => this.testFormStructure() },
            { name: 'التنقل بين المراحل', fn: () => this.testStepNavigation() },
            { name: 'حقل الكمية', fn: () => this.testQuantityInput() },
            { name: 'خيارات التصميم', fn: () => this.testDesignOptions() },
            { name: 'واجهة التصميم المخصص', fn: () => this.testCustomDesignInterface() },
            { name: 'نوع النشاط', fn: () => this.testBusinessType() },
            { name: 'معلومات الشركة', fn: () => this.testCompanyInfo() },
            { name: 'المعلومات الشخصية', fn: () => this.testPersonalInfo() },
            { name: 'التحقق من صحة البيانات', fn: () => this.testFormValidation() },
            { name: 'عرض الملخص', fn: () => this.testSummaryDisplay() },
            { name: 'إرسال النموذج', fn: () => this.testFormSubmission() },
            { name: 'إعادة تعيين النموذج', fn: () => this.testFormReset() }
        ];
        
        for (const test of tests) {
            await this.runTest(test.name, test.fn);
            await new Promise(resolve => setTimeout(resolve, 500));
        }
        
        this.log('✅ انتهت جميع الاختبارات', 'success');
        this.log(`📊 النتائج: ${this.results.passed}/${this.results.total} نجح`, 'info');
        
        return this.results;
    },
    
    // تشغيل اختبارات سريعة
    runQuickTests: async function() {
        this.log('⚡ بدء الاختبارات السريعة...', 'info');
        
        const quickTests = [
            { name: 'تحميل الصفحة', fn: () => this.testPageLoad() },
            { name: 'هيكل النموذج', fn: () => this.testFormStructure() },
            { name: 'خيارات التصميم', fn: () => this.testDesignOptions() }
        ];
        
        for (const test of quickTests) {
            await this.runTest(test.name, test.fn);
            await new Promise(resolve => setTimeout(resolve, 300));
        }
        
        this.log('✅ انتهت الاختبارات السريعة', 'success');
        return this.results;
    }
};

// إضافة دوال للاستخدام في Console
window.testForm = FormTester;
window.runAllTests = () => FormTester.runAllTests();
window.runQuickTests = () => FormTester.runQuickTests();

// تشغيل تلقائي عند تحميل الصفحة
document.addEventListener('DOMContentLoaded', function() {
    console.log('🧪 تم تحميل ملف الاختبار بنجاح');
    console.log('استخدم runQuickTests() للاختبارات السريعة');
    console.log('استخدم runAllTests() للاختبارات الشاملة');
    console.log('استخدم testForm.runTest("اسم الاختبار", دالة الاختبار) لاختبار محدد');
});

// تصدير للاستخدام في Node.js
if (typeof module !== 'undefined' && module.exports) {
    module.exports = FormTester;
}
