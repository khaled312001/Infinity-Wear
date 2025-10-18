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
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: formData
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
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
            if (error.message.includes('JSON')) {
                this.showAlert('error', 'خطأ في استجابة الخادم. يرجى المحاولة مرة أخرى.');
            } else {
                this.showAlert('error', 'حدث خطأ أثناء إنشاء اللوحة: ' + error.message);
            }
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
                    'Accept': 'application/json',
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
                // عرض رسائل الخطأ التفصيلية
                let errorMessage = result.message || 'حدث خطأ أثناء إنشاء المهمة';
                
                if (result.errors) {
                    const errorDetails = Object.values(result.errors).flat().join('<br>');
                    errorMessage += '<br><br>التفاصيل:<br>' + errorDetails;
                }
                
                this.showAlert('error', errorMessage);
            }
        } catch (error) {
            console.error('Error creating task:', error);
            
            // Handle different types of errors
            if (error.message.includes('Unexpected token')) {
                this.showAlert('error', 'حدث خطأ في استجابة الخادم. يرجى المحاولة مرة أخرى.');
            } else if (error.message.includes('Failed to fetch')) {
                this.showAlert('error', 'فشل في الاتصال بالخادم. يرجى التحقق من الاتصال بالإنترنت.');
            } else {
                this.showAlert('error', 'حدث خطأ أثناء إنشاء المهمة');
            }
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

    viewTask(taskId) {
        console.log('Viewing task:', taskId);
        // حفظ معرف المهمة للاستخدام لاحقاً
        window.currentTaskId = taskId;
        // تحميل بيانات المهمة وعرضها
        this.loadTaskData(taskId).then(taskData => {
            this.displayTaskView(taskData);
            this.showModal('viewTaskModal');
        }).catch(error => {
            console.error('Error loading task:', error);
            this.showAlert('error', 'خطأ في تحميل بيانات المهمة');
        });
    }

    editTask(taskId) {
        console.log('Editing task:', taskId);
        // تحميل بيانات المهمة وتعديلها
        this.loadTaskData(taskId).then(taskData => {
            this.displayTaskEdit(taskData);
            this.showModal('editTaskModal');
        }).catch(error => {
            console.error('Error loading task:', error);
            this.showAlert('error', 'خطأ في تحميل بيانات المهمة');
        });
    }

    async loadTaskData(taskId) {
        // محاكاة تحميل بيانات المهمة
        // في التطبيق الحقيقي، ستكون هذه استدعاء AJAX
        return new Promise((resolve) => {
            // البحث عن المهمة في البيانات المحملة
            const boards = window.boardsData || [];
            let foundTask = null;
            
            for (const board of boards) {
                for (const column of board.columns || []) {
                    for (const task of column.tasks || []) {
                        if (task.id == taskId) {
                            foundTask = task;
                            break;
                        }
                    }
                    if (foundTask) break;
                }
                if (foundTask) break;
            }
            
            if (foundTask) {
                resolve(foundTask);
            } else {
                // بيانات وهمية للاختبار
                resolve({
                    id: taskId,
                    title: 'مهمة تجريبية',
                    description: 'هذه مهمة تجريبية للاختبار',
                    priority: 'high',
                    status: 'pending',
                    due_date: null,
                    labels: [],
                    checklist: [],
                    progress_percentage: 0
                });
            }
        });
    }

    displayTaskView(taskData) {
        const content = document.getElementById('viewTaskContent');
        if (!content) return;

        content.innerHTML = `
            <div class="task-view">
                <div class="row">
                    <div class="col-md-8">
                        <h4>${taskData.title}</h4>
                        <p class="text-muted">${taskData.description || 'لا يوجد وصف'}</p>
                    </div>
                    <div class="col-md-4">
                        <div class="task-meta">
                            <div class="mb-2">
                                <strong>الأولوية:</strong>
                                <span class="badge bg-${this.getPriorityColor(taskData.priority)}">${this.getPriorityLabel(taskData.priority)}</span>
                            </div>
                            <div class="mb-2">
                                <strong>الحالة:</strong>
                                <span class="badge bg-${this.getStatusColor(taskData.status)}">${this.getStatusLabel(taskData.status)}</span>
                            </div>
                            <div class="mb-2">
                                <strong>التقدم:</strong>
                                <div class="progress">
                                    <div class="progress-bar" style="width: ${taskData.progress_percentage || 0}%"></div>
                                </div>
                                <small>${taskData.progress_percentage || 0}%</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    displayTaskEdit(taskData) {
        const content = document.getElementById('editTaskContent');
        if (!content) return;

        content.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="editTaskTitle" class="form-label">عنوان المهمة</label>
                        <input type="text" class="form-control" id="editTaskTitle" name="title" value="${taskData.title}" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="editTaskPriority" class="form-label">الأولوية</label>
                        <select class="form-select" id="editTaskPriority" name="priority">
                            <option value="low" ${taskData.priority === 'low' ? 'selected' : ''}>منخفضة</option>
                            <option value="medium" ${taskData.priority === 'medium' ? 'selected' : ''}>متوسطة</option>
                            <option value="high" ${taskData.priority === 'high' ? 'selected' : ''}>عالية</option>
                            <option value="urgent" ${taskData.priority === 'urgent' ? 'selected' : ''}>عاجلة</option>
                            <option value="critical" ${taskData.priority === 'critical' ? 'selected' : ''}>حرجة</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="editTaskDescription" class="form-label">وصف المهمة</label>
                <textarea class="form-control" id="editTaskDescription" name="description" rows="3">${taskData.description || ''}</textarea>
            </div>
            <input type="hidden" id="editTaskId" name="task_id" value="${taskData.id}">
        `;
    }

    getPriorityColor(priority) {
        const colors = {
            'low': 'success',
            'medium': 'warning',
            'high': 'danger',
            'urgent': 'danger',
            'critical': 'dark'
        };
        return colors[priority] || 'secondary';
    }

    getPriorityLabel(priority) {
        const labels = {
            'low': 'منخفضة',
            'medium': 'متوسطة',
            'high': 'عالية',
            'urgent': 'عاجلة',
            'critical': 'حرجة'
        };
        return labels[priority] || priority;
    }

    getStatusColor(status) {
        const colors = {
            'pending': 'warning',
            'in_progress': 'primary',
            'completed': 'success',
            'cancelled': 'danger',
            'on_hold': 'secondary'
        };
        return colors[status] || 'secondary';
    }

    getStatusLabel(status) {
        const labels = {
            'pending': 'معلقة',
            'in_progress': 'قيد التنفيذ',
            'completed': 'مكتملة',
            'cancelled': 'ملغية',
            'on_hold': 'معلقة'
        };
        return labels[status] || status;
    }

    // دوال الفلتر المتقدم
    applyAdvancedFilter() {
        const filters = this.getFilterValues();
        const filteredTasks = this.filterTasks(filters);
        this.displayFilteredTasks(filteredTasks);
        this.updateFilterResultsCount(filteredTasks.length);
    }

    getFilterValues() {
        return {
            user: document.getElementById('filterByUser')?.value || '',
            department: document.getElementById('filterByDepartment')?.value || '',
            priority: document.getElementById('filterByPriority')?.value || '',
            status: document.getElementById('filterByStatus')?.value || '',
            keyword: document.getElementById('filterByKeyword')?.value || '',
            dateFrom: document.getElementById('filterByDateFrom')?.value || '',
            dateTo: document.getElementById('filterByDateTo')?.value || ''
        };
    }

    filterTasks(filters) {
        const boards = window.boardsData || [];
        const allTasks = [];
        
        // جمع جميع المهام
        boards.forEach(board => {
            if (board.columns) {
                board.columns.forEach(column => {
                    if (column.tasks) {
                        column.tasks.forEach(task => {
                            allTasks.push({
                                ...task,
                                boardName: board.name,
                                columnName: column.name
                            });
                        });
                    }
                });
            }
        });

        // تطبيق الفلاتر
        return allTasks.filter(task => {
            // فلتر المستخدم
            if (filters.user) {
                const [userType, userId] = filters.user.split('_');
                if (userType === 'admin' && task.assigned_to != userId) return false;
                if (userType === 'marketing' && task.assigned_to != userId) return false;
                if (userType === 'sales' && task.assigned_to != userId) return false;
            }

            // فلتر القسم
            if (filters.department && task.department !== filters.department) {
                return false;
            }

            // فلتر الأولوية
            if (filters.priority && task.priority !== filters.priority) {
                return false;
            }

            // فلتر الحالة
            if (filters.status && task.status !== filters.status) {
                return false;
            }

            // فلتر الكلمات المفتاحية
            if (filters.keyword) {
                const keyword = filters.keyword.toLowerCase();
                const title = (task.title || '').toLowerCase();
                const description = (task.description || '').toLowerCase();
                if (!title.includes(keyword) && !description.includes(keyword)) {
                    return false;
                }
            }

            // فلتر التاريخ
            if (filters.dateFrom || filters.dateTo) {
                const taskDate = new Date(task.due_date || task.created_at);
                if (filters.dateFrom) {
                    const fromDate = new Date(filters.dateFrom);
                    if (taskDate < fromDate) return false;
                }
                if (filters.dateTo) {
                    const toDate = new Date(filters.dateTo);
                    toDate.setHours(23, 59, 59, 999); // نهاية اليوم
                    if (taskDate > toDate) return false;
                }
            }

            return true;
        });
    }

    displayFilteredTasks(filteredTasks) {
        // إخفاء جميع المهام
        const allTaskCards = document.querySelectorAll('.task-card');
        allTaskCards.forEach(card => {
            card.style.display = 'none';
        });

        // إظهار المهام المفلترة فقط
        filteredTasks.forEach(task => {
            const taskCard = document.querySelector(`[data-task-id="${task.id}"]`);
            if (taskCard) {
                taskCard.style.display = 'block';
            }
        });

        // إخفاء الأعمدة الفارغة
        const allColumns = document.querySelectorAll('.task-column');
        allColumns.forEach(column => {
            const visibleTasks = column.querySelectorAll('.task-card[style*="block"], .task-card:not([style*="none"])');
            if (visibleTasks.length === 0) {
                column.style.display = 'none';
            } else {
                column.style.display = 'block';
            }
        });
    }

    updateFilterResultsCount(count) {
        const countElement = document.getElementById('filterResultsCount');
        if (countElement) {
            countElement.textContent = `${count} نتيجة`;
        }
    }

    clearAdvancedFilter() {
        // مسح جميع الفلاتر
        document.getElementById('filterByUser').value = '';
        document.getElementById('filterByDepartment').value = '';
        document.getElementById('filterByPriority').value = '';
        document.getElementById('filterByStatus').value = '';
        document.getElementById('filterByKeyword').value = '';
        document.getElementById('filterByDateFrom').value = '';
        document.getElementById('filterByDateTo').value = '';

        // إظهار جميع المهام
        const allTaskCards = document.querySelectorAll('.task-card');
        allTaskCards.forEach(card => {
            card.style.display = 'block';
        });

        // إظهار جميع الأعمدة
        const allColumns = document.querySelectorAll('.task-column');
        allColumns.forEach(column => {
            column.style.display = 'block';
        });

        // تحديث عداد النتائج
        this.updateFilterResultsCount(allTaskCards.length);
    }

    exportFilteredTasks() {
        const filters = this.getFilterValues();
        const filteredTasks = this.filterTasks(filters);
        
        if (filteredTasks.length === 0) {
            this.showAlert('warning', 'لا توجد مهام للتصدير');
            return;
        }

        // إنشاء CSV
        const csvContent = this.generateCSV(filteredTasks);
        
        // تحميل الملف
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);
        link.setAttribute('href', url);
        link.setAttribute('download', `filtered_tasks_${new Date().toISOString().split('T')[0]}.csv`);
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        
        this.showAlert('success', 'تم تصدير المهام بنجاح');
    }

    generateCSV(tasks) {
        const headers = ['المعرف', 'العنوان', 'الوصف', 'الأولوية', 'الحالة', 'القسم', 'اللوحة', 'العمود', 'تاريخ الاستحقاق'];
        const csvRows = [headers.join(',')];
        
        tasks.forEach(task => {
            const row = [
                task.id,
                `"${task.title || ''}"`,
                `"${task.description || ''}"`,
                this.getPriorityLabel(task.priority),
                this.getStatusLabel(task.status),
                task.department || '',
                `"${task.boardName || ''}"`,
                `"${task.columnName || ''}"`,
                task.due_date || ''
            ];
            csvRows.push(row.join(','));
        });
        
        return csvRows.join('\n');
    }

    addTask(columnId) {
        console.log('Adding task to column:', columnId);
        // تنفيذ إضافة مهمة جديدة
        this.showAlert('info', 'إضافة مهمة جديدة للعمود رقم: ' + columnId);
        // يمكن إضافة منطق إضافة المهمة هنا
    }

    showModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        }
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

