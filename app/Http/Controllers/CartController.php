<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request, Product $product)
    {
        Cart::instance('cart')->add($product, $request->quantity);
        return back();
    }

    public function destroy($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return back();
    }

    public function update(Request $request, Product $product)
    {
        Cart::instance('cart')->add($product, $request->quantity);
        return back();
    }
}
