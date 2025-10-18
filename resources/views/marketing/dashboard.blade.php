@extends('layouts.marketing-dashboard')

@php
use App\Models\Contact;
@endphp

@section('title', 'لوحة التحكم - فريق التسويق')
@section('dashboard-title', 'لوحة التحكم')
@section('page-title', 'لوحة التحكم')
@section('page-subtitle', 'مرحباً بك في لوحة تحكم فريق التسويق')

@section('content')
<!-- Welcome Section -->
<div class="row mb-4">
    <div class="col-12">
        <div class="welcome-card dashboard-card">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="welcome-content">
                        <h2 class="welcome-title">
                            مرحباً {{ Auth::user()->name }}! 👋
                        </h2>
                        <p class="welcome-subtitle">
                            إليك نظرة سريعة على أداء فريق التسويق اليوم
                        </p>
                        <div class="welcome-stats">
                            <div class="stat-item">
                                <span class="stat-number">{{ $taskStats['total'] }}</span>
                                <span class="stat-label">مهمة إجمالية</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">{{ $marketingContent['portfolio_items'] }}</span>
                                <span class="stat-label">مشروع في المعرض</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">{{ $whatsappStats['today_messages'] }}</span>
                                <span class="stat-label">رسالة اليوم</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-number">{{ $contactStats['new'] }}</span>
                                <span class="stat-label">جهة اتصال جديدة</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-end">
                    <div class="welcome-illustration">
                        <i class="fas fa-chart-line fa-4x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Stats Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card enhanced">
            <div class="stats-header">
                <div class="stats-icon primary">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stats-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+12%</span>
                </div>
            </div>
            <div class="stats-content">
                <h3 class="stats-number">{{ $taskStats['total'] }}</h3>
                <p class="stats-label">إجمالي المهام</p>
                <div class="progress mt-2">
                    <div class="progress-bar bg-primary" style="width: {{ $taskStats['total'] > 0 ? ($taskStats['completed'] / $taskStats['total']) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card enhanced">
            <div class="stats-header">
                <div class="stats-icon warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-trend {{ $taskStats['pending'] > 5 ? 'negative' : 'positive' }}">
                    <i class="fas fa-arrow-{{ $taskStats['pending'] > 5 ? 'up' : 'down' }}"></i>
                    <span>{{ $taskStats['pending'] > 5 ? '+' : '-' }}3%</span>
                </div>
            </div>
            <div class="stats-content">
                <h3 class="stats-number">{{ $taskStats['pending'] }}</h3>
                <p class="stats-label">مهام معلقة</p>
                <div class="progress mt-2">
                    <div class="progress-bar bg-warning" style="width: {{ $taskStats['total'] > 0 ? ($taskStats['pending'] / $taskStats['total']) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card enhanced">
            <div class="stats-header">
                <div class="stats-icon info">
                    <i class="fas fa-play"></i>
                </div>
                <div class="stats-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+8%</span>
                </div>
            </div>
            <div class="stats-content">
                <h3 class="stats-number">{{ $taskStats['in_progress'] }}</h3>
                <p class="stats-label">قيد التنفيذ</p>
                <div class="progress mt-2">
                    <div class="progress-bar bg-info" style="width: {{ $taskStats['total'] > 0 ? ($taskStats['in_progress'] / $taskStats['total']) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-4">
        <div class="stats-card enhanced">
            <div class="stats-header">
                <div class="stats-icon success">
                    <i class="fas fa-check"></i>
                </div>
                <div class="stats-trend positive">
                    <i class="fas fa-arrow-up"></i>
                    <span>+15%</span>
                </div>
            </div>
            <div class="stats-content">
                <h3 class="stats-number">{{ $taskStats['completed'] }}</h3>
                <p class="stats-label">مهام مكتملة</p>
                <div class="progress mt-2">
                    <div class="progress-bar bg-success" style="width: {{ $taskStats['total'] > 0 ? ($taskStats['completed'] / $taskStats['total']) * 100 : 0 }}%"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Content Overview Section -->
