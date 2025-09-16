<?php

namespace App\Notifications;

use App\Models\ReturnRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewReturnRequestNotification extends Notification
{
    use Queueable;

    public $returnRequest;

    public function __construct(ReturnRequest $returnRequest)
    {
        $this->returnRequest = $returnRequest;
    }

    public function via($notifiable)
    {
        return ['database', 'mail']; // Gửi qua cả hệ thống và email
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Yêu cầu hoàn hàng mới')
                    ->line('Một yêu cầu hoàn hàng mới đã được gửi từ người dùng: ' . $this->returnRequest->user->name)
                    ->action('Xem chi tiết', url(route('admin.returns.index')))
                    ->line('Cảm ơn bạn đã sử dụng hệ thống.');
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Yêu cầu hoàn hàng mới từ ' . $this->returnRequest->user->name,
            'return_request_id' => $this->returnRequest->id,
            'order_id' => $this->returnRequest->order_id,
        ];
    }
}
