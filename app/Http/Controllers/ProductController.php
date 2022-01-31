<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;

use dress_shop\DataLayer;

class ProductController extends Controller
{
    public function getProductList()
    {
        return view('product_list', [
            'products' => DataLayer::getProductList(),
            'logged' => false,
        ]);
    }

    public function getProduct($id)
    {
        return view('product', [
            'product' => DataLayer::getProduct($id),
            'images' => DataLayer::getProductImages($id),
            'rating' => 3,
            'logged' => false,
        ]);
    }
}
