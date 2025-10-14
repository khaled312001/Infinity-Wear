@extends('layouts.dashboard')

@section('title', 'المساعدة - لوحة تحكم المستورد')
@section('dashboard-title', 'لوحة المستورد')
@section('page-title', 'المساعدة')
@section('page-subtitle', 'دليل شامل لاستخدام النظام')

@section('content')
<div class="container-fluid">
    <!-- شريط البحث -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h6 class="mb-2">
                                <i class="fas fa-search me-2"></i>
                                البحث في المساعدة
                            </h6>
                            <div class="input-group">
                                <input type="text" class="form-control" id="helpSearch" placeholder="ابحث عن موضوع معين...">
                                <button class="btn btn-primary" type="button" onclick="searchHelp()">
                                    <i class="fas fa-search me-1"></i>
                                    بحث
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="d-flex justify-content-end align-items-center">
                                <span class="badge bg-info me-2">
                                    <i class="fas fa-book me-1"></i>
                                    {{ count($helpArticles) }} مقالة
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- فلاتر الفئات -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-body">
                    <h6 class="mb-3">تصفح حسب الفئة</h6>
                    <div class="d-flex flex-wrap gap-2">
                        <button class="btn btn-outline-primary active" onclick="filterByCategory('all')">
                            جميع المقالات
                        </button>
                        @foreach($categories as $key => $name)
                            <button class="btn btn-outline-primary" onclick="filterByCategory('{{ $key }}')">
                                {{ $name }}
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- مقالات المساعدة -->
    <div class="row">
        @foreach($helpArticles as $article)
            <div class="col-lg-6 mb-4 help-article" data-category="{{ $article['category'] }}">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex align-items-start mb-3">
                            <div class="help-icon me-3">
                                <i class="{{ $article['icon'] }} fa-2x text-{{ $article['color'] }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="card-title mb-2">{{ $article['title'] }}</h5>
                                <span class="badge bg-{{ $article['color'] }} mb-2">
                                    {{ $categories[$article['category']] }}
                                </span>
                            </div>
                        </div>
                        
                        <p class="card-text text-muted mb-3 flex-grow-1">
                            {{ $article['content'] }}
                        </p>
                        
                        <div class="mt-auto">
                            <button class="btn btn-outline-{{ $article['color'] }}" 
                                    onclick="showArticleDetails({{ $article['id'] }})">
                                <i class="fas fa-eye me-2"></i>
                                قراءة المزيد
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- الأسئلة الشائعة -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-question-circle me-2"></i>
                        الأسئلة الشائعة
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq1">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1">
                                    كم يستغرق تنفيذ الطلب؟
                                </button>
                            </h2>
                            <div id="collapse1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    عادة ما يستغرق تنفيذ الطلب من 7 إلى 14 يوم عمل، حسب نوع التصميم والكمية المطلوبة. يمكنك متابعة حالة طلبك من صفحة تتبع الشحنات.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq2">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2">
                                    ما هي طرق الدفع المتاحة؟
                                </button>
                            </h2>
                            <div id="collapse2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    نوفر عدة طرق دفع: التحويل البنكي (مجاني)، بطاقات الائتمان (2.5% رسوم)، STC Pay (1.5% رسوم)، Apple Pay (2% رسوم)، والدفع بالتقسيط (5% سنوياً).
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq3">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3">
                                    هل يمكن تعديل الطلب بعد إنشائه؟
                                </button>
                            </h2>
                            <div id="collapse3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    يمكن تعديل الطلب خلال 24 ساعة من إنشائه، أو قبل بدء عملية الإنتاج. يرجى التواصل معنا عبر الدعم الفني لتعديل الطلب.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq4">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4">
                                    كيف يمكنني تتبع شحنتي؟
                                </button>
                            </h2>
                            <div id="collapse4" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    يمكنك تتبع شحنتك من صفحة "تتبع الشحنات" في لوحة التحكم. ستظهر لك جميع التحديثات في الوقت الفعلي مع رقم التتبع.
                                </div>
                            </div>
                        </div>
                        
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="faq5">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5">
                                    ما هي سياسة الإرجاع والاستبدال؟
                                </button>
                            </h2>
                            <div id="collapse5" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    يمكن إرجاع أو استبدال المنتجات خلال 7 أيام من التسليم، بشرط أن تكون في حالتها الأصلية. لا يشمل ذلك المنتجات المخصصة حسب الطلب.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- روابط مفيدة -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="dashboard-card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-link me-2"></i>
                        روابط مفيدة
                    </h5>
                </div>
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <i class="fas fa-video fa-2x text-primary mb-2"></i>
                                <h6>فيديوهات تعليمية</h6>
                                <p class="text-muted small">شاهد الفيديوهات التعليمية</p>
                                <button class="btn btn-outline-primary btn-sm">مشاهدة</button>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <i class="fas fa-file-pdf fa-2x text-danger mb-2"></i>
                                <h6>دليل المستخدم</h6>
                                <p class="text-muted small">تحميل دليل المستخدم</p>
                                <button class="btn btn-outline-danger btn-sm">تحميل</button>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <i class="fas fa-headset fa-2x text-success mb-2"></i>
                                <h6>الدعم الفني</h6>
                                <p class="text-muted small">تواصل مع الدعم الفني</p>
                                <a href="{{ route('importers.support') }}" class="btn btn-outline-success btn-sm">تواصل</a>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <i class="fas fa-comments fa-2x text-info mb-2"></i>
                                <h6>التواصل معنا</h6>
                                <p class="text-muted small">راسلنا مباشرة</p>
                                <a href="{{ route('importers.contact') }}" class="btn btn-outline-info btn-sm">راسلنا</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal تفاصيل المقالة -->
