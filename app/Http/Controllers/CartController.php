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
            return redirect()->route('user_error', ['messages' => ['Quantity must be greater than 0'], 'status' => 400]);
        }
        $cartProduct = DataLayer::getCartProduct(auth()->user()->id, $request->product_id, $request->size);
        if ($cartProduct != null) {
            if ($cartProduct->quantity + $request->quantity > $cartProduct->product->{$request->size}) {
                $submessage = '';
                if ($cartProduct->quantity == 0) {
                    $submessage = 'Only ' . $cartProduct->product->{$cartProduct->size} . ' left in stock';
                } else if ($cartProduct->quantity == $cartProduct->product->{$cartProduct->size}) {
                    $submessage = 'Every item is in your cart';
                } else {
                    $submessage = 'Only ' . $cartProduct->product->{$cartProduct->size} . ' left in stock and ' . $cartProduct->quantity . ' already in cart';
                }
                return redirect()->back()->with('error', 'Error: not enough stock for ' . $cartProduct->product->name . ' (size: ' . $cartProduct->size . '): ' . $submessage);
            }
        } else {
            $product = DataLayer::getProduct($request->product_id);
            if ($product == null || $product->unlisted == 1) {
                // redirect to 'user_error' route with error message (specify the product name and size)
                return redirect()->route('user_error', ['messages' => ['Product not found'], 'status' => 404]);
            }
            if ($product->{$request->size} < $request->quantity) {
                // redirect to 'user_error' route with error message (specify the product name and size)
                return redirect()->route('user_error', ['messages' => ['Not enough stock for product: ' . $product->name . ' (size: ' . $request->size . ')'], 'status' => 400]);
            }
        }
        DataLayer::addToCart($request);
        return redirect('/cart');
    }

    public function removeFromCart(Request $request)
    {
        DataLayer::removeFromCart($request);
        return redirect('/cart')->with('success', 'Item removed from cart');
    }
}
