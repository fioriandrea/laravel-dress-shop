<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function getError($message)
    {
        return view('error_page', ['message' => $message]);
    }
}
