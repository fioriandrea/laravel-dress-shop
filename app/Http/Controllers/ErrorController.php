<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function getUserError(Request $request)
    {
        $status = $request->status;
        if ($status == null) {
            $status = 500;
        }
        return response()->view('user_error_page', ['messages' => $request->messages, 'status' => $status])->setStatusCode($status);
    }

    public function getAdminError(Request $request)
    {
        $status = $request->status;
        if ($status == null) {
            $status = 500;
        }
        return response()->view('admin_error_page', ['messages' => $request->messages, 'status' => $status])->setStatusCode($status);
    }
}
