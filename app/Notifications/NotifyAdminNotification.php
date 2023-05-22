<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyAdminNotification extends Notification
{
    use Queueable;



    /**
     * Create a new notification instance.
     */
    public function __construct(private Order $order)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['database'];
    }


    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            'data' => [
                'message' => 'New Order Placed',
                'link' => route('admin.orders.show', $this->order),
            ]
        ];
    }

    public function toDatabase($notifiable): array
    {
        return $this->toArray($notifiable);
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
