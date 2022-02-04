<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;

use dress_shop\PaymentMethod;
use dress_shop\DataLayer;

class PaymentController extends Controller
{
    public function getAddPaymentMethod()
    {
        // create an address object with empty fields
        $payment = new PaymentMethod();
        return view('payment_form', [
            'user' => auth()->user(),
            'payment' => $payment,
            'add' => true,
        ]);
    }

    public function checkExists($id) {
        $payment = PaymentMethod::find($id);
        if ($payment == null) {
            return false;
        }
        return true;
    }

    public function checkOwns($id) {
        $payment = PaymentMethod::find($id);
        if ($payment == null) {
            return false;
        }
        if ($payment->user_id != auth()->user()->id) {
            return false;
        }
        return true;
    }

    public function postAddPaymentMethod(Request $request)
    {
        DataLayer::postNewPaymentMethod($request);
        return redirect('/profile');
    }

    public function postRemovePaymentMethod(Request $request)
    {
        if (!$this->checkExists($request->id)) {
            return redirect()->back()->with('error', 'Payment method not found');
        }
        if (!$this->checkOwns($request->id)) {
            return redirect()->back()->with('error', 'You do not own this payment method');
        }

        DataLayer::postRemovePaymentMethod($request);
        return redirect('/profile');
    }

    public function getModifyPaymentMethod(Request $request)
    {
        if (!$this->checkExists($request->id)) {
            return redirect()->back()->with('error', 'Payment method not found');
        }
        $payment = PaymentMethod::find($request->id);
        return view('payment_form', [
            'user' => auth()->user(),
            'payment' => $payment,
            'add' => false,
        ]);
    }

    public function postModifyPaymentMethod(Request $request)
    {
        if (!$this->checkExists($request->id)) {
            return redirect()->back()->with('error', 'Payment method not found');
        }
        if (!$this->checkOwns($request->id)) {
            return redirect()->back()->with('error', 'You do not own this payment method');
        }
        DataLayer::postModifyPaymentMethod($request);
        return redirect('/profile');
    }
}
