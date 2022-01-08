<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function getHome()
    {
        return view('index', ['logged' => false]);
    }
}
