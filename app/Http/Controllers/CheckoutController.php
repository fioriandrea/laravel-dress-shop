<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;
use dress_shop\DataLayer;

class CheckoutController extends Controller
{
    public function getCheckout() {
        if (auth()->user()->cartProducts->count() == 0) {
            return redirect()->route('home')->with('error', 'Your cart is empty');
        }
        if (auth()->user()->addresses->count() == 0) {
            return redirect()->route('get_add_address');
        }
        if (auth()->user()->paymentMethods->count() == 0) {
            return redirect()->route('get_add_payment_method');
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
