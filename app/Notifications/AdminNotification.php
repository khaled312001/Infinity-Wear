<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\AdminNotification as AdminNotificationModel;

class AdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $adminNotification;

    /**
     * Create a new notification instance.
     */
    public function __construct(AdminNotificationModel $adminNotification)
    {
        $this->adminNotification = $adminNotification;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        $channels = ['database'];
        
        // إضافة الإيميل إذا كان مطلوب
        if (in_array($this->adminNotification->type, ['email', 'both'])) {
            $channels[] = 'mail';
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->adminNotification->title)
            ->greeting('مرحباً ' . $notifiable->name)
            ->line($this->adminNotification->message)
            ->when($this->adminNotification->email_content, function ($mail) {
                return $mail->line($this->adminNotification->email_content);
            })
            ->action('عرض التفاصيل', url('/dashboard'))
            ->line('شكراً لاستخدامك منصتنا!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => $this->adminNotification->title,
            'message' => $this->adminNotification->message,
            'type' => $this->adminNotification->type,
            'priority' => $this->adminNotification->priority,
            'category' => $this->adminNotification->category,
            'admin_notification_id' => $this->adminNotification->id,
            'icon' => $this->getIcon(),
            'color' => $this->getColor(),
        ];
    }

    /**
     * الحصول على الأيقونة المناسبة
     */
    private function getIcon(): string
    {
        return match($this->adminNotification->priority) {
            'urgent' => 'fas fa-exclamation-triangle',
            'high' => 'fas fa-exclamation-circle',
            'normal' => 'fas fa-bell',
            'low' => 'fas fa-info-circle',
            default => 'fas fa-bell'
        };
    }

    /**
     * الحصول على اللون المناسب
     */
    private function getColor(): string
    {
        return match($this->adminNotification->priority) {
            'urgent' => 'danger',
            'high' => 'warning',
            'normal' => 'primary',
            'low' => 'success',
            default => 'primary'
        };
    }
}
