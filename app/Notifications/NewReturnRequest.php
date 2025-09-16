<?php

namespace App\Notifications;

use App\Models\ReturnRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewReturnRequest extends Notification
{
    use Queueable;

    protected $returnRequest;

    /**
     * Create a new notification instance.
     */
    public function __construct(ReturnRequest $returnRequest)
    {
        $this->returnRequest = $returnRequest;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database']; // Gửi cả email và notification database
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Yêu cầu hoàn hàng mới')
            ->line('Người dùng: ' . $this->returnRequest->user->name . ' đã gửi yêu cầu hoàn/trả hàng.')
            ->line('Đơn hàng #' . $this->returnRequest->order->id)
            ->action('Xem yêu cầu', url(route('admin.returns.edit', $this->returnRequest->id)))
            ->line('Vui lòng xử lý sớm.');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Yêu cầu hoàn hàng mới',
            'user' => $this->returnRequest->user->name,
            'order_id' => $this->returnRequest->order_id,
            'return_request_id' => $this->returnRequest->id,
            'url' => route('admin.returns.edit', $this->returnRequest->id),
        ];
    }
}
