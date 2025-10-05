/**
 * Trello Drag and Drop System
 * نظام السحب والإفلات لـ Trello
 * 
 * Features:
 * - Drag and drop cards between columns
 * - Real-time status updates via AJAX
 * - Visual feedback during drag operations
 * - Responsive design support
 * - Error handling and notifications
 */

class TrelloDragDrop {
    constructor(options = {}) {
        this.options = {
            csrfToken: null,
            updateUrl: null,
            cardSelector: '.trello-card',
            columnSelector: '.trello-column',
            columnBodySelector: '.trello-column-body',
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
        console.log('Trello Drag and Drop initialized');
    }
    
    getCSRFToken() {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 
               document.querySelector('input[name="_token"]')?.value;
    }
    
    initializeDragAndDrop() {
        const trelloCards = document.querySelectorAll(this.options.cardSelector);
        const trelloColumnBodies = document.querySelectorAll(this.options.columnBodySelector);
        
        console.log('Initializing Trello drag and drop for', trelloCards.length, 'cards and', trelloColumnBodies.length, 'columns');
        
        // Add drag events to cards
        trelloCards.forEach(card => {
            card.addEventListener('dragstart', (e) => this.handleDragStart(e));
            card.addEventListener('dragend', (e) => this.handleDragEnd(e));
        });
        
        // Add drop events to columns
        trelloColumnBodies.forEach(column => {
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
        
        console.log('Drag started for task:', e.target.dataset.taskId);
    }
    
    handleDragEnd(e) {
        // Remove dragging class
        e.target.classList.remove('dragging');
        
        // Remove all drag-over classes
        document.querySelectorAll(this.options.columnBodySelector).forEach(column => {
            column.classList.remove('drag-over');
        });
        
        this.draggedCard = null;
        this.draggedCardOriginalParent = null;
        
        console.log('Drag ended');
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
            
            console.log('Moving task', taskId, 'from', oldStatus, 'to', newStatus);
            
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
                
                console.log('Task moved successfully');
            } else {
                console.log('Same status, no update needed');
            }
        }
    }
    
    updateColumnCounters() {
        const columns = document.querySelectorAll(this.options.columnSelector);
        columns.forEach(column => {
            const body = column.querySelector(this.options.columnBodySelector);
            const header = column.querySelector(this.options.columnSelector + '-header');
            const badge = header.querySelector('.badge');
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
        let updateUrl = this.options.updateUrl || `/tasks/${taskId}/status`;
        
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
        const trelloCards = document.querySelectorAll(this.options.cardSelector);
        const trelloColumnBodies = document.querySelectorAll(this.options.columnBodySelector);
        
        // Remove all event listeners
        trelloCards.forEach(card => {
            card.removeEventListener('dragstart', this.handleDragStart);
            card.removeEventListener('dragend', this.handleDragEnd);
        });
        
        trelloColumnBodies.forEach(column => {
            column.removeEventListener('dragover', this.handleDragOver);
            column.removeEventListener('drop', this.handleDrop);
            column.removeEventListener('dragenter', this.handleDragEnter);
            column.removeEventListener('dragleave', this.handleDragLeave);
        });
        
        this.isInitialized = false;
        console.log('Trello Drag and Drop destroyed');
    }
}

// Auto-initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on a Marketing Trello page
    if (document.querySelector('.marketing-trello-board')) {
        // Initialize with Marketing settings
        window.marketingTrello = new TrelloDragDrop({
            cardSelector: '.marketing-trello-card',
            columnSelector: '.marketing-trello-column',
            columnBodySelector: '.marketing-trello-column-body',
            updateUrl: '/marketing/tasks/{taskId}/status',
            onStatusUpdate: function(taskId, newStatus, data) {
                console.log('Marketing Status updated:', taskId, newStatus, data);
            },
            onError: function(error) {
                console.error('Marketing Trello Drag Drop Error:', error);
            }
        });
    }
    
    // Check if we're on a Sales Trello page
    if (document.querySelector('.sales-trello-board')) {
        // Initialize with Sales settings
        window.salesTrello = new TrelloDragDrop({
            cardSelector: '.sales-trello-card',
            columnSelector: '.sales-trello-column',
            columnBodySelector: '.sales-trello-column-body',
            updateUrl: '/sales/tasks/{taskId}/status',
            onStatusUpdate: function(taskId, newStatus, data) {
                console.log('Sales Status updated:', taskId, newStatus, data);
            },
            onError: function(error) {
                console.error('Sales Trello Drag Drop Error:', error);
            }
        });
    }
    
    // Fallback for old trello-board class
    if (document.querySelector('.trello-board') && !document.querySelector('.marketing-trello-board') && !document.querySelector('.sales-trello-board')) {
        // Initialize with default settings
        window.trelloDragDrop = new TrelloDragDrop({
            onStatusUpdate: function(taskId, newStatus, data) {
                console.log('Status updated:', taskId, newStatus, data);
            },
            onError: function(error) {
                console.error('Trello Drag Drop Error:', error);
            }
        });
    }
});

// Export for use in other scripts
if (typeof module !== 'undefined' && module.exports) {
    module.exports = TrelloDragDrop;
}
