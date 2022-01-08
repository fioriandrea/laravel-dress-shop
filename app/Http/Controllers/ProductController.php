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
            'sizes' => DataLayer::getProductSizes($id),
            'images' => DataLayer::getProductImages($id),
            'rating' => 3,
            'logged' => false,
        ]);
        return view('product', [
            'product' => (object) [
                "id" => 1,
                "name" => "Cuban Collar Shirt",
                "pictures" => [
                    "cuban_collar_shirt.jpg",
                    "cuban_collar_shirt_0.jpeg",
                    "cuban_collar_shirt_1.jpg",
                ],
                "price" => "20.00", 
                "shipping" => "0.00",
                "available" => "10",
                "description" => "A classic shirt from Cuba with a Cuban collar and a buttoned cuffs. The shirt is made of 100% cotton and is available in black and white.",
                "brand" => "Cuba",
                "category" => "Shirts",
                "rating" => 4.4,
                "sizes" => [
                    "S" => 2,
                    "M" => 3,
                    "L" => 4,
                    "XL" => 0,
                ],
            ],
            'logged' => false,
        ]);
    }
}
