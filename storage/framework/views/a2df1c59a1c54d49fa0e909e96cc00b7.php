<!-- معلومات جهة الاتصال -->
<div class="conversation-header p-3 bg-light border-bottom">
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <div class="conversation-avatar me-3">
                <i class="fas fa-user-circle fa-2x text-primary"></i>
            </div>
            <div>
                <h6 class="mb-0"><?php echo e($contact['name'] ?? 'جهة اتصال غير معروفة'); ?></h6>
                <small class="text-muted"><?php echo e($phoneNumber); ?></small>
                <?php if($contact): ?>
                    <span class="badge bg-<?php echo e($contact['type'] === 'importer' ? 'warning' : ($contact['type'] === 'marketing' ? 'info' : ($contact['type'] === 'sales' ? 'success' : 'primary'))); ?> ms-2">
                        <?php echo e($contact['type'] === 'importer' ? 'مستورد' : ($contact['type'] === 'marketing' ? 'تسويق' : ($contact['type'] === 'sales' ? 'مبيعات' : 'عميل'))); ?>

                    </span>
                <?php endif; ?>
            </div>
        </div>
        <div class="conversation-actions">
            <button class="btn btn-sm btn-outline-primary" onclick="openWhatsApp('<?php echo e($phoneNumber); ?>')">
                <i class="fab fa-whatsapp me-1"></i>
                فتح في الواتساب
            </button>
        </div>
    </div>
</div>

<!-- منطقة الرسائل -->
<div class="messages-area" style="height: 400px; overflow-y: auto; padding: 1rem;">
    <?php if($messages->count() > 0): ?>
        <?php $__currentLoopData = $messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="message-item mb-3 <?php echo e($message->direction === 'outbound' ? 'text-end' : 'text-start'); ?>">
                <div class="message-bubble d-inline-block p-3 rounded <?php echo e($message->direction === 'outbound' ? 'bg-primary text-white' : 'bg-light'); ?>" style="max-width: 70%;">
                    <div class="message-content">
                        <?php echo e($message->message_content); ?>

                    </div>
                    <div class="message-meta mt-2">
                        <small class="<?php echo e($message->direction === 'outbound' ? 'text-white-50' : 'text-muted'); ?>">
                            <?php echo e($message->sent_at->format('H:i')); ?>

                            <?php if($message->direction === 'outbound'): ?>
                                <i class="fas fa-check<?php echo e($message->status === 'read' ? '-double' : ''); ?> ms-1"></i>
                            <?php endif; ?>
                        </small>
                    </div>
                </div>
                <?php if($message->direction === 'inbound'): ?>
                    <div class="message-sender mt-1">
                        <small class="text-muted">
                            <?php echo e($message->contact_name); ?>

                        </small>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div class="text-center py-4">
            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
            <h6 class="text-muted">لا توجد رسائل</h6>
            <p class="text-muted mb-0">ابدأ المحادثة بإرسال رسالة</p>
        </div>
    <?php endif; ?>
</div>

<!-- منطقة إرسال الرسالة -->
<div class="message-input p-3 border-top">
    <form id="sendMessageForm" class="d-flex gap-2">
        <input type="hidden" name="to_number" value="<?php echo e($phoneNumber); ?>">
        <input type="hidden" name="contact_type" value="<?php echo e($contact['type'] ?? 'external'); ?>">
        <input type="hidden" name="contact_id" value="<?php echo e($contact['id'] ?? ''); ?>">
        
        <div class="flex-grow-1">
            <textarea name="message_content" class="form-control" rows="2" placeholder="اكتب رسالتك..." required></textarea>
        </div>
        <div class="d-flex flex-column gap-1">
            <button type="submit" class="btn btn-primary">
                <i class="fab fa-whatsapp"></i>
            </button>
            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="attachFile()">
                <i class="fas fa-paperclip"></i>
            </button>
        </div>
    </form>
</div>

