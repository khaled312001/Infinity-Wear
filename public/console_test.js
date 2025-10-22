// اختبار سريع للنموذج - Infinity Wear
// انسخ والصق هذا الكود في Console صفحة النموذج

async function quickTest() {
    console.log('🚀 بدء الاختبار السريع...');
    
    const results = { passed: 0, failed: 0, total: 0 };
    
    // اختبار 1: تحميل الصفحة
    results.total++;
    try {
        const response = await fetch(window.location.href);
        if (response.ok) {
            console.log('✅ تحميل الصفحة: نجح');
            results.passed++;
        } else {
            console.log('❌ تحميل الصفحة: فشل - HTTP', response.status);
            results.failed++;
        }
    } catch (error) {
        console.log('❌ تحميل الصفحة: خطأ -', error.message);
        results.failed++;
    }
    
    // اختبار 2: هيكل النموذج
    results.total++;
    const requiredElements = [
        'registrationForm', 'quantity', 'design_option', 
        'business_type', 'company_name', 'city', 
        'name', 'email', 'phone'
    ];
    
    const missingElements = requiredElements.filter(id => !document.getElementById(id));
    
    if (missingElements.length === 0) {
        console.log('✅ هيكل النموذج: نجح - جميع العناصر موجودة');
        results.passed++;
    } else {
        console.log('❌ هيكل النموذج: فشل - عناصر مفقودة:', missingElements);
        results.failed++;
    }
    
    // اختبار 3: خيارات التصميم
    results.total++;
    const designOptions = document.querySelectorAll('input[name="design_option"]');
    
    if (designOptions.length >= 3) {
        console.log('✅ خيارات التصميم: نجح -', designOptions.length, 'خيارات موجودة');
        results.passed++;
        
        // اختبار اختيار كل خيار
        designOptions.forEach((option, index) => {
            option.checked = true;
            option.dispatchEvent(new Event('change', { bubbles: true }));
            console.log(`  - خيار ${index + 1}: ${option.value} - ${option.checked ? 'محدد' : 'غير محدد'}`);
            option.checked = false;
        });
    } else {
        console.log('❌ خيارات التصميم: فشل -', designOptions.length, 'خيارات فقط');
        results.failed++;
    }
    
    // اختبار 4: حقل الكمية
    results.total++;
    const quantityInput = document.getElementById('quantity');
    
    if (quantityInput) {
        quantityInput.value = '100';
        quantityInput.dispatchEvent(new Event('input', { bubbles: true }));
        
        if (quantityInput.value === '100') {
            console.log('✅ حقل الكمية: نجح - يمكن إدخال القيم');
            results.passed++;
        } else {
            console.log('❌ حقل الكمية: فشل - لا يمكن إدخال القيم');
            results.failed++;
        }
    } else {
        console.log('❌ حقل الكمية: فشل - الحقل غير موجود');
        results.failed++;
    }
    
    // اختبار 5: نوع النشاط
    results.total++;
    const businessTypeSelect = document.getElementById('business_type');
    
    if (businessTypeSelect) {
        const options = businessTypeSelect.querySelectorAll('option');
        if (options.length > 1) {
            console.log('✅ نوع النشاط: نجح -', options.length - 1, 'خيارات متاحة');
            results.passed++;
        } else {
            console.log('❌ نوع النشاط: فشل - لا توجد خيارات');
            results.failed++;
        }
    } else {
        console.log('❌ نوع النشاط: فشل - القائمة غير موجودة');
        results.failed++;
    }
    
    // اختبار 6: معلومات الشركة
    results.total++;
    const companyName = document.getElementById('company_name');
    const city = document.getElementById('city');
    
    if (companyName && city) {
        companyName.value = 'شركة اختبار';
        city.value = 'الرياض';
        
        if (companyName.value === 'شركة اختبار' && city.value === 'الرياض') {
            console.log('✅ معلومات الشركة: نجح - يمكن إدخال البيانات');
            results.passed++;
        } else {
            console.log('❌ معلومات الشركة: فشل - لا يمكن إدخال البيانات');
            results.failed++;
        }
    } else {
        console.log('❌ معلومات الشركة: فشل - الحقول غير موجودة');
        results.failed++;
    }
    
    // اختبار 7: المعلومات الشخصية
    results.total++;
    const name = document.getElementById('name');
    const email = document.getElementById('email');
    const phone = document.getElementById('phone');
    
    if (name && email && phone) {
        name.value = 'أحمد محمد';
        email.value = 'test@example.com';
        phone.value = '0501234567';
        
        if (name.value === 'أحمد محمد' && email.value === 'test@example.com' && phone.value === '0501234567') {
            console.log('✅ المعلومات الشخصية: نجح - يمكن إدخال البيانات');
            results.passed++;
        } else {
            console.log('❌ المعلومات الشخصية: فشل - لا يمكن إدخال البيانات');
            results.failed++;
        }
    } else {
        console.log('❌ المعلومات الشخصية: فشل - الحقول غير موجودة');
        results.failed++;
    }
    
    // اختبار 8: واجهة التصميم المخصص
    results.total++;
    const customOption = document.querySelector('input[value="custom"]');
    
    if (customOption) {
        customOption.checked = true;
        customOption.dispatchEvent(new Event('change', { bubbles: true }));
        
        // انتظار قليل لظهور الواجهة
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        const customInterface = document.querySelector('.custom-design-interface');
        if (customInterface && customInterface.style.display !== 'none') {
            console.log('✅ واجهة التصميم المخصص: نجح - ظهرت الواجهة');
            results.passed++;
        } else {
            console.log('❌ واجهة التصميم المخصص: فشل - لم تظهر الواجهة');
            results.failed++;
        }
    } else {
        console.log('❌ واجهة التصميم المخصص: فشل - خيار التصميم المخصص غير موجود');
        results.failed++;
    }
    
    // اختبار 9: الملخص
    results.total++;
    const summaryElements = [
        'summary_quantity', 'summary_design_option', 'summary_company',
        'summary_business_type', 'summary_city', 'summary_name',
        'summary_email', 'summary_phone'
    ];
    
    const existingSummaryElements = summaryElements.filter(id => document.getElementById(id));
    
    if (existingSummaryElements.length >= 6) {
        console.log('✅ الملخص: نجح -', existingSummaryElements.length, 'عنصر موجود');
        results.passed++;
    } else {
        console.log('❌ الملخص: فشل -', existingSummaryElements.length, 'عناصر فقط');
        results.failed++;
    }
    
    // اختبار 10: إعادة التعيين
    results.total++;
    if (typeof window.multiStepForm !== 'undefined' && window.multiStepForm.resetForm) {
        try {
            window.multiStepForm.resetForm();
            console.log('✅ إعادة التعيين: نجح - الدالة موجودة');
            results.passed++;
        } catch (error) {
            console.log('❌ إعادة التعيين: فشل - خطأ في التنفيذ:', error.message);
            results.failed++;
        }
    } else {
        console.log('❌ إعادة التعيين: فشل - الدالة غير موجودة');
        results.failed++;
    }
    
    // عرض النتائج النهائية
    console.log('\n📊 النتائج النهائية:');
    console.log(`✅ نجح: ${results.passed}`);
    console.log(`❌ فشل: ${results.failed}`);
    console.log(`📈 النسبة: ${Math.round((results.passed / results.total) * 100)}%`);
    
    if (results.failed === 0) {
        console.log('🎉 جميع الاختبارات نجحت!');
    } else if (results.passed > results.failed) {
        console.log('⚠️ معظم الاختبارات نجحت، لكن هناك بعض المشاكل');
    } else {
        console.log('🚨 هناك مشاكل كثيرة تحتاج إلى إصلاح');
    }
    
    return results;
}

