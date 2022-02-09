<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    // getProfile
    public function getProfile()
    {
        return view('user_page', [
            'user' => auth()->user(),
            'addresses' => auth()->user()->validAddresses(),
            'payments' => auth()->user()->validPaymentMethods(),
        ]);
    }
}