// دوال مساعدة للاستخدام في HTML
function viewTask(taskId) {
    console.log('View task:', taskId);
    // تنفيذ عرض المهمة
    if (window.taskManagement) {
        window.taskManagement.viewTask(taskId);
    }
}

function editTask(taskId) {
    console.log('Edit task:', taskId);
    // تنفيذ تعديل المهمة
    if (window.taskManagement) {
        window.taskManagement.editTask(taskId);
    }
}

function addTask(columnId) {
    console.log('Add task to column:', columnId);
    // تنفيذ إضافة مهمة جديدة
    if (window.taskManagement) {
        window.taskManagement.addTask(columnId);
    }
}

function addColumn(boardId) {
    console.log('Add column to board:', boardId);
    // تنفيذ إضافة عمود جديد
    if (window.taskManagement) {
        window.taskManagement.addColumn(boardId);
    }
}

function createBoard() {
    console.log('Create new board');
    // تنفيذ إنشاء لوحة جديدة
    if (window.taskManagement) {
        window.taskManagement.showModal('createBoardModal');
    }
}

function editTaskFromView() {
    // إغلاق مودال المعاينة وفتح مودال التعديل
    if (window.taskManagement) {
        window.taskManagement.closeModal('viewTaskModal');
        // الحصول على معرف المهمة من البيانات المحملة
        const taskId = window.currentTaskId;
        if (taskId) {
            window.taskManagement.editTask(taskId);
        }
    }
}

// دوال الفلتر المتقدم
function applyAdvancedFilter() {
    if (window.taskManagement) {
        window.taskManagement.applyAdvancedFilter();
    }
}

function clearAdvancedFilter() {
    if (window.taskManagement) {
        window.taskManagement.clearAdvancedFilter();
    }
}

function exportFilteredTasks() {
    if (window.taskManagement) {
        window.taskManagement.exportFilteredTasks();
    }
}

function deleteTask(taskId) {
    if (window.taskManagement) {
        window.taskManagement.deleteTask(taskId);
    }
}
