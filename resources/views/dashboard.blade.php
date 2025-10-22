@extends('layouts.app')

@section('title', 'لوحة التحكم - تصميماتي')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-tachometer-alt me-2"></i>
                        لوحة التحكم - تصميماتي
                    </h4>
                </div>
                <div class="card-body p-4">
                    <!-- Design List -->
                    <div class="row" id="designs-container">
                        <!-- Designs will be loaded here via JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Design Details Modal -->
<div class="modal fade" id="designDetailsModal" tabindex="-1" aria-labelledby="designDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="designDetailsModalLabel">
                    <i class="fas fa-eye me-2"></i>
                    تفاصيل التصميم
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="design-details-content">
                <!-- Design details will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-primary" id="edit-design-btn">
                    <i class="fas fa-edit me-2"></i>
                    تعديل التصميم
                </button>
            </div>
        </div>
    </div>
</div>

<!-- 3D Viewer Modal -->
<div class="modal fade" id="viewer3DModal" tabindex="-1" aria-labelledby="viewer3DModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewer3DModalLabel">
                    <i class="fas fa-cube me-2"></i>
                    معاينة 3D
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div id="viewer3D-container" style="height: 600px; width: 100%;">
                    <!-- 3D viewer will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.design-card {
    transition: all 0.3s ease;
    border: 2px solid #e9ecef;
    border-radius: 15px;
    overflow: hidden;
}

.design-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    border-color: #667eea;
}

.design-card .card-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
}

.design-status {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.85rem;
}

.status-pending {
    background: #fff3cd;
    color: #856404;
    border: 1px solid #ffeaa7;
}

.status-in-progress {
    background: #d1ecf1;
    color: #0c5460;
    border: 1px solid #bee5eb;
}

