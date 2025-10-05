@extends('layouts.marketing-dashboard')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'معرض الأعمال - فريق التسويق')
@section('dashboard-title', 'معرض الأعمال')
@section('page-title', 'معرض الأعمال')
@section('page-subtitle', 'إدارة مشاريع المعرض')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-images me-2"></i>
                    مشاريع المعرض
                </h5>
                <a href="{{ route('marketing.portfolio.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    إضافة مشروع جديد
                </a>
            </div>
            <div class="card-body">
                @if($portfolio->count() > 0)
                    <div class="row">
                        @foreach($portfolio as $item)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card h-100">
                                <img src="{{ Storage::url($item->image) }}" class="card-img-top" alt="{{ $item->title }}" style="height: 200px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $item->title }}</h6>
                                    <p class="card-text text-muted">{{ Str::limit($item->description, 100) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">{{ $item->client_name }}</small>
                                        @if($item->is_featured)
                                            <span class="badge bg-warning">مميز</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="btn-group w-100" role="group">
                                        <a href="{{ route('marketing.portfolio.edit', $item) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('marketing.portfolio.destroy', $item) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('هل أنت متأكد من حذف هذا المشروع؟')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="d-flex justify-content-center">
                        {{ $portfolio->links() }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-images fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">لا توجد مشاريع في المعرض</h5>
                        <p class="text-muted">ابدأ بإضافة مشروع جديد لعرض أعمالك</p>
                        <a href="{{ route('marketing.portfolio.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            إضافة مشروع جديد
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
