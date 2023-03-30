<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use App\Http\Resources\CartItemResource;
use App\Models\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CheckoutController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('Customer/Checkout', [
            'products' => CartItemResource::collection(Cart::instance('cart')->content()),
            'total' => Cart::instance('cart')->total(),
            'tax' => Cart::instance('cart')->tax(),
            'subtotal' => Cart::instance('cart')->subtotal(),
            'discount' => Cart::instance('cart')->discount(),
        ]);
    }
    public function store(CheckoutRequest $request): RedirectResponse
    {
        $request->update();
//        $products = Cart::instance('cart')->content();
        $total = Cart::instance('cart')->totalFloat();
        $tax = Cart::instance('cart')->taxFloat();
        $subtotal = Cart::instance('cart')->subtotalFloat();
        $discount = Cart::instance('cart')->discountFloat();
        /** @var Order $order */
        $order = $request->user()->orders()->make([
//            'products' => $products,
            'total' => $total,
            'tax' => $tax,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping_address' => $request->user()->address,
        ]);
        $order->save();
        $order->addProducts(Cart::instance('cart')->content());
        Cart::instance('cart')->destroy();
        return redirect()->route('orders.index')->with('message', 'Order created successfully');
    }

}
