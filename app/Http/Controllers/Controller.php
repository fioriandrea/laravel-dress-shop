<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $categories;
    protected $sizes;

    public function __construct() 
    {
        $this->categories = ['Shirts', 'Shoes', 'Suits', 'Hats', 'Pants', 'Ties'];
        $this->sizes = ['S', 'M', 'L', 'XL'];
        View::share('categories', $this->categories);
        View::share('sizes', $this->sizes);
    }
}
