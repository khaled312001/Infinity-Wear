<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationStatsUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $stats;
    public $userType;
    public $userId;

    /**
     * Create a new event instance.
     */
    public function __construct($stats, $userType = 'admin', $userId = null)
    {
        $this->stats = $stats;
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
        $channels[] = new Channel("notifications.{$this->userType}.stats");
        
        // قناة خاصة للمستخدم المحدد إذا كان موجوداً
        if ($this->userId) {
            $channels[] = new PrivateChannel("notifications.user.{$this->userId}.stats");
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
            'stats' => $this->stats,
            'user_type' => $this->userType,
            'updated_at' => now()->toISOString(),
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'notification.stats.updated';
    }
}
