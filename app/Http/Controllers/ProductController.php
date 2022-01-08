<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProductList()
    {
        return view('product_list', [
            'products' => [
                (object) [
                    'id' => 1,
                    "name" => "Cuban Collar Shirt",
                    "short_description" => "A classic shirt from Cuba",
                    "picture" => "cuban_collar_shirt.jpg",
                    "price" => "20.00", 
                    "shipping" => "0.00",
                    "available" => "10",
                ],
                (object) [
                    "id" => 2,
                    "name" => "Peak Lapel Suit",
                    "short_description" => "A classic suit from Peak",
                    "picture" => "peak_lapel_suit.webp",
                    "main_picture" => "peak_lapel_suit.webp",
                    "price" => "30.40", 
                    "shipping" => "30.00",
                    "available" => "2",
                ],
            ],
            'logged' => false,
        ]);
    }

    public function getProduct($id)
    {
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
