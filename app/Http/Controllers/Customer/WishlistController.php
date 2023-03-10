<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;

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
