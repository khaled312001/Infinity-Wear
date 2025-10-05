@extends('layouts.dashboard')

@section('title', 'جميع الطلبات')
@section('dashboard-title', 'لوحة الإدارة')
@section('page-title', 'جميع الطلبات')
@section('page-subtitle', 'إدارة جميع طلبات المستوردين')
@section('profile-route', '#')
@section('settings-route', '#')

@section('sidebar-menu')
    @include('partials.admin-sidebar')
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-shopping-cart me-3 text-primary"></i>
                        جميع الطلبات
                    </h1>
                    <p class="text-muted mb-0">إدارة جميع طلبات المستوردين</p>
                </div>
                <div class="d-flex gap-2">
                    <select class="form-select form-select-sm" id="statusFilter">
                        <option value="">جميع الحالات</option>
                        <option value="new">جديد</option>
                        <option value="processing">قيد المعالجة</option>
                        <option value="completed">مكتمل</option>
                        <option value="cancelled">ملغي</option>
                    </select>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card">
                <div class="card-body">
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>المستورد</th>
                                        <th>نوع التصميم</th>
                                        <th>الكمية</th>
                                        <th>الحالة</th>
                                        <th>تاريخ الطلب</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>
                                                <span class="badge bg-primary">#{{ $order->id }}</span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm me-3">
                                                        <div class="avatar-title bg-light text-primary rounded-circle">
                                                            <i class="fas fa-user"></i>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $order->importer->company_name ?? 'غير محدد' }}</h6>
                                                        <small class="text-muted">{{ $order->importer->user->name ?? 'غير محدد' }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    @if($order->design_type === 'text')
                                                        وصف نصي
                                                    @elseif($order->design_type === 'upload')
                                                        رفع ملف
                                                    @elseif($order->design_type === 'template')
                                                        قالب جاهز
                                                    @elseif($order->design_type === 'ai')
                                                        ذكاء اصطناعي
                                                    @else
                                                        {{ $order->design_type }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-bold">{{ $order->quantity }}</span>
                                            </td>
                                            <td>
                                                @if($order->status === 'new')
                                                    <span class="badge bg-warning">جديد</span>
                                                @elseif($order->status === 'processing')
                                                    <span class="badge bg-info">قيد المعالجة</span>
                                                @elseif($order->status === 'completed')
                                                    <span class="badge bg-success">مكتمل</span>
                                                @elseif($order->status === 'cancelled')
                                                    <span class="badge bg-danger">ملغي</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $order->status }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('admin.importers.show', $order->importer) }}" 
                                                       class="btn btn-sm btn-outline-primary" 
                                                       title="عرض المستورد">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" 
                                                          method="POST" 
                                                          class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <select name="status" 
                                                                class="form-select form-select-sm" 
                                                                onchange="this.form.submit()"
                                                                style="width: auto;">
                                                            <option value="new" {{ $order->status === 'new' ? 'selected' : '' }}>جديد</option>
                                                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>قيد المعالجة</option>
                                                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>مكتمل</option>
                                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>ملغي</option>
                                                        </select>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-shopping-cart fa-3x mb-3 text-muted"></i>
                                <h5 class="mb-2">لا توجد طلبات</h5>
                                <p class="text-muted">لم يتم العثور على أي طلبات في النظام</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Filter functionality
    document.getElementById('statusFilter').addEventListener('change', function() {
        const status = this.value;
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            if (status === '' || row.querySelector('.badge').textContent.includes(status)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
@endsection
