<?php

namespace App\Notifications;

use App\Models\ReturnRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReturnStatusUpdatedNotification extends Notification
{
    use Queueable;

    public $returnRequest;

    public function __construct(ReturnRequest $returnRequest)
    {
        $this->returnRequest = $returnRequest;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        $orderId = $this->returnRequest->order->id;
        $status = ucfirst($this->returnRequest->status);
        $url = route('returns.show', $this->returnRequest->id);
        $statusColor = $this->getStatusColor();
        $statusIcon = $this->getStatusIcon();

        return (new MailMessage)
            ->subject("🔁 Cập nhật yêu cầu hoàn hàng #$orderId")
            ->markdown('emails.return_status_updated', [
                'user' => $notifiable,
                'orderId' => $orderId,
                'status' => $status,
                'statusColor' => $statusColor,
                'statusIcon' => $statusIcon,
                'url' => $url,
            ]);
    }

    public function toArray($notifiable)
    {
        return [
            'type' => 'return',
            'message' => 'Yêu cầu hoàn hàng của đơn hàng #' . $this->returnRequest->order->id .
                         ' đã được cập nhật trạng thái: ' . ucfirst($this->returnRequest->status),
            'return_request_id' => $this->returnRequest->id,
            'order_id' => $this->returnRequest->order_id,
        ];
    }

    private function getStatusColor()
    {
        return match ($this->returnRequest->status) {
            'approved' => '#28a745',
            'rejected' => '#dc3545',
            'pending'  => '#ffc107',
            default    => '#6c757d',
        };
    }

    private function getStatusIcon()
    {
        return match ($this->returnRequest->status) {
            'approved' => '✅',
            'rejected' => '❌',
            'pending'  => '⏳',
            default    => '🔁',
        };
    }
}
