<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;

use dress_shop\DataLayer;
use dress_shop\Product;
use dress_shop\CartProduct;

class CartController extends Controller
{
    public function getCart()
    {
        return view('cart', [
            'user' => auth()->user(),
            'cartProducts' => DataLayer::getCartProducts(auth()->user()),
            'total' => DataLayer::getCartTotal(auth()->user()),
            'totalShipping' => DataLayer::getCartShipping(auth()->user()),
            'cartCount' => DataLayer::getCartCount(auth()->user()),
        ]);
    }

    public function addToCart(Request $request)
    {
        if ($request->quantity <= 0) {
            return redirect()->back();
        }
        // get the product
        $product = Product::find($request->product_id);
        if ($request->quantity > $product->{$request->size}) {
            return redirect()->back()->with('error', 'There are only ' . $request->product->sizes() . ' available for this product.');
        }
        DataLayer::addToCart($request);
        return redirect('/cart');
    }

    public function removeFromCart(Request $request)
    {
        DataLayer::removeFromCart($request);
        return redirect('/cart');
    }
}