<script>
    // إرسال رسالة
    document.getElementById('sendMessageForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const messageContent = formData.get('message_content');
        
        if (!messageContent.trim()) {
            return;
        }
        
        // إضافة الرسالة فوراً إلى الواجهة
        addMessageToUI(messageContent, 'outbound');
        
        // إرسال الرسالة عبر AJAX
        fetch('/admin/whatsapp/send', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // مسح حقل النص
                this.querySelector('textarea[name="message_content"]').value = '';
                
                // تحديث حالة الرسالة
                updateMessageStatus(data.data.id, 'delivered');
            } else {
                // إزالة الرسالة من الواجهة في حالة الفشل
                removeLastMessage();
                alert('حدث خطأ في إرسال الرسالة');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            removeLastMessage();
            alert('حدث خطأ في إرسال الرسالة');
        });
    });

    // إضافة رسالة إلى الواجهة
    function addMessageToUI(content, direction) {
        const messagesArea = document.querySelector('.messages-area');
        const messageId = 'msg_' + Date.now();
        
        const messageHTML = `
            <div class="message-item mb-3 ${direction === 'outbound' ? 'text-end' : 'text-start'}" data-message-id="${messageId}">
                <div class="message-bubble d-inline-block p-3 rounded ${direction === 'outbound' ? 'bg-primary text-white' : 'bg-light'}" style="max-width: 70%;">
                    <div class="message-content">
                        ${content}
                    </div>
                    <div class="message-meta mt-2">
                        <small class="${direction === 'outbound' ? 'text-white-50' : 'text-muted'}">
                            ${new Date().toLocaleTimeString('ar-SA', {hour: '2-digit', minute: '2-digit'})}
                            ${direction === 'outbound' ? '<i class="fas fa-check ms-1"></i>' : ''}
                        </small>
                    </div>
                </div>
            </div>
        `;
        
        messagesArea.insertAdjacentHTML('beforeend', messageHTML);
        messagesArea.scrollTop = messagesArea.scrollHeight;
    }

    // تحديث حالة الرسالة
    function updateMessageStatus(messageId, status) {
        const messageElement = document.querySelector(`[data-message-id="${messageId}"]`);
        if (messageElement) {
            const checkIcon = messageElement.querySelector('.fa-check');
            if (checkIcon && status === 'read') {
                checkIcon.classList.add('fa-double');
            }
        }
    }

    // إزالة آخر رسالة (في حالة الفشل)
    function removeLastMessage() {
        const messagesArea = document.querySelector('.messages-area');
        const lastMessage = messagesArea.querySelector('.message-item:last-child');
        if (lastMessage) {
            lastMessage.remove();
        }
    }

    // فتح الواتساب
    function openWhatsApp(phoneNumber) {
        const cleanNumber = phoneNumber.replace(/[^0-9]/g, '');
        const whatsappUrl = `https://wa.me/${cleanNumber}`;
        window.open(whatsappUrl, '_blank');
    }

    // جعل الدالة متاحة عالمياً
    window.openWhatsApp = openWhatsApp;

    // إرفاق ملف
    function attachFile() {
        // يمكن تطوير هذه الوظيفة لاحقاً
        alert('وظيفة إرفاق الملفات قيد التطوير');
    }

    // التمرير إلى آخر رسالة
    document.addEventListener('DOMContentLoaded', function() {
        const messagesArea = document.querySelector('.messages-area');
        if (messagesArea) {
            messagesArea.scrollTop = messagesArea.scrollHeight;
        }
    });
</script>

<style>
.message-bubble {
    word-wrap: break-word;
}

.message-item {
    animation: fadeIn 0.3s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.conversation-avatar {
    text-align: center;
}

.messages-area {
    scrollbar-width: thin;
    scrollbar-color: #ccc #f1f1f1;
}

.messages-area::-webkit-scrollbar {
    width: 6px;
}

.messages-area::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.messages-area::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 3px;
}

.messages-area::-webkit-scrollbar-thumb:hover {
    background: #999;
}
</style><?php /**PATH F:\infinity\Infinity-Wear\resources\views/admin/whatsapp/conversation.blade.php ENDPATH**/ ?>