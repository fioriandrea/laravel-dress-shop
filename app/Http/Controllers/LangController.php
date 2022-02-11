<?php

namespace dress_shop\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LangController extends Controller
{
    public function changeLanguage(Request $request, $lang){
        Session::put('language', $lang);
        return redirect()->back();
    }

}
