<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;
use dress_shop\DataLayer;

class CheckoutController extends Controller
{
    public function getCheckout() {
        if (auth()->user()->cartProducts->count() == 0) {
            return redirect()->route('error', ['messages' => ['Your cart is empty']]);
        }
        if (auth()->user()->addresses->count() == 0) {
            return redirect()->route('error', ['messages' => ['You have no addresses']]);
        }
        if (auth()->user()->paymentMethods->count() == 0) {
            return redirect()->route('error', ['messages' => ['You have no payment methods']]);
        }
        // for each product in the cart, check if there is enough stock
        // use error route to redirect to error page
        foreach (auth()->user()->cartProducts as $cartProduct) {
            if ($cartProduct->product->status == 'unlisted') {
                return redirect()->route('error', ['messages' => ['Product: ' . $cartProduct->product->name . ' is unlisted']]);
            }
            if ($cartProduct->product->{$cartProduct->size} < $cartProduct->quantity) {
                // redirect to 'error' route with error message (specify the product name and size)
                return redirect()->route('error', ['messages' => [
                    'Not enough stock for product: ' . $cartProduct->product->name . ' (size: ' . $cartProduct->size . ')',
                    'Only ' . $cartProduct->product->{$cartProduct->size} . ' left in stock and you requested ' . $cartProduct->quantity,
                ]]);
            }
        }
        return view('checkout', [
            'user' => auth()->user(),
            'addresses' => auth()->user()->addresses,
            'payments' => auth()->user()->paymentMethods,
        ]);
    }

    public function postCheckout(Request $request) {
        $this->validate($request, [
            'address_id' => 'required',
            'payment_method_id' => 'required',
        ]);
        DataLayer::postCreateOrder($request);
        return redirect()->route('index')->with('success', 'Order placed successfully');
    }
}
