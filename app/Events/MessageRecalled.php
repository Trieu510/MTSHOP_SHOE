<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageRecalled implements ShouldBroadcastNow
{
    use Dispatchable, SerializesModels;

    public $id;
    public $sender_id;
    public $receiver_id;

    /**
     * Tạo event khi thu hồi tin nhắn
     */
    public function __construct(Message $message)
    {
        $this->id = $message->id;
        $this->sender_id = $message->user_id;
        $this->receiver_id = $message->receiver_id;
    }

    /**
     * 🔸 Phát tới cả kênh của người gửi và người nhận
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel('chat.' . $this->receiver_id),
            new PrivateChannel('chat.' . $this->sender_id),
        ];
    }

    /**
     * Tên sự kiện
     */
    public function broadcastAs()
    {
        return 'MessageRecalled';
    }

    /**
     * Dữ liệu gửi đi qua Pusher / Laravel Echo
     */
    public function broadcastWith()
    {
        return [
            'id' => $this->id,
        ];
    }
}
