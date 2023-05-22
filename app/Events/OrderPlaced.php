<?php

namespace App\Events;

use App\Helper\InvoiceHandler;
use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use LaravelDaily\Invoices\Invoice;

class OrderPlaced
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Invoice $invoice;

    /**
     * Create a new event instance.
     * @throws BindingResolutionException
     */
    public function __construct(public Order $order)
    {
        $this->invoice = InvoiceHandler::generate($order);

    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('channel-name');
    }
}
