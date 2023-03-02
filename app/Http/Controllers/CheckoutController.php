<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function show()
    {
        return Inertia::render('Customer/Checkout', [
            'products' => \App\Http\Resources\CartItemResource::collection(Cart::instance('cart')->content()),
            'total' => Cart::instance('cart')->total(),
            'tax' => Cart::instance('cart')->tax(),
            'subtotal' => Cart::instance('cart')->subtotal(),
            'discount' => Cart::instance('cart')->discount(),
        ]);
    }
    public function store(Request $request)
    {
        $products = Cart::instance('cart')->content();
        $total = Cart::instance('cart')->totalFloat();
        $tax = Cart::instance('cart')->taxFloat();
        $subtotal = Cart::instance('cart')->subtotalFloat();
        $discount = Cart::instance('cart')->discountFloat();
        Order::create([
            'user_id' => $request->user()->id,
            'products' => $products,
            'total' => $total,
            'tax' => $tax,
            'subtotal' => $subtotal,
            'discount' => $discount,
        ]);
        Cart::instance('cart')->destroy();
        return redirect()->route('orders.index')->with('message', 'Order created successfully');
    }

}
