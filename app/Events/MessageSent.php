<?php

namespace App\Events;

use App\Models\Message;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * Tạo event khi gửi tin nhắn
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Channel riêng tư theo người nhận
     */
    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->message->receiver_id);
    }

    /**
     * Tên sự kiện
     */
    public function broadcastAs()
    {
        return 'MessageSent';
    }

    /**
     * Dữ liệu truyền qua realtime
     */
    public function broadcastWith()
    {
        return [
            'id' => $this->message->id,
            'sender_id' => $this->message->user_id,
            'receiver_id' => $this->message->receiver_id,
            'content' => $this->message->content,
            'created_at' => $this->message->created_at->format('H:i:s d/m/Y'),
        ];
    }
}
