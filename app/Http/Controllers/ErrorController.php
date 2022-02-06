<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function getError(Request $request)
    {
        return view('error_page', ['messages' => $request->messages]);
    }
}
