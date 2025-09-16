<?php

namespace App\Notifications;

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderStatusUpdated extends Notification
{
    use Queueable;

    protected $order;
    protected $newStatus;

    public function __construct($order, $newStatus)
    {
        $this->order = $order;
        $this->newStatus = $newStatus;
    }

    public function via($notifiable)
    {
        return ['database']; // hoặc thêm 'mail' nếu cần
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'status' => $this->newStatus,
            'message' => 'Đơn hàng #' . $this->order->id . ' đã được cập nhật trạng thái: ' . $this->getStatusLabel(),
            'type'     => 'order',
            'can_confirm_received' => $this->newStatus === 'completed',
        ];
    }

    protected function getStatusLabel()
    {
        return match ($this->newStatus) {
            'pending' => 'Chờ xử lý',
            'confirmed' => 'Đã xác nhận',
            'processing' => 'Đang giao hàng',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã huỷ',
            default => 'Không xác định'
        };
    }

}
