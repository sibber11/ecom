<?php

namespace App\Http\Controllers\Admin;

use App\Helper\QRCode;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Inertia\Inertia;
use Milon\Barcode\Facades\DNS2DFacade;
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
            ->defaultSort('id')
            ->allowedSorts(['id', 'status', 'total', 'created_at'])
            ->allowedFilters(['status'])
            ->paginate()
            ->withQueryString();
        return Inertia::render('Admin/Order/Index', [
            'orders' => $orders
        ])->table(function (InertiaTable $table) {
            $table->column('id', sortable: true, searchable: true)
                ->column('status', sortable: true, searchable: true)
                ->column('total')
                ->column('created_at')
                ->column('actions', canBeHidden: false)
                ->selectFilter('status', Order::STATUSES, label: 'Status')
                ->withGlobalSearch();
        });
    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return Inertia::render('Admin/Order/Show',[
            'order' => OrderResource::make($order)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->validated());
        return back()
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