<div class="row mb-4">
    <!-- المحتوى التسويقي -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card content-overview-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-palette me-2 text-primary"></i>
                    المحتوى التسويقي
                </h5>
                <a href="{{ route('marketing.portfolio') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye me-1"></i>
                    عرض الكل
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="content-stat-item">
                            <div class="stat-icon-wrapper bg-primary">
                                <i class="fas fa-images"></i>
                            </div>
                            <div class="stat-content">
                                <h4 class="stat-number">{{ $marketingContent['portfolio_items'] }}</h4>
                                <p class="stat-label">مشاريع المعرض</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="content-stat-item">
                            <div class="stat-icon-wrapper bg-success">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="stat-content">
                                <h4 class="stat-number">{{ $marketingContent['testimonials'] }}</h4>
                                <p class="stat-label">تقييمات العملاء</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="content-stat-item">
                            <div class="stat-icon-wrapper bg-warning">
                                <i class="fas fa-th-large"></i>
                            </div>
                            <div class="stat-content">
                                <h4 class="stat-number">{{ $marketingContent['home_sections'] }}</h4>
                                <p class="stat-label">أقسام الموقع</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات الواتساب -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card whatsapp-stats-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fab fa-whatsapp me-2 text-success"></i>
                    إحصائيات الواتساب
                </h5>
                <span class="badge bg-success">متصل</span>
            </div>
            <div class="card-body">
                <div class="whatsapp-stats-grid">
                    <div class="stat-row">
                        <div class="stat-info">
                            <i class="fas fa-comments text-primary"></i>
                            <span>إجمالي الرسائل</span>
                        </div>
                        <span class="stat-value">{{ $whatsappStats['total_messages'] }}</span>
                    </div>
                    <div class="stat-row">
                        <div class="stat-info">
                            <i class="fas fa-paper-plane text-success"></i>
                            <span>رسائل مرسلة</span>
                        </div>
                        <span class="stat-value">{{ $whatsappStats['sent_messages'] }}</span>
                    </div>
                    <div class="stat-row">
                        <div class="stat-info">
                            <i class="fas fa-inbox text-info"></i>
                            <span>رسائل مستلمة</span>
                        </div>
                        <span class="stat-value">{{ $whatsappStats['received_messages'] }}</span>
                    </div>
                    <div class="stat-row">
                        <div class="stat-info">
                            <i class="fas fa-calendar-day text-warning"></i>
                            <span>رسائل اليوم</span>
                        </div>
                        <span class="stat-value">{{ $whatsappStats['today_messages'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- المهام العاجلة -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-exclamation-triangle me-2 text-danger"></i>
                    المهام العاجلة
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    @forelse($urgentTasks as $task)
                    <div class="activity-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1">{{ $task->title }}</h6>
                                <p class="mb-1 text-muted">{{ Str::limit($task->description, 100) }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $task->due_date ? $task->due_date->format('Y-m-d') : 'بدون تاريخ' }}
                                </small>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-danger">عاجل</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-check-circle fa-3x mb-3 text-success"></i>
                        <p>لا توجد مهام عاجلة</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- المحتوى الحديث -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-images me-2"></i>
                    المحتوى الحديث
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    @forelse($recentPortfolio as $item)
                    <div class="activity-item">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <i class="fas fa-image text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $item->title }}</h6>
                                <p class="mb-1 text-muted">{{ Str::limit($item->description, 80) }}</p>
                                <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-images fa-3x mb-3"></i>
                        <p>لا يوجد محتوى حديث</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- التقييمات الحديثة -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-star me-2"></i>
                    التقييمات الحديثة
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    @forelse($recentTestimonials as $testimonial)
                    <div class="activity-item">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <i class="fas fa-star text-warning"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $testimonial->client_name }}</h6>
                                <p class="mb-1 text-muted">{{ Str::limit($testimonial->content, 80) }}</p>
                                <small class="text-muted">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                    - {{ $testimonial->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-star fa-3x mb-3"></i>
                        <p>لا توجد تقييمات حديثة</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- جهات الاتصال الحديثة -->
    <div class="col-lg-6 mb-4">
        <div class="dashboard-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-address-book me-2 text-primary"></i>
                    جهات الاتصال الحديثة
                </h5>
                <a href="{{ route('marketing.contacts') }}" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-eye me-1"></i>
                    عرض الكل
                </a>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    @forelse($contactStats['total'] > 0 ? Contact::latest()->limit(5)->get() : collect() as $contact)
                    <div class="activity-item">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <i class="fas fa-user text-primary"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $contact->name }}</h6>
                                <p class="mb-1 text-muted">{{ Str::limit($contact->subject, 60) }}</p>
                                <small class="text-muted">
                                    @switch($contact->status)
                                        @case('new')
                                            <span class="badge bg-warning">جديدة</span>
                                            @break
                                        @case('read')
                                            <span class="badge bg-info">مقروءة</span>
                                            @break
                                        @case('replied')
                                            <span class="badge bg-success">تم الرد عليها</span>
                                            @break
                                        @case('closed')
                                            <span class="badge bg-secondary">مغلقة</span>
                                            @break
                                    @endswitch
                                    - {{ $contact->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-address-book fa-3x mb-3"></i>
                        <p>لا توجد جهات اتصال حديثة</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- النشاط الأخير -->
<div class="row">
    <div class="col-12 mb-4">
        <div class="dashboard-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history me-2"></i>
                    النشاط الأخير
                </h5>
            </div>
            <div class="card-body">
                <div class="recent-activity">
                    @forelse($recentActivity as $activity)
                    <div class="activity-item">
                        <div class="d-flex align-items-start">
                            <div class="me-3">
                                <i class="fas {{ $activity['icon'] }} text-{{ $activity['color'] }}"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $activity['title'] }}</h6>
                                <p class="mb-1 text-muted">{{ $activity['description'] }}</p>
                                <small class="text-muted">{{ $activity['time']->diffForHumans() }}</small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-history fa-3x mb-3"></i>
                        <p>لا يوجد نشاط حديث</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions Section -->
