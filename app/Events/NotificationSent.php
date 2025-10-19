<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Notification;

class NotificationSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;
    public $userType;
    public $userId;

    /**
     * Create a new event instance.
     */
    public function __construct(Notification $notification, $userType = 'admin', $userId = null)
    {
        $this->notification = $notification;
        $this->userType = $userType;
        $this->userId = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $channels = [];
        
        // قناة عامة لجميع المستخدمين من نفس النوع
        $channels[] = new Channel("notifications.{$this->userType}");
        
        // قناة خاصة للمستخدم المحدد إذا كان موجوداً
        if ($this->userId) {
            $channels[] = new PrivateChannel("notifications.user.{$this->userId}");
        }
        
        return $channels;
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith(): array
    {
        return [
            'id' => $this->notification->id,
            'type' => $this->notification->type,
            'title' => $this->notification->title,
            'message' => $this->notification->message,
            'icon' => $this->notification->icon,
            'color' => $this->notification->color,
            'data' => $this->notification->data,
            'created_at' => $this->notification->created_at->toISOString(),
            'user_type' => $this->userType,
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'notification.sent';
    }
}
