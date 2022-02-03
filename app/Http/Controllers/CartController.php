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
        $cartProduct = DataLayer::getCartProduct(auth()->user()->id, $request->product_id, $request->size);
        if ($cartProduct != null) {
            if ($cartProduct->quantity + $request->quantity > $cartProduct->product->getSize($request->size)) {
                return redirect()->back()->with('error', 'Product is already in cart');
            }
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
