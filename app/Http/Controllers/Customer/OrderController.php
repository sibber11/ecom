<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->paginate();
        return Inertia::render('Customer/Orders', [
            'orders' => OrderResource::collection($orders)
        ]);
    }

    public function show(Order $order)
    {
        abort_if($order->user_id !== auth()->id(), 403);
        return Inertia::render('Customer/Order', [
            'order' => OrderResource::make($order)
        ]);
    }

    public function destroy()
    {
        return 'destroy';
    }
}
