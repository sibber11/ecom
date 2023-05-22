<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Notifications\SendInvoiceToCustomerNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendInvoiceNotification implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {

        $event->order->user->notify(new SendInvoiceToCustomerNotification($event->order, $event->invoice));
    }
}
