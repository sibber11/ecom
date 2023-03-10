<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = QueryBuilder::for(Order::class)
            ->paginate()
            ->withQueryString();
        return Inertia::render('Admin/Order/Index', [
            'orders' => $orders
        ])->table(function (InertiaTable $table) {
            $table->column('id', sortable: true, searchable: true)
                ->column('status', sortable: true, searchable: true)
                ->column('subtotal')
                ->column('tax')
                ->column('discount')
                ->column('shipping')
                ->column('total')
                ->column('created_at')
                ->column('actions')
                ->withGlobalSearch();
        });
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Order/Create');
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
        return Inertia::render('Admin/Order/Edit',[
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
