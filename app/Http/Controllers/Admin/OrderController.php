<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhere('name', 'LIKE', "%{$value}%");
                });
            });
        });
        $orders = QueryBuilder::for(Order::class)
            ->defaultSort('id')
            ->allowedSorts(['id', 'status', 'total', 'created_at'])
            ->allowedFilters(['status', $globalSearch])
            ->paginate()
            ->withQueryString();
        return Inertia::render('Admin/Order/Index', [
            'orders' => $orders
        ])->table(function (InertiaTable $table) {
            $table
                ->column('#', label: '#', canBeHidden: false)
                ->column('id', sortable: true, searchable: true)
                ->column('status', sortable: true, searchable: true)
                ->column('total')
                ->column('created_at', label: 'placed at')
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
            ->with('success', 'Order updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        DB::beginTransaction();
        $order->products()->detach();
        $order->delete();
        DB::commit();
        return back()
            ->with('message', 'Order deleted successfully');
    }
}
