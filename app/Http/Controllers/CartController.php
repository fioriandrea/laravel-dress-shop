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
            // redirect to error page
            return redirect()->route('error', ['message' => 'Quantity must be greater than 0']);
        }
        $cartProduct = DataLayer::getCartProduct(auth()->user()->id, $request->product_id, $request->size);
        if ($cartProduct != null) {
            if ($cartProduct->quantity + $request->quantity > $cartProduct->product->{$request->size}) {
                // redirect to 'error' route with error message (specify the product name and size)
                return redirect()->route('error', ['message' => 'Not enough stock for product: ' . $cartProduct->product->name . ' (size: ' . $cartProduct->size . ')']);
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
