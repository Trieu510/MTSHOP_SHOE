<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class NewOrderNotification extends Notification
{
    use Queueable;

    public $order;

    /**
     * Tạo mới notification với đơn hàng.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Kênh gửi thông báo (email).
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database']; // ← thêm database
    }

    /**
     * Nội dung email gửi đi.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('🛒 Đơn hàng mới #' . $this->order->id)
            ->greeting('Xin chào Admin,')
            ->line('Bạn vừa nhận được một đơn hàng mới từ khách hàng:')
            ->line('Tên: ' . $this->order->name)
            ->line('SĐT: ' . $this->order->phone)
            ->line('Tổng tiền: ' . number_format($this->order->total_amount) . 'đ')
            ->line('Phương thức thanh toán: ' . strtoupper($this->order->payment_method))
            ->action('Xem chi tiết đơn hàng', route('admin.orders.show', $this->order->id))
            ->line('Cảm ơn bạn đã sử dụng hệ thống.');
    }

    /**
     * Dữ liệu dạng array (nếu dùng lưu DB).
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'name'     => $this->order->name,
            'phone'    => $this->order->phone,
        ];
    }
}
