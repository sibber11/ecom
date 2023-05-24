<?php

namespace App\Listeners;

use App\Events\OrderCancelled;
use App\Events\OrderPlaced;
use App\Models\User;
use App\Notifications\NotifyAdminNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifyAdminAboutNewOrder
{
    /**
     * Create the event listener.
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
        // using Notification::send method, it is possible to sent notification to multiple users.
        Notification::send(User::admin(), new NotifyAdminNotification($event->order));
    }
}
