@extends('layouts.app')

@section('title', 'تفاصيل الإشعار')

@section('content')
<div class="container-fluid">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-bell me-2"></i>
                        تفاصيل الإشعار
                    </h1>
                    <p class="text-muted">عرض تفاصيل الإشعار ونتائج الإرسال</p>
                </div>
                <div>
                    <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right me-2"></i>
                        العودة للقائمة
                    </a>
                    @if(!$notification->is_sent)
                        <form method="POST" action="{{ route('admin.notifications.send', $notification) }}" 
                              style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-success" 
                                    onclick="return confirm('هل تريد إرسال هذا الإشعار الآن؟')">
                                <i class="fas fa-paper-plane me-2"></i>
                                إرسال الآن
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Notification Details -->
        <div class="col-lg-8">
            <!-- Basic Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">معلومات الإشعار</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="text-primary mb-3">{{ $notification->title }}</h4>
                            @if($notification->category)
                                <span class="badge badge-secondary mb-3">{{ $notification->category }}</span>
                            @endif
                        </div>
                        <div class="col-md-4 text-right">
                            <span class="badge badge-{{ $notification->priority_color }} badge-lg">
                                {{ $notification->priority_label }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h6 class="font-weight-bold text-gray-800">محتوى الإشعار:</h6>
                        <div class="bg-light p-3 rounded">
                            {{ $notification->message }}
                        </div>
                    </div>

                    @if($notification->email_content)
                        <div class="mb-4">
                            <h6 class="font-weight-bold text-gray-800">محتوى الإيميل:</h6>
                            <div class="bg-light p-3 rounded">
                                {!! nl2br(e($notification->email_content)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Target Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">المستهدفون</h6>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>نوع المستهدفين:</strong>
                            <span class="badge badge-info">{{ $notification->target_type_label }}</span>
                        </div>
                        <div class="col-md-6">
                            <strong>طريقة الإرسال:</strong>
                            <span class="badge badge-{{ $notification->type == 'notification' ? 'primary' : ($notification->type == 'email' ? 'success' : 'info') }}">
                                {{ $notification->type_label }}
                            </span>
                        </div>
                    </div>

                    @if($targetUsers->count() > 0)
                        <h6 class="font-weight-bold text-gray-800 mb-3">
                            المستخدمين المستهدفين ({{ $targetUsers->count() }} مستخدم):
                        </h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>الاسم</th>
                                        <th>الإيميل</th>
                                        <th>النوع</th>
                                        <th>الحالة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($targetUsers as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="badge badge-secondary">{{ $user->user_type_label }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-success">نشط</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            لا يوجد مستخدمين مستهدفين
                        </div>
                    @endif
                </div>
            </div>

            <!-- Send Results -->
            @if($notification->is_sent && $notification->send_results)
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">نتائج الإرسال</h6>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="h4 text-success">{{ $notification->sent_count }}</div>
                                    <div class="text-muted">تم الإرسال بنجاح</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="h4 text-danger">{{ $notification->failed_count }}</div>
                                    <div class="text-muted">فشل في الإرسال</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="h4 text-primary">{{ $notification->sent_count + $notification->failed_count }}</div>
                                    <div class="text-muted">إجمالي المحاولات</div>
                                </div>
                            </div>
                        </div>

                        @if($notification->failed_count > 0)
                            <h6 class="font-weight-bold text-gray-800 mb-3">تفاصيل الأخطاء:</h6>
                            <div class="table-responsive">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>المستخدم</th>
                                            <th>الخطأ</th>
                                            <th>الوقت</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($notification->send_results as $result)
                                            @if(!$result['success'])
                                                <tr>
                                                    <td>
                                                        @php
                                                            $user = $targetUsers->firstWhere('id', $result['user_id']);
                                                        @endphp
                                                        {{ $user ? $user->name : 'مستخدم غير موجود' }}
                                                    </td>
                                                    <td class="text-danger">{{ $result['error'] }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($result['sent_at'])->format('Y-m-d H:i:s') }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar Information -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">حالة الإشعار</h6>
                </div>
                <div class="card-body text-center">
                    @if($notification->is_sent)
                        <div class="mb-3">
                            <i class="fas fa-check-circle fa-3x text-success"></i>
                        </div>
                        <h5 class="text-success">تم الإرسال</h5>
                        <p class="text-muted">تم إرسال الإشعار بنجاح</p>
                        <small class="text-muted">
                            في {{ $notification->sent_at->format('Y-m-d H:i:s') }}
                        </small>
                    @elseif($notification->is_scheduled)
                        <div class="mb-3">
                            <i class="fas fa-calendar fa-3x text-info"></i>
                        </div>
                        <h5 class="text-info">مجدول</h5>
                        <p class="text-muted">سيتم الإرسال في الوقت المحدد</p>
                        <small class="text-muted">
                            {{ $notification->scheduled_at->format('Y-m-d H:i:s') }}
                        </small>
                    @else
                        <div class="mb-3">
                            <i class="fas fa-clock fa-3x text-warning"></i>
                        </div>
                        <h5 class="text-warning">في الانتظار</h5>
                        <p class="text-muted">لم يتم إرسال الإشعار بعد</p>
                    @endif
                </div>
            </div>

            <!-- Details Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">التفاصيل</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>تاريخ الإنشاء:</strong><br>
                        <span class="text-muted">{{ $notification->created_at->format('Y-m-d H:i:s') }}</span>
                    </div>
                    
                    <div class="mb-3">
                        <strong>أنشأ بواسطة:</strong><br>
                        <span class="text-muted">{{ $notification->creator->name }}</span>
                    </div>

                    @if($notification->is_scheduled)
                        <div class="mb-3">
                            <strong>مجدول للإرسال:</strong><br>
                            <span class="text-muted">{{ $notification->scheduled_at->format('Y-m-d H:i:s') }}</span>
                        </div>
                    @endif

                    @if($notification->is_sent)
                        <div class="mb-3">
                            <strong>تم الإرسال في:</strong><br>
                            <span class="text-muted">{{ $notification->sent_at->format('Y-m-d H:i:s') }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Actions Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">الإجراءات</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        @if(!$notification->is_sent)
                            <form method="POST" action="{{ route('admin.notifications.send', $notification) }}">
                                @csrf
                                <button type="submit" class="btn btn-success w-100" 
                                        onclick="return confirm('هل تريد إرسال هذا الإشعار الآن؟')">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    إرسال الآن
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary w-100">
                            <i class="fas fa-arrow-right me-2"></i>
                            العودة للقائمة
                        </a>

                        <form method="POST" action="{{ route('admin.notifications.destroy', $notification) }}" 
                              onsubmit="return confirm('هل أنت متأكد من حذف هذا الإشعار؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>
                                حذف الإشعار
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
