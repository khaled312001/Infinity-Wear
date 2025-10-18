/**
 * نظام إدارة المهام - JavaScript
 * يوفر وظائف السحب والإفلات والتفاعل مع الواجهة
 */

class TaskManagement {
    constructor() {
        this.draggedElement = null;
        this.draggedColumn = null;
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupDragAndDrop();
        this.setupModals();
        this.setupFilters();
    }

    setupEventListeners() {
        // إنشاء لوحة جديدة
        document.getElementById('createBoardForm')?.addEventListener('submit', (e) => {
            e.preventDefault();
            this.createBoard();
        });

        // إنشاء مهمة جديدة
        document.getElementById('createTaskForm')?.addEventListener('submit', (e) => {
            e.preventDefault();
            this.createTask();
        });

        // تحديث العمود عند تغيير اللوحة
        document.getElementById('taskBoard')?.addEventListener('change', (e) => {
            this.updateColumnsForBoard(e.target.value);
        });
    }

    setupDragAndDrop() {
        // إعداد السحب والإفلات للمهام
        document.addEventListener('dragstart', (e) => {
            if (e.target.classList.contains('task-card')) {
                this.draggedElement = e.target;
                e.target.classList.add('dragging');
                
                // إضافة تأثير بصري
                e.dataTransfer.effectAllowed = 'move';
                e.dataTransfer.setData('text/html', e.target.outerHTML);
            }
        });

        document.addEventListener('dragend', (e) => {
            if (e.target.classList.contains('task-card')) {
                e.target.classList.remove('dragging');
                this.draggedElement = null;
            }
        });

        // إعداد مناطق الإفلات
        document.addEventListener('dragover', (e) => {
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
        });

        document.addEventListener('dragenter', (e) => {
            if (e.target.classList.contains('column-content')) {
                e.target.classList.add('drag-over');
            }
        });

        document.addEventListener('dragleave', (e) => {
            if (e.target.classList.contains('column-content')) {
                e.target.classList.remove('drag-over');
            }
        });

        document.addEventListener('drop', (e) => {
            e.preventDefault();
            
            if (e.target.classList.contains('column-content') && this.draggedElement) {
                e.target.classList.remove('drag-over');
                this.moveTaskToColumn(e.target, this.draggedElement);
            }
        });
    }

    setupModals() {
        // إعداد المودالز
        const modals = document.querySelectorAll('.modal');
        modals.forEach(modal => {
            modal.addEventListener('hidden.bs.modal', () => {
                const form = modal.querySelector('form');
                if (form) {
                    form.reset();
                }
            });
        });
    }

