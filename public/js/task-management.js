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
                // التحقق من الصلاحيات للسحب والإفلات
                if (window.isLimitedView) {
                    const assignedTo = e.target.dataset.assignedTo;
                    const assignedToType = e.target.dataset.assignedToType;
                    const currentUserId = window.currentUserId;
                    const currentUserType = window.currentUserType;
                    
                    // السماح بالسحب فقط للمهام المخصصة للمستخدم الحالي
                    if (assignedTo != currentUserId || assignedToType != currentUserType) {
                        e.preventDefault();
                        this.showAlert('warning', 'يمكنك فقط تحريك المهام المخصصة لك');
                        return false;
                    }
                }
                
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
        
        // تحديد المسار الصحيح حسب نوع المستخدم
        let moveUrl = '/admin/tasks/' + taskId + '/move';
        if (window.isLimitedView) {
            if (window.currentUserType === 'sales') {
                moveUrl = '/sales/tasks/' + taskId + '/move';
            } else if (window.currentUserType === 'marketing') {
                moveUrl = '/marketing/tasks/' + taskId + '/move';
            }
        }
        
        try {
            const response = await fetch(moveUrl, {
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
                this.showAlert('success', 'تم تحديث حالة المهمة بنجاح');
            } else {
                this.showAlert('error', result.message || 'حدث خطأ أثناء تحديث حالة المهمة');
            }
        } catch (error) {
            console.error('Error moving task:', error);
            this.showAlert('error', 'حدث خطأ أثناء تحديث حالة المهمة');
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
        const currentUserId = window.currentUserId || null;
        const currentUserType = window.currentUserType || null;
        
        taskCards.forEach(card => {
            let show = true;
            
            switch (filter) {
                case 'my':
                    // إظهار المهام المخصصة للمستخدم الحالي فقط
                    if (currentUserId && currentUserType) {
                        const assignedTo = card.dataset.assignedTo;
                        const assignedToType = card.dataset.assignedToType;
                        show = assignedTo == currentUserId && assignedToType == currentUserType;
                    }
                    break;
                case 'urgent':
                    show = card.querySelector('.fa-fire') !== null;
                    break;
                case 'overdue':
                    show = card.querySelector('.due-date.overdue') !== null;
                    break;
                case 'all':
                default:
                    // للصفحات المحدودة (sales/marketing) إظهار مهام المستخدم فقط
                    if (window.isLimitedView && currentUserId && currentUserType) {
                        const assignedTo = card.dataset.assignedTo;
                        const assignedToType = card.dataset.assignedToType;
                        show = assignedTo == currentUserId && assignedToType == currentUserType;
                    } else {
                        show = true;
                    }
                    break;
            }
            
            card.style.display = show ? 'block' : 'none';
        });
        
        // تحديث عداد المهام في كل عمود
        this.updateTaskCounts();
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
        // حفظ معرف المهمة الحالية
        window.currentEditingTask = { id: taskId };
        
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

        // تحديد ما إذا كان المستخدم يمكنه التعديل أم لا
        const canEdit = !window.isLimitedView;
        const isAssignedToUser = window.isLimitedView && 
            taskData.assigned_to == window.currentUserId && 
            taskData.assigned_to_type == window.currentUserType;

        content.innerHTML = `
            <div class="task-view">
                <div class="row">
                    <div class="col-md-8">
                        <h4>${taskData.title}</h4>
                        <p class="text-muted">${taskData.description || 'لا يوجد وصف'}</p>
                        ${!isAssignedToUser && window.isLimitedView ? 
                            '<div class="alert alert-warning"><i class="fas fa-exclamation-triangle me-2"></i>هذه المهمة غير مخصصة لك</div>' : 
                            ''
                        }
                    </div>
                    <div class="col-md-4">
                        <div class="task-meta">
                            <div class="mb-2">
                                <strong>الأولوية:</strong>
                                <span class="badge bg-${this.getPriorityColor ? this.getPriorityColor(taskData.priority) : (typeof getPriorityColor === 'function' ? getPriorityColor(taskData.priority) : this.getPriorityColorFallback(taskData.priority))}">${this.getPriorityLabel ? this.getPriorityLabel(taskData.priority) : (typeof getPriorityLabel === 'function' ? getPriorityLabel(taskData.priority) : this.getPriorityLabelFallback(taskData.priority))}</span>
                            </div>
                            <div class="mb-2">
                                <strong>الحالة:</strong>
                                <span class="badge bg-${this.getStatusColor ? this.getStatusColor(taskData.status) : (typeof getStatusColor === 'function' ? getStatusColor(taskData.status) : this.getStatusColorFallback(taskData.status))}">${this.getStatusLabel ? this.getStatusLabel(taskData.status) : (typeof getStatusLabel === 'function' ? getStatusLabel(taskData.status) : this.getStatusLabelFallback(taskData.status))}</span>
                            </div>
                            <div class="mb-2">
                                <strong>التقدم:</strong>
                                <div class="progress">
                                    <div class="progress-bar" style="width: ${taskData.progress_percentage || 0}%"></div>
                                </div>
                                <small>${taskData.progress_percentage || 0}%</small>
                            </div>
                            ${taskData.due_date ? `
                                <div class="mb-2">
                                    <strong>تاريخ الاستحقاق:</strong>
                                    <span class="text-muted">${taskData.due_date}</span>
                                </div>
                            ` : ''}
                            ${taskData.assignedUser ? `
                                <div class="mb-2">
                                    <strong>المخصص إلى:</strong>
                                    <span class="text-muted">${taskData.assignedUser.name}</span>
                                </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
                ${window.isLimitedView ? `
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                <strong>ملاحظة:</strong> يمكنك فقط تغيير حالة المهمة (سحب وإفلات) وإضافة تعليقات. 
                                ${!isAssignedToUser ? 'هذه المهمة غير مخصصة لك.' : ''}
                            </div>
                        </div>
                    </div>
                ` : ''}
            </div>
        `;
    }

    displayTaskEdit(taskData) {
        // ملء النموذج ببيانات المهمة
        this.fillEditForm(taskData);
        
        // تحميل الأعمدة للوحة المحددة
        this.loadColumnsForBoard(taskData.board_id);
        
        // تحميل التعليقات والمرفقات
        this.loadTaskComments(taskData.id);
        this.loadTaskAttachments(taskData.id);
        this.loadTaskChecklist(taskData.id);
    }

    fillEditForm(taskData) {
        // ملء الحقول الأساسية
        document.getElementById('editTaskTitle').value = taskData.title || '';
        document.getElementById('editTaskDescription').value = taskData.description || '';
        document.getElementById('editTaskPriority').value = taskData.priority || 'medium';
        document.getElementById('editTaskStatus').value = taskData.status || 'pending';
        document.getElementById('editTaskDueDate').value = taskData.due_date || '';
        document.getElementById('editTaskAssignedTo').value = taskData.assigned_to || '';
        document.getElementById('editTaskEstimatedHours').value = taskData.estimated_hours || '';
        document.getElementById('editTaskColor').value = taskData.color || '#007bff';
        document.getElementById('editTaskProgress').value = taskData.progress_percentage || 0;
        document.getElementById('editTaskUrgent').checked = taskData.is_urgent || false;
        document.getElementById('editTaskBoard').value = taskData.board_id || '';

        // ملء العلامات
        this.displayTaskLabels(taskData.labels || []);
        
        // ملء الوسوم
        this.displayTaskTags(taskData.tags || []);
    }

    loadColumnsForBoard(boardId) {
        const columnSelect = document.getElementById('editTaskColumn');
        if (!columnSelect) return;

        // البحث عن الأعمدة للوحة المحددة
        const boards = window.boardsData || [];
        let columns = [];
        
        for (const board of boards) {
            if (board.id == boardId) {
                columns = board.columns || [];
                break;
            }
        }

        // ملء قائمة الأعمدة
        columnSelect.innerHTML = '';
        columns.forEach(column => {
            const option = document.createElement('option');
            option.value = column.id;
            option.textContent = column.name;
            columnSelect.appendChild(option);
        });

        // تحديد العمود الحالي
        if (window.currentEditingTask) {
            columnSelect.value = window.currentEditingTask.column_id || '';
        }
    }

    displayTaskLabels(labels) {
        const container = document.getElementById('editTaskLabels');
        if (!container) return;

        container.innerHTML = '';
        labels.forEach(label => {
            const labelElement = document.createElement('span');
            labelElement.className = 'badge bg-secondary me-1 mb-1';
            labelElement.style.backgroundColor = label.color || '#6c757d';
            labelElement.innerHTML = `${label.name} <i class="fas fa-times ms-1" onclick="removeTaskLabel('${label.name}')"></i>`;
            container.appendChild(labelElement);
        });
    }

    displayTaskTags(tags) {
        const container = document.getElementById('editTaskTags');
        if (!container) return;

        container.innerHTML = '';
        tags.forEach(tag => {
            const tagElement = document.createElement('span');
            tagElement.className = 'badge bg-info me-1 mb-1';
            tagElement.innerHTML = `${tag} <i class="fas fa-times ms-1" onclick="removeTaskTag('${tag}')"></i>`;
            container.appendChild(tagElement);
        });
    }

    async loadTaskComments(taskId) {
        const container = document.getElementById('editTaskComments');
        if (!container) return;

        try {
            const response = await fetch(`/admin/tasks/${taskId}/comments`);
            const data = await response.json();
            
            container.innerHTML = '';
            if (data.comments && data.comments.length > 0) {
                data.comments.forEach(comment => {
                    const commentElement = document.createElement('div');
                    commentElement.className = 'border-bottom pb-2 mb-2';
                    commentElement.innerHTML = `
                        <div class="d-flex justify-content-between">
                            <strong>${comment.author_name}</strong>
                            <small class="text-muted">${comment.created_at}</small>
                        </div>
                        <p class="mb-0">${comment.comment}</p>
                    `;
                    container.appendChild(commentElement);
                });
            } else {
                container.innerHTML = '<p class="text-muted">لا توجد تعليقات</p>';
            }
        } catch (error) {
            console.error('Error loading comments:', error);
            container.innerHTML = '<p class="text-muted">خطأ في تحميل التعليقات</p>';
        }
    }

    async loadTaskAttachments(taskId) {
        const container = document.getElementById('editTaskAttachments');
        if (!container) return;

        try {
            const response = await fetch(`/admin/tasks/${taskId}/attachments`);
            const data = await response.json();
            
            container.innerHTML = '';
            if (data.attachments && data.attachments.length > 0) {
                data.attachments.forEach(attachment => {
                    const attachmentElement = document.createElement('div');
                    attachmentElement.className = 'd-flex justify-content-between align-items-center border-bottom pb-2 mb-2';
                    attachmentElement.innerHTML = `
                        <div>
                            <i class="fas fa-paperclip me-2"></i>
                            <a href="/storage/${attachment.file_path}" target="_blank">${attachment.original_name}</a>
                            <small class="text-muted d-block">${this.formatFileSize(attachment.file_size)}</small>
                        </div>
                        <button class="btn btn-sm btn-outline-danger" onclick="removeTaskAttachment(${attachment.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                    container.appendChild(attachmentElement);
                });
            } else {
                container.innerHTML = '<p class="text-muted">لا توجد مرفقات</p>';
            }
        } catch (error) {
            console.error('Error loading attachments:', error);
            container.innerHTML = '<p class="text-muted">خطأ في تحميل المرفقات</p>';
        }
    }

    async loadTaskChecklist(taskId) {
        const container = document.getElementById('editTaskChecklist');
        if (!container) return;

        try {
            const response = await fetch(`/admin/tasks/${taskId}/checklist`);
            const data = await response.json();
            
            container.innerHTML = '';
            if (data.checklist && data.checklist.length > 0) {
                data.checklist.forEach((item, index) => {
                    const itemElement = document.createElement('div');
                    itemElement.className = 'form-check';
                    itemElement.innerHTML = `
                        <input class="form-check-input" type="checkbox" id="checklist_${index}" ${item.completed ? 'checked' : ''} 
                               onchange="updateChecklistItem('${item.id}', this.checked)">
                        <label class="form-check-label" for="checklist_${index}">
                            ${item.text}
                        </label>
                    `;
                    container.appendChild(itemElement);
                });
            } else {
                container.innerHTML = '<p class="text-muted">لا توجد عناصر في القائمة المرجعية</p>';
            }
        } catch (error) {
            console.error('Error loading checklist:', error);
            container.innerHTML = '<p class="text-muted">خطأ في تحميل القائمة المرجعية</p>';
        }
    }

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // دوال مساعدة للتعامل مع المهام
    addTaskLabel() {
        const input = document.getElementById('editTaskNewLabel');
        const labelName = input.value.trim();
        if (!labelName) return;

        const container = document.getElementById('editTaskLabels');
        const labelElement = document.createElement('span');
        labelElement.className = 'badge bg-secondary me-1 mb-1';
        labelElement.style.backgroundColor = this.getRandomColor();
        labelElement.innerHTML = `${labelName} <i class="fas fa-times ms-1" onclick="removeTaskLabel('${labelName}')"></i>`;
        container.appendChild(labelElement);

        input.value = '';
    }

    addTaskTag() {
        const input = document.getElementById('editTaskNewTag');
        const tagName = input.value.trim();
        if (!tagName) return;

        const container = document.getElementById('editTaskTags');
        const tagElement = document.createElement('span');
        tagElement.className = 'badge bg-info me-1 mb-1';
        tagElement.innerHTML = `${tagName} <i class="fas fa-times ms-1" onclick="removeTaskTag('${tagName}')"></i>`;
        container.appendChild(tagElement);

        input.value = '';
    }

    removeTaskLabel(labelName) {
        const labels = document.querySelectorAll('#editTaskLabels .badge');
        labels.forEach(label => {
            if (label.textContent.includes(labelName)) {
                label.remove();
            }
        });
    }

    removeTaskTag(tagName) {
        const tags = document.querySelectorAll('#editTaskTags .badge');
        tags.forEach(tag => {
            if (tag.textContent.includes(tagName)) {
                tag.remove();
            }
        });
    }

    async addTaskComment() {
        const input = document.getElementById('editTaskNewComment');
        const comment = input.value.trim();
        if (!comment) return;

        const taskId = window.currentEditingTask?.id;
        if (!taskId) return;

        try {
            const response = await fetch(`/admin/tasks/${taskId}/comment`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ comment })
            });

            const data = await response.json();
            if (data.success) {
                this.loadTaskComments(taskId);
                input.value = '';
                this.showAlert('success', 'تم إضافة التعليق بنجاح');
            } else {
                this.showAlert('error', data.message || 'خطأ في إضافة التعليق');
            }
        } catch (error) {
            console.error('Error adding comment:', error);
            this.showAlert('error', 'خطأ في إضافة التعليق');
        }
    }

    async addTaskAttachment() {
        const input = document.getElementById('editTaskNewAttachment');
        const files = input.files;
        if (!files || files.length === 0) return;

        const taskId = window.currentEditingTask?.id;
        if (!taskId) return;

        const formData = new FormData();
        Array.from(files).forEach(file => {
            formData.append('files[]', file);
        });

        try {
            const response = await fetch(`/admin/tasks/${taskId}/attachment`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const data = await response.json();
            if (data.success) {
                this.loadTaskAttachments(taskId);
                input.value = '';
                this.showAlert('success', 'تم رفع المرفقات بنجاح');
            } else {
                this.showAlert('error', data.message || 'خطأ في رفع المرفقات');
            }
        } catch (error) {
            console.error('Error adding attachment:', error);
            this.showAlert('error', 'خطأ في رفع المرفقات');
        }
    }

    async addTaskChecklistItem() {
        const input = document.getElementById('editTaskNewChecklistItem');
        const text = input.value.trim();
        if (!text) return;

        const taskId = window.currentEditingTask?.id;
        if (!taskId) return;

        try {
            const response = await fetch(`/admin/tasks/${taskId}/checklist`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ text })
            });

            const data = await response.json();
            if (data.success) {
                this.loadTaskChecklist(taskId);
                input.value = '';
                this.showAlert('success', 'تم إضافة العنصر للقائمة المرجعية');
            } else {
                this.showAlert('error', data.message || 'خطأ في إضافة العنصر');
            }
        } catch (error) {
            console.error('Error adding checklist item:', error);
            this.showAlert('error', 'خطأ في إضافة العنصر');
        }
    }

    getRandomColor() {
        const colors = ['#007bff', '#28a745', '#dc3545', '#ffc107', '#17a2b8', '#6f42c1', '#e83e8c', '#fd7e14'];
        return colors[Math.floor(Math.random() * colors.length)];
    }

    // دالة حفظ التعديلات
    async saveTaskEdit() {
        const taskId = window.currentEditingTask?.id;
        if (!taskId) return;

        const formData = new FormData(document.getElementById('editTaskForm'));
        
        // إضافة العلامات والوسوم
        const labels = Array.from(document.querySelectorAll('#editTaskLabels .badge')).map(badge => ({
            name: badge.textContent.replace(' ×', '').trim(),
            color: badge.style.backgroundColor || '#6c757d'
        }));
        
        const tags = Array.from(document.querySelectorAll('#editTaskTags .badge')).map(badge => 
            badge.textContent.replace(' ×', '').trim()
        );

        formData.append('labels', JSON.stringify(labels));
        formData.append('tags', JSON.stringify(tags));

        try {
            const response = await fetch(`/admin/tasks/${taskId}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            });

            const data = await response.json();
            if (data.success) {
                this.showAlert('success', 'تم حفظ التغييرات بنجاح');
                this.hideModal('editTaskModal');
                // إعادة تحميل الصفحة أو تحديث المهام
                location.reload();
            } else {
                this.showAlert('error', data.message || 'خطأ في حفظ التغييرات');
            }
        } catch (error) {
            console.error('Error saving task:', error);
            this.showAlert('error', 'خطأ في حفظ التغييرات');
        }
    }

    // Helper methods for priority and status
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

    // Fallback methods in case the main methods don't exist
    getPriorityColorFallback(priority) {
        const colors = {
            'low': 'success',
            'medium': 'warning',
            'high': 'danger',
            'urgent': 'danger',
            'critical': 'dark'
        };
        return colors[priority] || 'secondary';
    }

    getPriorityLabelFallback(priority) {
        const labels = {
            'low': 'منخفضة',
            'medium': 'متوسطة',
            'high': 'عالية',
            'urgent': 'عاجلة',
            'critical': 'حرجة'
        };
        return labels[priority] || priority;
    }

    getStatusColorFallback(status) {
        const colors = {
            'pending': 'warning',
            'in_progress': 'primary',
            'completed': 'success',
            'cancelled': 'danger',
            'on_hold': 'secondary'
        };
        return colors[status] || 'secondary';
    }

    getStatusLabelFallback(status) {
        const labels = {
            'pending': 'معلقة',
            'in_progress': 'قيد التنفيذ',
            'completed': 'مكتملة',
            'cancelled': 'ملغية',
            'on_hold': 'معلقة'
        };
        return labels[status] || status;
    }
}

// دوال عامة للتعامل مع المهام
window.taskManagement = new TaskManagement();

// دوال مساعدة عامة
function addTaskLabel() {
    window.taskManagement.addTaskLabel();
}

function addTaskTag() {
    window.taskManagement.addTaskTag();
}

function removeTaskLabel(labelName) {
    window.taskManagement.removeTaskLabel(labelName);
}

function removeTaskTag(tagName) {
    window.taskManagement.removeTaskTag(tagName);
}

function addTaskComment() {
    window.taskManagement.addTaskComment();
}

function addTaskAttachment() {
    window.taskManagement.addTaskAttachment();
}

function addTaskChecklistItem() {
    window.taskManagement.addTaskChecklistItem();
}

function editTask(taskId) {
    window.taskManagement.editTask(taskId);
}

function viewTask(taskId) {
    window.taskManagement.viewTask(taskId);
}

function deleteTask(taskId) {
    window.taskManagement.deleteTask(taskId);
}

function moveTask(taskId, columnId) {
    window.taskManagement.moveTask(taskId, columnId);
}

function saveTaskEdit() {
    window.taskManagement.saveTaskEdit();
}

    // تهيئة النظام عند تحميل الصفحة
    document.addEventListener('DOMContentLoaded', function() {
        if (window.taskManagement) {
            window.taskManagement.init();
        }
        initializeUserAssignmentSelects();
    });

    // تهيئة قوائم تعيين المستخدمين
    function initializeUserAssignmentSelects() {
        const selects = document.querySelectorAll('.user-assignment-select');
        
        selects.forEach(select => {
            // إضافة بحث في القائمة
            select.addEventListener('focus', function() {
                this.style.fontSize = '14px';
            });
            
            select.addEventListener('blur', function() {
                this.style.fontSize = '16px';
            });
            
            // إضافة تأثير بصري عند التغيير
            select.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    this.style.borderColor = '#28a745';
                    this.style.backgroundColor = '#f8fff9';
                    
                    // إظهار معلومات المستخدم المحدد
                    showSelectedUserInfo(selectedOption);
                } else {
                    this.style.borderColor = '#ced4da';
                    this.style.backgroundColor = '#fff';
                    hideSelectedUserInfo();
                }
            });
        });
    }

    // إظهار معلومات المستخدم المحدد
    function showSelectedUserInfo(option) {
        const userType = option.getAttribute('data-type');
        const userName = option.textContent.split(' - ')[0];
        const userEmail = option.textContent.split(' - ')[1];
        
        // إنشاء عنصر معلومات المستخدم
        let infoElement = document.getElementById('selected-user-info');
        if (!infoElement) {
            infoElement = document.createElement('div');
            infoElement.id = 'selected-user-info';
            infoElement.className = 'selected-user-info mt-2 p-2 rounded';
            infoElement.style.backgroundColor = '#e3f2fd';
            infoElement.style.border = '1px solid #bbdefb';
            infoElement.style.fontSize = '0.9rem';
            
            // إضافة العنصر بعد القائمة
            const select = option.closest('select');
            select.parentNode.appendChild(infoElement);
        }
        
        // تحديد لون حسب نوع المستخدم
        const colors = {
            'admin': { bg: '#f8d7da', border: '#f5c6cb', text: '#721c24' },
            'marketing': { bg: '#d1ecf1', border: '#bee5eb', text: '#0c5460' },
            'sales': { bg: '#d4edda', border: '#c3e6cb', text: '#155724' },
            'employee': { bg: '#e2e3e5', border: '#d6d8db', text: '#383d41' }
        };
        
        const color = colors[userType] || colors['employee'];
        infoElement.style.backgroundColor = color.bg;
        infoElement.style.borderColor = color.border;
        infoElement.style.color = color.text;
        
        // إضافة المحتوى
        const typeLabels = {
            'admin': '👑 الإدارة',
            'marketing': '📈 التسويق',
            'sales': '💰 المبيعات',
            'employee': '👥 موظف'
        };
        
        infoElement.innerHTML = `
            <div class="d-flex align-items-center">
                <span class="me-2">${typeLabels[userType] || '👤 مستخدم'}</span>
                <div>
                    <strong>${userName}</strong><br>
                    <small>${userEmail}</small>
                </div>
            </div>
        `;
    }

    // إخفاء معلومات المستخدم المحدد
    function hideSelectedUserInfo() {
        const infoElement = document.getElementById('selected-user-info');
        if (infoElement) {
            infoElement.remove();
        }
    }

    // تبديل البحث المتقدم
    function toggleUserSearch(searchInputId, selectId) {
        const searchInput = document.getElementById(searchInputId);
        const select = document.getElementById(selectId);
        
        if (searchInput.style.display === 'none') {
            searchInput.style.display = 'block';
            searchInput.focus();
            initializeUserSearch(searchInput, select);
        } else {
            searchInput.style.display = 'none';
            searchInput.value = '';
            resetUserSelect(select);
        }
    }

    // تهيئة البحث في المستخدمين
    function initializeUserSearch(searchInput, select) {
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const options = select.querySelectorAll('option');
            
            options.forEach(option => {
                const text = option.textContent.toLowerCase();
                if (text.includes(searchTerm) || searchTerm === '') {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none';
                }
            });
            
            // إخفاء/إظهار المجموعات حسب النتائج
            const optgroups = select.querySelectorAll('optgroup');
            optgroups.forEach(group => {
                const visibleOptions = group.querySelectorAll('option[style*="block"], option:not([style*="none"])');
                if (visibleOptions.length === 0 && searchTerm !== '') {
                    group.style.display = 'none';
                } else {
                    group.style.display = 'block';
                }
            });
        });
    }

    // إعادة تعيين قائمة المستخدمين
    function resetUserSelect(select) {
        const options = select.querySelectorAll('option');
        const optgroups = select.querySelectorAll('optgroup');
        
        options.forEach(option => {
            option.style.display = 'block';
        });
        
        optgroups.forEach(group => {
            group.style.display = 'block';
        });
    }

    function getPriorityColor(priority) {
        const colors = {
            'low': 'success',
            'medium': 'warning',
            'high': 'danger',
            'urgent': 'danger',
            'critical': 'dark'
        };
        return colors[priority] || 'secondary';
    }

    function getPriorityLabel(priority) {
        const labels = {
            'low': 'منخفضة',
            'medium': 'متوسطة',
            'high': 'عالية',
            'urgent': 'عاجلة',
            'critical': 'حرجة'
        };
        return labels[priority] || priority;
    }

    function getStatusColor(status) {
        const colors = {
            'pending': 'warning',
            'in_progress': 'primary',
            'completed': 'success',
            'cancelled': 'danger',
            'on_hold': 'secondary'
        };
        return colors[status] || 'secondary';
    }

    function getStatusLabel(status) {
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
    function applyAdvancedFilter() {
        const filters = getFilterValues();
        const filteredTasks = filterTasks(filters);
        displayFilteredTasks(filteredTasks);
        updateFilterResultsCount(filteredTasks.length);
    }

    function getFilterValues() {
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

    function filterTasks(filters) {
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

    function displayFilteredTasks(filteredTasks) {
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

    function updateFilterResultsCount(count) {
        const countElement = document.getElementById('filterResultsCount');
        if (countElement) {
            countElement.textContent = `${count} نتيجة`;
        }
    }

    function clearAdvancedFilter() {
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
        updateFilterResultsCount(allTaskCards.length);
    }

    function exportFilteredTasks() {
        const filters = getFilterValues();
        const filteredTasks = filterTasks(filters);
        
        if (filteredTasks.length === 0) {
            showAlert('warning', 'لا توجد مهام للتصدير');
            return;
        }

        // إنشاء CSV
        const csvContent = generateCSV(filteredTasks);
        
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
        
        showAlert('success', 'تم تصدير المهام بنجاح');
    }

    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 
                          type === 'warning' ? 'alert-warning' : 
                          type === 'info' ? 'alert-info' : 'alert-danger';
        const iconClass = type === 'success' ? 'fa-check-circle' : 
                         type === 'warning' ? 'fa-exclamation-triangle' : 
                         type === 'info' ? 'fa-info-circle' : 'fa-exclamation-circle';
        
        const alert = document.createElement('div');
        alert.className = `alert ${alertClass} alert-dismissible fade show`;
        alert.innerHTML = `
            <i class="fas ${iconClass} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        
        // إضافة التنبيه إلى أعلى الصفحة
        const container = document.querySelector('.container-fluid') || document.body;
        if (container) {
            container.insertBefore(alert, container.firstChild);
        }
        
        // إزالة التنبيه تلقائياً بعد 5 ثوان
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }

    function generateCSV(tasks) {
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

    function addTask(columnId) {
        console.log('Adding task to column:', columnId);
        // تنفيذ إضافة مهمة جديدة
        showAlert('info', 'إضافة مهمة جديدة للعمود رقم: ' + columnId);
        // يمكن إضافة منطق إضافة المهمة هنا
    }

    function showModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        }
    }

    function hideModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            const bsModal = bootstrap.Modal.getInstance(modal);
            if (bsModal) {
                bsModal.hide();
            }
        }
    }

    async function updateChecklistItem(itemId, completed) {
        try {
            const response = await fetch(`/admin/tasks/checklist/${itemId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ completed })
            });

            const data = await response.json();
            if (data.success) {
                showAlert('success', 'تم تحديث العنصر بنجاح');
            } else {
                showAlert('error', data.message || 'خطأ في تحديث العنصر');
            }
        } catch (error) {
            console.error('Error updating checklist item:', error);
            showAlert('error', 'خطأ في تحديث العنصر');
        }
    }

    async function loadTaskAttachments(taskId) {
        try {
            const response = await fetch(`/admin/tasks/${taskId}/attachments`);
            const data = await response.json();
            if (data.success) {
                displayTaskAttachments(data.attachments);
            }
        } catch (error) {
            console.error('Error loading attachments:', error);
        }
    }

    function displayTaskAttachments(attachments) {
        const container = document.getElementById('editTaskAttachments');
        if (!container) return;
        
        container.innerHTML = '';
        if (attachments && attachments.length > 0) {
            attachments.forEach(attachment => {
                const attachmentElement = document.createElement('div');
                attachmentElement.className = 'd-flex justify-content-between align-items-center p-2 border rounded mb-2';
                attachmentElement.innerHTML = `
                    <div>
                        <i class="fas fa-paperclip me-2"></i>
                        <a href="${attachment.file_url}" target="_blank" class="text-decoration-none">
                            ${attachment.original_name}
                        </a>
                        <small class="text-muted d-block">${formatFileSize(attachment.file_size)}</small>
                    </div>
                    <button class="btn btn-sm btn-outline-danger" onclick="removeTaskAttachment(${attachment.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                `;
                container.appendChild(attachmentElement);
            });
        }
    }

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    async function removeTaskAttachment(attachmentId) {
        if (!confirm('هل أنت متأكد من حذف هذا المرفق؟')) {
            return;
        }

        try {
            const response = await fetch(`/admin/tasks/attachment/${attachmentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            const data = await response.json();
            if (data.success) {
                showAlert('success', 'تم حذف المرفق بنجاح');
                // إعادة تحميل المرفقات
                if (window.currentEditingTask) {
                    loadTaskAttachments(window.currentEditingTask.id);
                }
            } else {
                showAlert('error', data.message || 'خطأ في حذف المرفق');
            }
        } catch (error) {
            console.error('Error removing attachment:', error);
            showAlert('error', 'خطأ في حذف المرفق');
        }
    }

// دوال مساعدة للاستخدام في HTML
function addColumn(boardId) {
    // تنفيذ إضافة عمود جديد
    console.log('Add column for board:', boardId);
}


function editBoard(boardId) {
    // تنفيذ تعديل اللوحة
    console.log('Edit board:', boardId);
}





// تهيئة النظام عند تحميل الصفحة
function initializeTaskManagement() {
    if (!window.taskManagement) {
        window.taskManagement = new TaskManagement();
    }
    return window.taskManagement;
}

// تصدير الكلاس للاستخدام العام
window.TaskManagement = TaskManagement;

// دوال مساعدة للاستخدام في HTML



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