<div class="row">
    <div class="col-12">
        <div class="dashboard-card quick-actions-card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2 text-warning"></i>
                    إجراءات سريعة
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('marketing.portfolio.create') }}" class="quick-action-btn btn-primary">
                            <div class="action-icon">
                                <i class="fas fa-plus"></i>
                            </div>
                            <div class="action-content">
                                <h6>إضافة مشروع</h6>
                                <p>إضافة مشروع جديد للمعرض</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('marketing.testimonials.create') }}" class="quick-action-btn btn-success">
                            <div class="action-icon">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="action-content">
                                <h6>إضافة تقييم</h6>
                                <p>إضافة تقييم جديد من العميل</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('marketing.tasks.index') }}" class="quick-action-btn btn-warning">
                            <div class="action-icon">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div class="action-content">
                                <h6>إدارة المهام</h6>
                                <p>عرض وإدارة المهام التسويقية</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('marketing.contacts') }}" class="quick-action-btn btn-secondary">
                            <div class="action-icon">
                                <i class="fas fa-address-book"></i>
                            </div>
                            <div class="action-content">
                                <h6>جهات الاتصال</h6>
                                <p>إدارة جهات الاتصال المشتركة</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('marketing.profile') }}" class="quick-action-btn btn-info">
                            <div class="action-icon">
                                <i class="fas fa-user-cog"></i>
                            </div>
                            <div class="action-content">
                                <h6>الملف الشخصي</h6>
                                <p>تحديث معلوماتك الشخصية</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS for Enhanced Design -->
<style>
/* Welcome Card Styles */
.welcome-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}

.welcome-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    color: white;
}

.welcome-subtitle {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.9);
    margin-bottom: 1.5rem;
}

.welcome-stats {
    display: flex;
    gap: 2rem;
    flex-wrap: wrap;
}

.stat-item {
    text-align: center;
}

.stat-item .stat-number {
    display: block;
    font-size: 1.8rem;
    font-weight: 700;
    color: white;
}

.stat-item .stat-label {
    font-size: 0.9rem;
    color: rgba(255, 255, 255, 0.8);
    margin: 0;
}

.welcome-illustration {
    opacity: 0.3;
}

/* Enhanced Stats Cards */
.stats-card.enhanced {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border: 1px solid #e2e8f0;
    border-radius: 16px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stats-card.enhanced:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
}

.stats-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.stats-trend {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    font-size: 0.8rem;
    font-weight: 600;
    padding: 0.25rem 0.5rem;
    border-radius: 20px;
}

.stats-trend.positive {
    color: #10b981;
    background: rgba(16, 185, 129, 0.1);
}

.stats-trend.negative {
    color: #ef4444;
    background: rgba(239, 68, 68, 0.1);
}

.stats-number {
    font-size: 2.5rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.5rem;
}

.stats-label {
    color: #64748b;
    font-weight: 500;
    margin-bottom: 0;
}

