// Admin Services Management JavaScript
console.log('Loading admin services JavaScript...');

// Check if jQuery is available
if (typeof $ !== 'undefined') {
    console.log('jQuery is available');
} else {
    console.log('jQuery is not available, using vanilla JavaScript');
}

// Services data will be passed from the view
let services = [];

// Initialize services data
function initServices(servicesData) {
    services = servicesData;
    console.log('Services initialized:', services.length, 'services');
}

// Add feature input
function addFeature() {
    const container = document.getElementById('featuresContainer');
    if (!container) return;
    
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" class="form-control" name="features[]" placeholder="أدخل ميزة">
        <button type="button" class="btn btn-outline-danger remove-feature-btn">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(div);
}

// Add feature input for edit modal
function addEditFeature() {
    const container = document.getElementById('editFeaturesContainer');
    if (!container) return;
    
    const div = document.createElement('div');
    div.className = 'input-group mb-2';
    div.innerHTML = `
        <input type="text" class="form-control" name="features[]" placeholder="أدخل ميزة">
        <button type="button" class="btn btn-outline-danger remove-feature-btn">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(div);
}

// Remove feature input
function removeFeature(button) {
    if (button && button.parentElement) {
        button.parentElement.remove();
    }
}

// Edit service
function editService(serviceId) {
    console.log('Editing service ID:', serviceId);
    console.log('Available services:', services);
    
    const service = services.find(s => s.id == serviceId);
    if (!service) {
        console.error('Service not found with ID:', serviceId);
        alert('الخدمة غير موجودة');
        return;
    }
    
    console.log('Found service:', service);
    
    // Populate form
    document.getElementById('edit_service_id').value = service.id;
    document.getElementById('edit_title').value = service.title;
    document.getElementById('edit_description').value = service.description;
    document.getElementById('edit_icon').value = service.icon || '';
    document.getElementById('edit_order').value = service.order;
    document.getElementById('edit_is_active').checked = service.is_active;
    document.getElementById('edit_meta_title').value = service.meta_title || '';
    document.getElementById('edit_meta_description').value = service.meta_description || '';
    
    // Populate features
    const featuresContainer = document.getElementById('editFeaturesContainer');
    if (featuresContainer) {
        featuresContainer.innerHTML = '';
        
        if (service.features && service.features.length > 0) {
            service.features.forEach(feature => {
                const div = document.createElement('div');
                div.className = 'input-group mb-2';
                div.innerHTML = `
                    <input type="text" class="form-control" name="features[]" value="${feature}">
                    <button type="button" class="btn btn-outline-danger remove-feature-btn">
                        <i class="fas fa-trash"></i>
                    </button>
                `;
                featuresContainer.appendChild(div);
            });
        } else {
            addEditFeature();
        }
    }
    
    // Show current image
    const imagePreview = document.getElementById('currentImagePreview');
    if (imagePreview) {
        if (service.image) {
            imagePreview.innerHTML = `
                <small class="text-muted">الصورة الحالية:</small><br>
                <img src="${service.image_url}" alt="${service.title}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
            `;
        } else {
            imagePreview.innerHTML = '<small class="text-muted">لا توجد صورة حالية</small>';
        }
    }
    
    // Show modal
    const modalElement = document.getElementById('editServiceModal');
    if (modalElement) {
        console.log('Modal element found, showing modal...');
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
        console.log('Modal should be visible now');
    } else {
        console.error('Modal element not found!');
        alert('خطأ: لم يتم العثور على نافذة التعديل');
    }
}

// Toggle service status
function toggleServiceStatus(serviceId) {
    if (confirm('هل أنت متأكد من تغيير حالة هذه الخدمة؟')) {
        fetch(`/admin/services/${serviceId}/toggle-status`, {
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (response.ok) {
                return response;
            } else {
                throw new Error('Network response was not ok');
            }
        })
        .then(response => response.text())
        .then(data => {
            try {
                const jsonData = JSON.parse(data);
                if (jsonData.success) {
                    location.reload();
                } else {
                    alert('حدث خطأ أثناء تغيير حالة الخدمة');
                }
            } catch (e) {
                // If it's not JSON, it might be a redirect response
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء تغيير حالة الخدمة');
        });
    }
}

// Delete service
function deleteService(serviceId) {
    if (confirm('هل أنت متأكد من حذف هذه الخدمة؟ لا يمكن التراجع عن هذا الإجراء.')) {
        fetch(`/admin/services/${serviceId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (response.ok) {
                return response;
            } else {
                throw new Error('Network response was not ok');
            }
        })
        .then(response => response.text())
        .then(data => {
            try {
                const jsonData = JSON.parse(data);
                if (jsonData.success) {
                    location.reload();
                } else {
                    alert('حدث خطأ أثناء حذف الخدمة');
                }
            } catch (e) {
                // If it's not JSON, it might be a redirect response
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء حذف الخدمة');
        });
    }
}

// Make functions globally available
window.editService = editService;
window.toggleServiceStatus = toggleServiceStatus;
window.deleteService = deleteService;
window.addFeature = addFeature;
window.addEditFeature = addEditFeature;
window.removeFeature = removeFeature;
window.initServices = initServices;

console.log('Admin services JavaScript loaded successfully');

// Test if all functions are available
console.log('Function availability check:');
console.log('- editService:', typeof editService === 'function');
console.log('- toggleServiceStatus:', typeof toggleServiceStatus === 'function');
console.log('- deleteService:', typeof deleteService === 'function');
console.log('- addFeature:', typeof addFeature === 'function');
console.log('- addEditFeature:', typeof addEditFeature === 'function');
console.log('- removeFeature:', typeof removeFeature === 'function');
console.log('- initServices:', typeof initServices === 'function');
