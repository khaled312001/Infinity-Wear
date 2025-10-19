

<?php $__env->startSection('title', 'تصدير التقارير'); ?>
<?php $__env->startSection('dashboard-title', 'تصدير التقارير'); ?>
<?php $__env->startSection('page-title', 'تصدير تقارير المندوبين'); ?>
<?php $__env->startSection('page-subtitle', 'تصدير التقارير المفلترة'); ?>

<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-12">
        <div class="dashboard-card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-download me-2"></i>
                        التقارير المفلترة
                    </h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-success" onclick="exportToExcel()">
                            <i class="fas fa-file-excel me-2"></i>
                            تصدير Excel
                        </button>
                        <button class="btn btn-danger" onclick="exportToPDF()">
                            <i class="fas fa-file-pdf me-2"></i>
                            تصدير PDF
                        </button>
                        <a href="<?php echo e(route('admin.marketing-reports.index')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-right me-2"></i>
                            العودة
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover" id="reportsTable">
                        <thead>
                            <tr>
                                <th>المندوب</th>
                                <th>الشركة</th>
                                <th>نوع النشاط</th>
                                <th>نوع الزيارة</th>
                                <th>حالة الاتفاق</th>
                                <th>الحالة</th>
                                <th>الكمية المستهدفة</th>
                                <th>الاستهلاك السنوي</th>
                                <th>التاريخ</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($report->representative_name); ?></td>
                                <td><?php echo e($report->company_name); ?></td>
                                <td><?php echo e($report->getCompanyActivityText()); ?></td>
                                <td><?php echo e($report->getVisitTypeText()); ?></td>
                                <td><?php echo e($report->getAgreementStatusText()); ?></td>
                                <td><?php echo e($report->getStatusText()); ?></td>
                                <td><?php echo e(number_format($report->target_quantity)); ?></td>
                                <td><?php echo e(number_format($report->annual_consumption)); ?></td>
                                <td><?php echo e($report->created_at->format('Y-m-d H:i')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-file-alt fa-3x mb-3"></i>
                                        <p>لا توجد تقارير متاحة للتصدير</p>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <?php if($reports->count() > 0): ?>
                <div class="mt-4">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        تم العثور على <strong><?php echo e($reports->count()); ?></strong> تقرير مطابق للمعايير المحددة
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js"></script>

<script>
function exportToExcel() {
    const table = document.getElementById('reportsTable');
    const wb = XLSX.utils.table_to_book(table, {sheet: "تقارير المندوبين"});
    
    // إضافة معلومات إضافية
    const ws = wb.Sheets["تقارير المندوبين"];
    XLSX.utils.sheet_add_aoa(ws, [
        ["تقرير تقارير المندوبين التسويقيين"],
        ["تاريخ التصدير: " + new Date().toLocaleDateString('ar-SA')],
        ["إجمالي التقارير: " + <?php echo e($reports->count()); ?>],
        [""]
    ], {origin: "A1"});
    
    XLSX.writeFile(wb, "marketing-reports-<?php echo e(date('Y-m-d')); ?>.xlsx");
}

function exportToPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF('l', 'mm', 'a4');
    
    // إضافة عنوان
    doc.setFontSize(16);
    doc.text('تقرير تقارير المندوبين التسويقيين', 14, 10);
    
    // إضافة معلومات التقرير
    doc.setFontSize(10);
    doc.text('تاريخ التصدير: ' + new Date().toLocaleDateString('ar-SA'), 14, 20);
    doc.text('إجمالي التقارير: ' + <?php echo e($reports->count()); ?>, 14, 25);
    
    // إعداد البيانات للجدول
    const tableData = [];
    const table = document.getElementById('reportsTable');
    const rows = table.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const cells = row.querySelectorAll('td');
        if (cells.length > 0) {
            const rowData = [];
            cells.forEach(cell => {
                rowData.push(cell.textContent.trim());
            });
            tableData.push(rowData);
        }
    });
    
    // إضافة الجدول
    doc.autoTable({
        head: [['المندوب', 'الشركة', 'نوع النشاط', 'نوع الزيارة', 'حالة الاتفاق', 'الحالة', 'الكمية المستهدفة', 'الاستهلاك السنوي', 'التاريخ']],
        body: tableData,
        startY: 30,
        styles: {
            fontSize: 8,
            cellPadding: 2
        },
        headStyles: {
            fillColor: [52, 58, 64],
            textColor: 255
        }
    });
    
    doc.save('marketing-reports-<?php echo e(date('Y-m-d')); ?>.pdf');
}

// إضافة تأثيرات بصرية
document.addEventListener('DOMContentLoaded', function() {
    const tableRows = document.querySelectorAll('table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#f8f9fa';
        });
        row.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '';
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH F:\infinity\Infinity-Wear\resources\views\admin\marketing-reports\export.blade.php ENDPATH**/ ?>