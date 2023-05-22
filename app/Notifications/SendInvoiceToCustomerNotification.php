<?php

namespace App\Notifications;

use App\Models\Order;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use LaravelDaily\Invoices\Invoice;

class SendInvoiceToCustomerNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(private Order $order, private Invoice $invoice)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     * @throws Exception
     */
    public function toMail($notifiable): MailMessage
    {
        $this->invoice->filename('invoice/'. $this->order->id)->save();
        return (new MailMessage)
            ->line('Your Order has been placed successfully.')
            ->action('View Order', route('orders.show', $this->order->id))
            ->line('Thank you for ordering!')
            ->line('Invoice is attached.')
            ->attach(storage_path('app/'.$this->invoice->filename), [
                'as' => 'invoice.pdf',
                'mime' => 'application/pdf',
            ]);
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable): array
    {
        return [
            //
        ];
    }
}