.progress {
    height: 6px;
    border-radius: 3px;
    background: #e2e8f0;
}

.progress-bar {
    border-radius: 3px;
    transition: width 0.6s ease;
}

/* Content Overview Cards */
.content-overview-card .card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    border-bottom: 1px solid #e2e8f0;
}

.content-stat-item {
    text-align: center;
    padding: 1rem;
    border-radius: 12px;
    transition: all 0.3s ease;
}

.content-stat-item:hover {
    background: #f8fafc;
    transform: translateY(-2px);
}

.stat-icon-wrapper {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem;
    color: white;
    font-size: 1.2rem;
}

.stat-content .stat-number {
    font-size: 1.8rem;
    font-weight: 700;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.stat-content .stat-label {
    color: #64748b;
    font-size: 0.9rem;
    margin: 0;
}

/* WhatsApp Stats Card */
.whatsapp-stats-card {
    border-left: 4px solid #25d366;
}

.whatsapp-stats-grid {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.stat-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem;
    background: #f8fafc;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.stat-row:hover {
    background: #e2e8f0;
    transform: translateX(5px);
}

.stat-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #64748b;
    font-weight: 500;
}

.stat-value {
    font-weight: 700;
    font-size: 1.1rem;
    color: #1e293b;
}

/* Quick Actions */
.quick-actions-card .card-header {
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    border-bottom: 1px solid #e2e8f0;
}

.quick-action-btn {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    border-radius: 12px;
    text-decoration: none;
    transition: all 0.3s ease;
    border: 2px solid transparent;
    background: white;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.quick-action-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    text-decoration: none;
}

.quick-action-btn.btn-primary:hover {
    border-color: #74b9ff;
    background: linear-gradient(135deg, #74b9ff, #0984e3);
    color: white;
}

.quick-action-btn.btn-success:hover {
    border-color: #00b894;
    background: linear-gradient(135deg, #00b894, #00a085);
    color: white;
}

.quick-action-btn.btn-warning:hover {
    border-color: #fdcb6e;
    background: linear-gradient(135deg, #fdcb6e, #e17055);
    color: white;
}

.quick-action-btn.btn-info:hover {
    border-color: #a29bfe;
    background: linear-gradient(135deg, #a29bfe, #6c5ce7);
    color: white;
}

.quick-action-btn.btn-secondary:hover {
    border-color: #636e72;
    background: linear-gradient(135deg, #636e72, #2d3436);
    color: white;
}

.action-icon {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.2rem;
    color: white;
    background: #e2e8f0;
    transition: all 0.3s ease;
}

.quick-action-btn.btn-primary .action-icon {
    background: #74b9ff;
}

.quick-action-btn.btn-success .action-icon {
    background: #00b894;
}

.quick-action-btn.btn-warning .action-icon {
    background: #fdcb6e;
}

.quick-action-btn.btn-info .action-icon {
    background: #a29bfe;
}

.quick-action-btn.btn-secondary .action-icon {
    background: #636e72;
}

.action-content h6 {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.25rem;
}

.action-content p {
    color: #64748b;
    font-size: 0.9rem;
    margin: 0;
}

/* Activity Items Enhancement */
.activity-item {
    padding: 1rem;
    border-radius: 12px;
    background: #f8fafc;
    margin-bottom: 0.75rem;
    transition: all 0.3s ease;
    border-left: 4px solid transparent;
}

.activity-item:hover {
    background: #e2e8f0;
    transform: translateX(5px);
    border-left-color: #3b82f6;
}

/* Responsive Design */
@media (max-width: 768px) {
    .welcome-title {
        font-size: 2rem;
    }
    
    .welcome-stats {
        gap: 1rem;
    }
    
    .stats-number {
        font-size: 2rem;
    }
    
    .quick-action-btn {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .action-content h6 {
        font-size: 1rem;
    }
    
    .action-content p {
        font-size: 0.8rem;
    }
}

/* Animation Classes */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.dashboard-card {
    animation: fadeInUp 0.6s ease-out;
}

.stats-card {
    animation: fadeInUp 0.6s ease-out;
}

.stats-card:nth-child(1) { animation-delay: 0.1s; }
.stats-card:nth-child(2) { animation-delay: 0.2s; }
.stats-card:nth-child(3) { animation-delay: 0.3s; }
.stats-card:nth-child(4) { animation-delay: 0.4s; }
</style>
@endsection