    setupFilters() {
        // إعداد التصفية
        const filterButtons = document.querySelectorAll('[onclick^="filterTasks"]');
        filterButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const filter = button.getAttribute('onclick').match(/'([^']+)'/)[1];
                this.filterTasks(filter);
            });
        });
    }

    async createBoard() {
        const form = document.getElementById('createBoardForm');
        const formData = new FormData(form);
        
        try {
            const response = await fetch('/admin/tasks/board', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(Object.fromEntries(formData))
            });

            const result = await response.json();
            
            if (result.success) {
                this.showAlert('success', result.message);
                this.closeModal('createBoardModal');
                location.reload(); // إعادة تحميل الصفحة لعرض اللوحة الجديدة
            } else {
                this.showAlert('error', result.message || 'حدث خطأ أثناء إنشاء اللوحة');
            }
        } catch (error) {
            console.error('Error creating board:', error);
            this.showAlert('error', 'حدث خطأ أثناء إنشاء اللوحة');
        }
    }

    async createTask() {
        const form = document.getElementById('createTaskForm');
        const formData = new FormData(form);
        
        // إضافة نوع المعين
        const assignedTo = document.getElementById('taskAssignedTo');
        if (assignedTo.value) {
            const selectedOption = assignedTo.options[assignedTo.selectedIndex];
            formData.append('assigned_to_type', selectedOption.dataset.type);
        }

        try {
            const response = await fetch('/admin/tasks', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(Object.fromEntries(formData))
            });

            const result = await response.json();
            
            if (result.success) {
                this.showAlert('success', result.message);
                this.closeModal('createTaskModal');
                location.reload(); // إعادة تحميل الصفحة لعرض المهمة الجديدة
            } else {
                this.showAlert('error', result.message || 'حدث خطأ أثناء إنشاء المهمة');
            }
        } catch (error) {
            console.error('Error creating task:', error);
            this.showAlert('error', 'حدث خطأ أثناء إنشاء المهمة');
        }
    }

    async moveTaskToColumn(targetColumn, draggedElement) {
        const taskId = draggedElement.dataset.taskId;
        const columnId = targetColumn.dataset.columnId || targetColumn.closest('.task-column').dataset.columnId;
        
        try {
            const response = await fetch(`/admin/tasks/${taskId}/move`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    column_id: columnId
                })
            });

            const result = await response.json();
            
            if (result.success) {
                // نقل العنصر بصرياً
                targetColumn.appendChild(draggedElement);
                this.updateTaskCounts();
            } else {
                this.showAlert('error', result.message || 'حدث خطأ أثناء نقل المهمة');
            }
        } catch (error) {
            console.error('Error moving task:', error);
            this.showAlert('error', 'حدث خطأ أثناء نقل المهمة');
        }
    }

    async updateTask(taskId, data) {
        try {
            const response = await fetch(`/admin/tasks/${taskId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();
            
            if (result.success) {
                this.showAlert('success', result.message);
                return result.task;
            } else {
                this.showAlert('error', result.message || 'حدث خطأ أثناء تحديث المهمة');
                return null;
            }
        } catch (error) {
            console.error('Error updating task:', error);
            this.showAlert('error', 'حدث خطأ أثناء تحديث المهمة');
            return null;
        }
    }

    async deleteTask(taskId) {
        if (!confirm('هل أنت متأكد من حذف هذه المهمة؟')) {
            return;
        }

        try {
            const response = await fetch(`/admin/tasks/${taskId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const result = await response.json();
            
            if (result.success) {
                this.showAlert('success', result.message);
                document.querySelector(`[data-task-id="${taskId}"]`)?.remove();
                this.updateTaskCounts();
            } else {
                this.showAlert('error', result.message || 'حدث خطأ أثناء حذف المهمة');
            }
        } catch (error) {
            console.error('Error deleting task:', error);
            this.showAlert('error', 'حدث خطأ أثناء حذف المهمة');
        }
    }

    updateColumnsForBoard(boardId) {
        // تحديث قائمة الأعمدة عند تغيير اللوحة
        const columnSelect = document.getElementById('taskColumn');
        if (!columnSelect) return;

        // إزالة الخيارات الحالية
        columnSelect.innerHTML = '';

        // إضافة خيارات جديدة (يجب جلبها من الخادم)
        // هذا مثال بسيط - في التطبيق الحقيقي يجب جلب البيانات من الخادم
        const boards = window.boardsData || [];
        const selectedBoard = boards.find(board => board.id == boardId);
        
        if (selectedBoard && selectedBoard.columns) {
            selectedBoard.columns.forEach(column => {
                const option = document.createElement('option');
                option.value = column.id;
                option.textContent = column.name;
                columnSelect.appendChild(option);
            });
        }
    }

    filterTasks(filter) {
        const taskCards = document.querySelectorAll('.task-card');
        
        taskCards.forEach(card => {
            let show = true;
            
            switch (filter) {
                case 'my':
                    // إظهار المهام المخصصة للمستخدم الحالي فقط
                    // يجب تنفيذ هذا المنطق حسب احتياجات التطبيق
                    break;
                case 'urgent':
                    show = card.querySelector('.fa-fire') !== null;
                    break;
                case 'overdue':
                    show = card.querySelector('.due-date.overdue') !== null;
                    break;
                case 'all':
                default:
                    show = true;
                    break;
            }
            
            card.style.display = show ? 'block' : 'none';
        });
    }

    updateTaskCounts() {
        // تحديث عداد المهام في كل عمود
        document.querySelectorAll('.task-column').forEach(column => {
            const taskCount = column.querySelectorAll('.task-card').length;
            const countElement = column.querySelector('.task-count');
            if (countElement) {
                countElement.textContent = taskCount;
            }
        });
    }

    showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
        
        const alert = document.createElement('div');
        alert.className = `alert ${alertClass} alert-dismissible fade show`;
        alert.innerHTML = `
            <i class="fas ${iconClass} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // إضافة التنبيه في أعلى الصفحة
        const container = document.querySelector('.container-fluid') || document.querySelector('.container');
        if (container) {
            container.insertBefore(alert, container.firstChild);
        }
        
        // إزالة التنبيه تلقائياً بعد 5 ثوان
        setTimeout(() => {
            alert.remove();
        }, 5000);
    }

    closeModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            const bsModal = bootstrap.Modal.getInstance(modal);
            if (bsModal) {
                bsModal.hide();
            }
        }
    }

    addColumn() {
        // تنفيذ إضافة عمود جديد
        console.log('Add column');
        // يمكن إضافة منطق إضافة العمود هنا
    }
}

// دوال مساعدة للاستخدام في HTML
function addColumn(boardId) {
    // تنفيذ إضافة عمود جديد
    console.log('Add column for board:', boardId);
}

function addTask(columnId) {
    // فتح مودال إنشاء مهمة جديدة مع تحديد العمود
    const modal = new bootstrap.Modal(document.getElementById('createTaskModal'));
    document.getElementById('taskColumn').value = columnId;
    modal.show();
}

function editBoard(boardId) {
    // تنفيذ تعديل اللوحة
    console.log('Edit board:', boardId);
}

function viewTask(taskId) {
    // تنفيذ عرض تفاصيل المهمة
    console.log('View task:', taskId);
}

function editTask(taskId) {
    // تنفيذ تعديل المهمة
    console.log('Edit task:', taskId);
}

function filterTasks(filter) {
    // تنفيذ تصفية المهام
    if (window.taskManagement) {
        window.taskManagement.filterTasks(filter);
    }
}


// تهيئة النظام عند تحميل الصفحة
function initializeTaskManagement() {
    window.taskManagement = new TaskManagement();
}

// تصدير الكلاس للاستخدام العام
window.TaskManagement = TaskManagement;
