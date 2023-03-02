<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Inertia\Inertia;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = OrderResource::collection(Order::paginate());
        return Inertia::render('Customer/Orders', [
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Order/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $order = new Order();
        $order->fill($request->validated());
        $order->save();
        return to_route('.index')
            ->with('message', 'Order created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        return Inertia::render('Order/Edit',[
            'order' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->validated());
        return to_route('.index')
            ->with('message', 'Order updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();
        return to_route('orders.index')
            ->with('message', 'Order deleted successfully');
    }
}
