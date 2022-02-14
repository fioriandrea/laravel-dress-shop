<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;
use dress_shop\DataLayer;
use dress_shop\PaymentMethod;
use GuzzleHttp\Client;

class CheckoutController extends Controller
{
    public function externPaymentCheck($creditCard)
    {
        try {
            $client = new Client([
                // Base URI is used with relative requests
                'base_uri' => 'http://localhost:8081',
                // You can set any number of default request options.
                'timeout' => 5.0,
            ]);

            $response = $client->request('GET', '', [
                'query' => ['card' => $creditCard]
            ]);

            $result = json_decode($response->getBody());

            return $result->result == "positive";
        } catch (\Exception $e) {
            return false;
        }
    }

    public function getCheckout() {
        if (auth()->user()->cartProducts->count() == 0) {
            return redirect()->route('user_error', ['messages' => ['Your cart is empty'], 'status' => 400]);
        }
        if (auth()->user()->validAddresses()->count() == 0) {
            return redirect()->route('profile')->with('error', 'You need to add an address before you can checkout');
        }
        if (auth()->user()->validPaymentMethods()->count() == 0) {
            return redirect()->route('profile')->with('error', 'You need to add a payment method before you can checkout');
        }
        // for each product in the cart, check if there is enough stock
        // use error route to redirect to error page
        foreach (auth()->user()->cartProducts as $cartProduct) {
            if ($cartProduct->product->status == 'unlisted') {
                return redirect()->route('user_error', ['messages' => ['Product: ' . $cartProduct->product->name . ' is unlisted'], 'status' => 404]);
            }
            if ($cartProduct->product->{$cartProduct->size} < $cartProduct->quantity) {
                // redirect to 'user_error' route with error message (specify the product name and size)
                return redirect()->route('user_error', ['messages' => [
                    'Not enough stock for product: ' . $cartProduct->product->name . ' (size: ' . $cartProduct->size . ')',
                    'Only ' . $cartProduct->product->{$cartProduct->size} . ' left in stock and you requested ' . $cartProduct->quantity,
                ], 'status' => 400]);
            }
        }
        return view('checkout', [
            'user' => auth()->user(),
            'addresses' => auth()->user()->validAddresses(),
            'payments' => auth()->user()->validPaymentMethods(),
        ]);
    }

    public function postCheckout(Request $request) {
        $this->validate($request, [
            'address_id' => 'required',
            'payment_method_id' => 'required',
        ]);
        $paymentMethod = PaymentMethod::find($request->payment_method_id);
        if ($paymentMethod == null) {
            return redirect()->route('user_error', ['messages' => ['Payment method not found'], 'status' => 404]);
        }
        if (!$this->externPaymentCheck($paymentMethod->cc_number)) {
            $formattedNumber = substr($paymentMethod->cc_number, 0, 4) . ' ' . substr($paymentMethod->cc_number, 4, 4) . ' ' . substr($paymentMethod->cc_number, 8, 4) . ' ' . substr($paymentMethod->cc_number, 12, 4);
            return redirect()->route('user_error', ['messages' => [
                'Payment method refused',
                'Card: ' . $formattedNumber,
                'Owner: ' . $paymentMethod->owner_first_name . ' ' . $paymentMethod->owner_second_name,
                'Expiration Date: ' . $paymentMethod->expiration_date,
            ], 'status' => 400]);
        } 
        DataLayer::postCreateOrder($request);
        return redirect()->route('index')->with('success', 'Order placed successfully');
    }
}
