/**
 * Marketing Kanban Drag and Drop System
 * نظام السحب والإفلات لكانبان التسويق
 * 
 * Features:
 * - Drag and drop cards between columns
 * - Real-time status updates via AJAX
 * - Visual feedback during drag operations
 * - Responsive design support
 * - Error handling and notifications
 */

class MarketingKanban {
    constructor(options = {}) {
        this.options = {
            csrfToken: null,
            updateUrl: '/marketing/tasks/{taskId}/status',
            onStatusUpdate: null,
            onError: null,
            ...options
        };
        
        this.draggedCard = null;
        this.draggedCardOriginalParent = null;
        this.isInitialized = false;
        
        this.init();
    }
    
    init() {
        if (this.isInitialized) return;
        
        // Get CSRF token
        this.options.csrfToken = this.getCSRFToken();
        
        // Initialize drag and drop
        this.initializeDragAndDrop();
        
        this.isInitialized = true;
        console.log('Marketing Kanban initialized');
    }
    
    getCSRFToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
               document.querySelector('input[name="_token"]')?.value;
    }
    
    initializeDragAndDrop() {
        const marketingTaskCards = document.querySelectorAll('.marketing-task-card');
        const marketingKanbanBodies = document.querySelectorAll('.marketing-kanban-body');
        
        console.log('Initializing Marketing Kanban drag and drop for', marketingTaskCards.length, 'cards and', marketingKanbanBodies.length, 'columns');
        
        // Add drag events to cards
        marketingTaskCards.forEach(card => {
            card.addEventListener('dragstart', (e) => this.handleDragStart(e));
            card.addEventListener('dragend', (e) => this.handleDragEnd(e));
        });
        
        // Add drop events to columns
        marketingKanbanBodies.forEach(column => {
            column.addEventListener('dragover', (e) => this.handleDragOver(e));
            column.addEventListener('drop', (e) => this.handleDrop(e));
            column.addEventListener('dragenter', (e) => this.handleDragEnter(e));
            column.addEventListener('dragleave', (e) => this.handleDragLeave(e));
        });
    }
    
    handleDragStart(e) {
        this.draggedCard = e.target;
        this.draggedCardOriginalParent = e.target.parentNode;
        
        // Add dragging class for visual feedback
        e.target.classList.add('dragging');
        
        // Set drag data
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/html', e.target.outerHTML);
        
        console.log('Marketing drag started for task:', e.target.dataset.taskId);
    }
    
    handleDragEnd(e) {
        // Remove dragging class
        e.target.classList.remove('dragging');
        
        // Remove all drag-over classes
        document.querySelectorAll('.marketing-kanban-body').forEach(column => {
            column.classList.remove('drag-over');
        });
        
        this.draggedCard = null;
        this.draggedCardOriginalParent = null;
        
        console.log('Marketing drag ended');
    }
    
    handleDragOver(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
    }
    
    handleDragEnter(e) {
        e.preventDefault();
        e.target.classList.add('drag-over');
    }
    
    handleDragLeave(e) {
        // Only remove drag-over if we're actually leaving the column
        if (!e.target.contains(e.relatedTarget)) {
            e.target.classList.remove('drag-over');
        }
    }
    
    handleDrop(e) {
        e.preventDefault();
        e.target.classList.remove('drag-over');
        
        if (this.draggedCard && e.target !== this.draggedCardOriginalParent) {
            const newStatus = e.target.dataset.status;
            const taskId = this.draggedCard.dataset.taskId;
            const oldStatus = this.draggedCard.dataset.status;
            
            console.log('Moving Marketing task', taskId, 'from', oldStatus, 'to', newStatus);
            
            // Don't update if status is the same
            if (newStatus !== oldStatus) {
                // Update the card's data-status
                this.draggedCard.dataset.status = newStatus;
                
                // Move the card to the new column
                e.target.appendChild(this.draggedCard);
                
                // Update task status via AJAX
                this.updateTaskStatus(taskId, newStatus);
                
                // Update column counters
                this.updateColumnCounters();
                
                console.log('Marketing task moved successfully');
            } else {
                console.log('Same status, no update needed');
            }
        }
    }
    
    updateColumnCounters() {
        const columns = document.querySelectorAll('.marketing-kanban-column');
        columns.forEach(column => {
            const body = column.querySelector('.marketing-kanban-body');
            const header = column.querySelector('.marketing-kanban-header');
            const badge = header.querySelector('.marketing-badge');
            const count = body.children.length;
            badge.textContent = count;
        });
    }
    
    updateTaskStatus(taskId, newStatus) {
        if (!this.options.csrfToken) {
            console.error('CSRF token not found');
            this.showNotification('خطأ في الأمان - يرجى إعادة تحميل الصفحة', 'error');
            if (this.options.onError) {
                this.options.onError('CSRF token not found');
            }
            return;
        }

        // Build update URL
        let updateUrl = this.options.updateUrl || `/marketing/tasks/${taskId}/status`;
        
        // Replace {taskId} placeholder if present
        if (updateUrl.includes('{taskId}')) {
            updateUrl = updateUrl.replace('{taskId}', taskId);
        }
        
        fetch(updateUrl, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.options.csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                status: newStatus,
                _token: this.options.csrfToken
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                this.showNotification('تم تحديث حالة المهمة بنجاح', 'success');
                if (this.options.onStatusUpdate) {
                    this.options.onStatusUpdate(taskId, newStatus, data);
                }
            } else {
                this.showNotification(data.message || 'حدث خطأ في تحديث حالة المهمة', 'error');
                if (this.options.onError) {
                    this.options.onError(data.message || 'Update failed');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            this.showNotification('حدث خطأ في تحديث حالة المهمة', 'error');
            if (this.options.onError) {
                this.options.onError(error);
            }
        });
    }
    
    showNotification(message, type) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        const notification = document.createElement('div');
        notification.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            <i class="fas ${iconClass} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        document.body.appendChild(notification);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 3000);
    }
    
    // Public method to refresh the drag and drop system
    refresh() {
        this.isInitialized = false;
        this.init();
    }
    
    // Public method to destroy the drag and drop system
    destroy() {
        const marketingTaskCards = document.querySelectorAll('.marketing-task-card');
        const marketingKanbanBodies = document.querySelectorAll('.marketing-kanban-body');
        
        // Remove all event listeners
        marketingTaskCards.forEach(card => {
            card.removeEventListener('dragstart', this.handleDragStart);
            card.removeEventListener('dragend', this.handleDragEnd);
        });
        
        marketingKanbanBodies.forEach(column => {
            column.removeEventListener('dragover', this.handleDragOver);
            column.removeEventListener('drop', this.handleDrop);
            column.removeEventListener('dragenter', this.handleDragEnter);
            column.removeEventListener('dragleave', this.handleDragLeave);
        });
        
        this.isInitialized = false;
        console.log('Marketing Kanban destroyed');
    }
}

// Auto-initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on a Marketing Kanban page
    if (document.querySelector('.marketing-kanban-board')) {
        // Initialize with Marketing settings
        window.marketingKanban = new MarketingKanban({
            onStatusUpdate: function(taskId, newStatus, data) {
                console.log('Marketing Status updated:', taskId, newStatus, data);
            },
            onError: function(error) {
                console.error('Marketing Kanban Error:', error);
            }
        });
    }
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = MarketingKanban;
}
