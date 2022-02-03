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

    public function updateCart(Request $request)
    {
        // find the cart product to update, given the product id and user id and size
        // and update the quantity
        $cartProduct = CartProduct::where('user_id', auth()->user()->id)->where('product_id', $request->product_id)->where('size', $request->size)->first();
        if ($cartProduct != null) {
            $cartProduct->quantity = $request->quantity;
            $cartProduct->save();
        }
        return redirect('/cart');
    }

    public function addToCart(Request $request)
    {
        $product = DataLayer::getProduct($request->product_id);
        if ($product->getSize($request->size) <= 0) {
            return redirect()->back()->with('error', 'Invalid size');
        }
        // check if product is already in cart.
        // if it is, check that the quantity in the cart is less than or equal the quantity in the database.
        // if it is not, redirect back with an error.
        $cartProduct = DataLayer::getCartProduct(auth()->user()->id, $request->product_id, $request->size);
        if ($cartProduct != null) {
            if ($cartProduct->quantity >= $product->getSize($request->size)) {
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