<div class="modal fade" id="articleModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="articleTitle">عنوان المقالة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="articleContent">
                محتوى المقالة...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-primary" onclick="printArticle()">
                    <i class="fas fa-print me-1"></i>
                    طباعة
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.help-article {
    transition: transform 0.2s ease-in-out;
}

.help-article:hover {
    transform: translateY(-2px);
}

.help-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #f8f9fa, #e9ecef);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.accordion-button {
    font-weight: 600;
}

.accordion-button:not(.collapsed) {
    background-color: #f8f9fa;
    color: #007bff;
}

.btn.active {
    background-color: #007bff;
    color: white;
    border-color: #007bff;
}
</style>

<script>
function searchHelp() {
    const searchTerm = document.getElementById('helpSearch').value.toLowerCase();
    const articles = document.querySelectorAll('.help-article');
    
    articles.forEach(article => {
        const title = article.querySelector('.card-title').textContent.toLowerCase();
        const content = article.querySelector('.card-text').textContent.toLowerCase();
        
        if (title.includes(searchTerm) || content.includes(searchTerm)) {
            article.style.display = 'block';
        } else {
            article.style.display = 'none';
        }
    });
}

function filterByCategory(category) {
    // تحديث الأزرار النشطة
    document.querySelectorAll('.btn-outline-primary').forEach(btn => {
        btn.classList.remove('active');
    });
    event.target.classList.add('active');
    
    const articles = document.querySelectorAll('.help-article');
    
    articles.forEach(article => {
        if (category === 'all' || article.dataset.category === category) {
            article.style.display = 'block';
        } else {
            article.style.display = 'none';
        }
    });
}

function showArticleDetails(articleId) {
    // محاكاة عرض تفاصيل المقالة
    const articles = @json($helpArticles);
    const article = articles.find(a => a.id === articleId);
    
    if (article) {
        document.getElementById('articleTitle').textContent = article.title;
        document.getElementById('articleContent').innerHTML = `
            <div class="mb-3">
                <span class="badge bg-${article.color}">${@json($categories)[article.category]}</span>
            </div>
            <div class="article-content">
                <h6>الخطوات:</h6>
                <ol>
                    <li>قم بتسجيل الدخول إلى لوحة التحكم</li>
                    <li>انتقل إلى القسم المناسب</li>
                    <li>اتبع التعليمات المعروضة</li>
                    <li>احفظ التغييرات</li>
                </ol>
                
                <h6 class="mt-4">نصائح مهمة:</h6>
                <ul>
                    <li>تأكد من صحة البيانات المدخلة</li>
                    <li>احتفظ بنسخة احتياطية من المعلومات المهمة</li>
                    <li>تواصل مع الدعم الفني في حالة وجود مشاكل</li>
                </ul>
                
                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>ملاحظة:</strong> ${article.content}
                </div>
            </div>
        `;
        
        const modal = new bootstrap.Modal(document.getElementById('articleModal'));
        modal.show();
    }
}

function printArticle() {
    const printContent = document.getElementById('articleContent').innerHTML;
    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <html>
            <head>
                <title>${document.getElementById('articleTitle').textContent}</title>
                <style>
                    body { font-family: Arial, sans-serif; direction: rtl; padding: 20px; }
                    h6 { color: #007bff; margin-top: 20px; }
                    .alert { background-color: #d1ecf1; border: 1px solid #bee5eb; padding: 10px; border-radius: 5px; }
                    .badge { background-color: #007bff; color: white; padding: 5px 10px; border-radius: 3px; }
                </style>
            </head>
            <body>
                <h2>${document.getElementById('articleTitle').textContent}</h2>
                ${printContent}
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
}

// البحث التلقائي أثناء الكتابة
document.getElementById('helpSearch').addEventListener('input', function() {
    searchHelp();
});
</script>
@endsection
