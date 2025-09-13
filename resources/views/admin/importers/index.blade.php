@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">قائمة المستوردين</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الهاتف</th>
                                    <th>نوع النشاط</th>
                                    <th>الحالة</th>
                                    <th>تاريخ التسجيل</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($importers as $importer)
                                <tr>
                                    <td>{{ $importer->id }}</td>
                                    <td>{{ $importer->name }}</td>
                                    <td>{{ $importer->email }}</td>
                                    <td>{{ $importer->phone }}</td>
                                    <td>{{ $importer->business_type }}</td>
                                    <td>
                                        <span class="badge badge-{{ $importer->status == 'pending' ? 'warning' : ($importer->status == 'approved' ? 'success' : 'danger') }}">
                                            {{ $importer->status == 'pending' ? 'قيد المراجعة' : ($importer->status == 'approved' ? 'مقبول' : 'مرفوض') }}
                                        </span>
                                    </td>
                                    <td>{{ $importer->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <a href="{{ route('admin.importers.show', $importer->id) }}" class="btn btn-sm btn-info">عرض</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $importers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection