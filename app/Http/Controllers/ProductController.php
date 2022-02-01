<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;

use dress_shop\DataLayer;

class ProductController extends Controller
{

    private static function productsFilter($category = 'all', $keyword = '') {
        return function($product) use ($category, $keyword) {
            if ($category != 'all' && $category != $product->category)
                return false;
            $tocheck = [$product->name, $product->description, $product->category, $product->short_description];
            for ($i = 0; $i < count($tocheck); $i++) {
                if ($keyword == '' || strpos(strtolower($tocheck[$i]), strtolower($keyword)) !== false)
                    return true;
            }
            return false;
        };
    }

    public function getProductList(Request $request)
    {
        $filter = ProductController::productsFilter($request->category, $request->keyword);
        return view('product_list', [
            'products' => DataLayer::getProducts($filter),
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
