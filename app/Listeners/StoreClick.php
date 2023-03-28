<?php

namespace App\Listeners;

use App\Events\ProductViewed;
use App\Models\Click;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StoreClick
{
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
    public function handle(ProductViewed $event):void
    {
        Click::create([
            'product_id' => $event->product->id,
        ]);
    }
}
