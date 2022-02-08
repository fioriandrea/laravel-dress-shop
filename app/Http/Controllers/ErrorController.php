<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function getUserError(Request $request)
    {
        return view('user_error_page', ['messages' => $request->messages]);
    }

    public function getAdminError(Request $request)
    {
        return view('admin_error_page', ['messages' => $request->messages]);
    }
}
