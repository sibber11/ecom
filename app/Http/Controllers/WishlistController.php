<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function store(Product $product)
    {
        Cart::instance('wishlist')->add($product);
        return back();
    }

    public function destroy($rowId)
    {

        Cart::instance('wishlist')->remove($rowId);
        return back();
    }

    public function update()
    {

    }
}
