<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function getCart()
    {
        return view('index');
    }
}