// دالة اختبار خيار التصميم فقط
function testDesignOptions() {
    console.log('🎨 اختبار خيارات التصميم...');
    
    const designOptions = document.querySelectorAll('input[name="design_option"]');
    console.log('عدد خيارات التصميم:', designOptions.length);
    
    designOptions.forEach((option, index) => {
        console.log(`خيار ${index + 1}:`, {
            value: option.value,
            checked: option.checked,
            visible: option.offsetParent !== null
        });
    });
    
    // اختبار اختيار كل خيار
    designOptions.forEach((option, index) => {
        option.checked = true;
        option.dispatchEvent(new Event('change', { bubbles: true }));
        console.log(`✅ تم اختيار: ${option.value}`);
        option.checked = false;
    });
}

// دالة اختبار الملخص
function testSummary() {
    console.log('📋 اختبار الملخص...');
    
    const summaryElements = [
        'summary_quantity', 'summary_design_option', 'summary_requirements',
        'summary_company', 'summary_business_type', 'summary_city',
        'summary_name', 'summary_email', 'summary_phone'
    ];
    
    summaryElements.forEach(id => {
        const element = document.getElementById(id);
        console.log(`${id}:`, element ? {
            exists: true,
            textContent: element.textContent,
            visible: element.offsetParent !== null
        } : 'NOT FOUND');
    });
}

// دالة اختبار إعادة التعيين
function testReset() {
    console.log('🔄 اختبار إعادة التعيين...');
    
    if (typeof window.multiStepForm !== 'undefined' && window.multiStepForm.resetForm) {
        try {
            window.multiStepForm.resetForm();
            console.log('✅ تم تنفيذ إعادة التعيين بنجاح');
        } catch (error) {
            console.log('❌ خطأ في إعادة التعيين:', error.message);
        }
    } else {
        console.log('❌ دالة إعادة التعيين غير موجودة');
    }
}

// تشغيل الاختبار السريع
console.log('🧪 تم تحميل ملف الاختبار السريع');
console.log('استخدم quickTest() للاختبار الشامل');
console.log('استخدم testDesignOptions() لاختبار خيارات التصميم');
console.log('استخدم testSummary() لاختبار الملخص');
console.log('استخدم testReset() لاختبار إعادة التعيين');

// تشغيل تلقائي
quickTest();
