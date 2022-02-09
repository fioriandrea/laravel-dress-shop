<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;

use dress_shop\PaymentMethod;
use dress_shop\DataLayer;

class PaymentController extends Controller
{
    public function getAddPaymentMethod()
    {
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
        return $payment->deleted == 0;
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
        return redirect('/profile')->with('success', 'Payment method added');
    }

    public function postRemovePaymentMethod($id)
    {
        if (!$this->checkExists($id)) {
            return redirect()->route('user_error', ['messages' => ['Payment method does not exist'], 'status' => 404]);
        }
        if (!$this->checkOwns($id)) {
            return redirect()->route('user_error', ['messages' => ['You do not own this payment method'], 'status' => 403]);
        }

        DataLayer::postRemovePaymentMethod($id);
        return response()->json(['success' => true, 'message' => 'Payment method removed successfully']);
    }

    public function getModifyPaymentMethod($id)
    {
        if (!$this->checkExists($id)) {
            return redirect()->route('user_error', ['messages' => ['Payment method does not exist'], 'status' => 404]);
        }
        $payment = PaymentMethod::find($id);
        return view('payment_form', [
            'user' => auth()->user(),
            'payment' => $payment,
            'add' => false,
        ]);
    }

    public function postModifyPaymentMethod(Request $request, $id)
    {
        if (!$this->checkExists($id)) {
            return redirect()->route('user_error', ['messages' => ['Payment method does not exist'], 'status' => 404]);
        }
        if (!$this->checkOwns($id)) {
            return redirect()->route('user_error', ['messages' => ['You do not own this payment method'], 'status' => 403]);
        }
        DataLayer::postModifyPaymentMethod($id, $request);
        return redirect('/profile')->with('success', 'Payment method updated successfully');
    }
}
