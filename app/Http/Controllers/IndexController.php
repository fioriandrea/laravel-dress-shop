<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function getIndex()
    {
        return view('index');
    }
}