.status-completed {
    background: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

.status-cancelled {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.priority-badge {
    padding: 0.25rem 0.75rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
}

.priority-normal {
    background: #e9ecef;
    color: #495057;
}

.priority-high {
    background: #ffc107;
    color: #212529;
}

.priority-urgent {
    background: #dc3545;
    color: white;
}

.design-summary {
    background: #f8f9fa;
    border-radius: 10px;
    padding: 1rem;
    margin: 1rem 0;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid #dee2e6;
}

.summary-item:last-child {
    border-bottom: none;
}

.summary-label {
    font-weight: 600;
    color: #495057;
}

.summary-value {
    color: #667eea;
    font-weight: 700;
}

.design-details-section {
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: white;
    border-radius: 10px;
    border: 1px solid #e9ecef;
}

.section-title {
    color: #667eea;
    font-weight: 700;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
}

.color-preview {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    border: 2px solid #dee2e6;
    display: inline-block;
    margin-left: 0.5rem;
    vertical-align: middle;
}

.file-item {
    display: flex;
    align-items: center;
    padding: 0.75rem;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 0.5rem;
    border: 1px solid #e9ecef;
}

.file-icon {
    width: 40px;
    height: 40px;
    background: #667eea;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    margin-left: 1rem;
}

.file-info {
    flex: 1;
}

.file-name {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.25rem;
}

.file-size {
    font-size: 0.85rem;
    color: #6c757d;
}

.loading-spinner {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 200px;
}

.spinner-border {
    width: 3rem;
    height: 3rem;
    color: #667eea;
}
</style>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<script>
class DashboardManager {
    constructor() {
        this.designs = [];
        this.currentDesign = null;
        this.init();
    }

    init() {
        this.loadDesigns();
        this.setupEventListeners();
    }

    async loadDesigns() {
        try {
            const response = await fetch('/api/design');
            const data = await response.json();
            
            if (data.success) {
                this.designs = data.designs;
                this.renderDesigns();
            } else {
                this.showError('خطأ في تحميل التصميمات');
            }
        } catch (error) {
            console.error('Error loading designs:', error);
            this.showError('خطأ في الاتصال بالخادم');
        }
    }

    renderDesigns() {
        const container = document.getElementById('designs-container');
        
        if (this.designs.length === 0) {
            container.innerHTML = `
                <div class="col-12 text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">لا توجد تصميمات بعد</h5>
                    <p class="text-muted">ابدأ بإنشاء تصميمك الأول</p>
                    <a href="/importers/register" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>
                        إنشاء تصميم جديد
                    </a>
                </div>
            `;
            return;
        }

        container.innerHTML = this.designs.map(design => this.createDesignCard(design)).join('');
    }

    createDesignCard(design) {
        const statusClass = `status-${design.status}`;
        const priorityClass = `priority-${design.priority}`;
        const createdDate = new Date(design.created_at).toLocaleDateString('ar-SA');
        
        return `
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card design-card h-100">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">${design.business_name}</h6>
                            <span class="design-status ${statusClass}">${this.getStatusText(design.status)}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-2">
                            <small>${createdDate}</small>
                            <span class="priority-badge ${priorityClass}">${this.getPriorityText(design.priority)}</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="design-summary">
                            <div class="summary-item">
                                <span class="summary-label">نوع النشاط:</span>
                                <span class="summary-value">${this.getBusinessTypeText(design.business_type)}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">إجمالي القطع:</span>
                                <span class="summary-value">${design.total_pieces || 0}</span>
                            </div>
                            <div class="summary-item">
                                <span class="summary-label">التكلفة المقدرة:</span>
                                <span class="summary-value">${design.estimated_cost || 0} ريال</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-outline-primary btn-sm" onclick="dashboardManager.viewDesign(${design.id})">
                                <i class="fas fa-eye me-1"></i>
                                عرض التفاصيل
                            </button>
                            <button class="btn btn-outline-success btn-sm" onclick="dashboardManager.view3D(${design.id})">
                                <i class="fas fa-cube me-1"></i>
                                معاينة 3D
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    async viewDesign(designId) {
        try {
            const response = await fetch(`/api/design/${designId}`);
            const data = await response.json();
            
            if (data.success) {
                this.currentDesign = data.design;
                this.showDesignDetails();
            } else {
                this.showError('خطأ في تحميل تفاصيل التصميم');
            }
        } catch (error) {
            console.error('Error loading design details:', error);
            this.showError('خطأ في الاتصال بالخادم');
        }
    }

    showDesignDetails() {
        const modal = new bootstrap.Modal(document.getElementById('designDetailsModal'));
        const content = document.getElementById('design-details-content');
        
        content.innerHTML = this.createDesignDetailsHTML();
        modal.show();
    }

    createDesignDetailsHTML() {
        const design = this.currentDesign;
        const clothingPieces = JSON.parse(design.clothing_pieces || '[]');
        const sizes = JSON.parse(design.sizes || '{}');
        const colors = JSON.parse(design.colors || '{}');
        const files = design.files || [];

        return `
            <div class="row">
                <div class="col-md-6">
                    <div class="design-details-section">
                        <h6 class="section-title">معلومات الشركة</h6>
                        <p><strong>اسم الشركة:</strong> ${design.business_name}</p>
                        <p><strong>نوع النشاط:</strong> ${this.getBusinessTypeText(design.business_type)}</p>
                        <p><strong>العنوان:</strong> ${design.address}</p>
                        <p><strong>المدينة:</strong> ${design.city}</p>
                        <p><strong>البلد:</strong> ${design.country}</p>
                        ${design.website ? `<p><strong>الموقع:</strong> <a href="${design.website}" target="_blank">${design.website}</a></p>` : ''}
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="design-details-section">
                        <h6 class="section-title">تفاصيل التصميم</h6>
                        <p><strong>نوع التصميم:</strong> ${design.design_option === 'custom' ? 'مخصص' : 'قالب جاهز'}</p>
                        <p><strong>الأولوية:</strong> ${this.getPriorityText(design.priority)}</p>
                        <p><strong>تفضيل التسليم:</strong> ${this.getDeliveryText(design.delivery_preference)}</p>
                        <p><strong>الحالة:</strong> ${this.getStatusText(design.status)}</p>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="design-details-section">
                        <h6 class="section-title">القطع المختارة</h6>
                        <div class="row">
                            ${clothingPieces.map(piece => `
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-tshirt fa-2x text-primary mb-2"></i>
                                            <h6>${this.getPieceName(piece)}</h6>
                                            ${sizes[piece] ? this.renderSizes(sizes[piece]) : ''}
                                        </div>
                                    </div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="design-details-section">
                        <h6 class="section-title">الألوان المختارة</h6>
                        <div class="row">
                            ${Object.entries(colors).map(([piece, pieceColors]) => `
                                <div class="col-md-6 mb-3">
                                    <h6>${this.getPieceName(piece)}</h6>
                                    ${Object.entries(pieceColors).map(([part, color]) => `
                                        <div class="d-flex align-items-center mb-2">
                                            <span class="color-preview" style="background-color: ${color}"></span>
                                            <span class="ms-2">${part}: ${color}</span>
                                        </div>
                                    `).join('')}
                                </div>
                            `).join('')}
                        </div>
                    </div>
                </div>
                
                ${design.design_notes ? `
                <div class="col-12">
                    <div class="design-details-section">
                        <h6 class="section-title">ملاحظات التصميم</h6>
                        <p class="text-muted">${design.design_notes}</p>
                    </div>
                </div>
                ` : ''}
                
                ${files.length > 0 ? `
                <div class="col-12">
                    <div class="design-details-section">
                        <h6 class="section-title">الملفات المرفوعة</h6>
                        ${files.map(file => `
                            <div class="file-item">
                                <div class="file-icon">
                                    <i class="fas fa-file"></i>
                                </div>
                                <div class="file-info">
                                    <div class="file-name">${file.original_name}</div>
                                    <div class="file-size">${this.formatFileSize(file.file_size)}</div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                </div>
                ` : ''}
            </div>
        `;
    }

    renderSizes(sizes) {
        return Object.entries(sizes)
            .filter(([size, quantity]) => quantity > 0)
            .map(([size, quantity]) => `<small class="badge bg-primary me-1">${size}: ${quantity}</small>`)
            .join('');
    }

    view3D(designId) {
        // This would load the 3D viewer with the design data
        const modal = new bootstrap.Modal(document.getElementById('viewer3DModal'));
        modal.show();
        
        // Load 3D viewer here
        this.load3DViewer(designId);
    }

    load3DViewer(designId) {
        // Implementation for 3D viewer
        const container = document.getElementById('viewer3D-container');
        container.innerHTML = '<div class="loading-spinner"><div class="spinner-border" role="status"></div></div>';
        
        // Load 3D scene based on design data
        // This would be implemented based on the 3D data stored
    }

    getStatusText(status) {
        const statuses = {
            'pending': 'في الانتظار',
            'in_progress': 'قيد التنفيذ',
            'completed': 'مكتمل',
            'cancelled': 'ملغي'
        };
        return statuses[status] || status;
    }

    getPriorityText(priority) {
        const priorities = {
            'normal': 'عادية',
            'high': 'عالية',
            'urgent': 'عاجلة'
        };
        return priorities[priority] || priority;
    }

    getBusinessTypeText(type) {
        const types = {
            'academy': 'أكاديمية رياضية',
            'school': 'مدرسة',
            'store': 'متجر ملابس',
            'hospital': 'مستشفى',
            'company': 'شركة',
            'other': 'أخرى'
        };
        return types[type] || type;
    }

    getDeliveryText(delivery) {
        const deliveries = {
            'standard': 'عادي (7-10 أيام)',
            'fast': 'سريع (3-5 أيام)',
            'express': 'عاجل (1-2 أيام)'
        };
        return deliveries[delivery] || delivery;
    }

    getPieceName(piece) {
        const pieces = {
            'shirt': 'قميص',
            'pants': 'بنطلون',
            'shorts': 'شورت',
            'jacket': 'جاكيت',
            'shoes': 'حذاء',
            'socks': 'شراب'
        };
        return pieces[piece] || piece;
    }

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    setupEventListeners() {
        // Setup any additional event listeners
    }

    showError(message) {
        // Show error message
        alert(message);
    }
}

// Initialize dashboard when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    window.dashboardManager = new DashboardManager();
});
</script>
@endsection
