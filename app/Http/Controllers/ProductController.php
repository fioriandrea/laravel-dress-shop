<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;

use dress_shop\DataLayer;

class ProductController extends Controller
{
    private static function productsFilter($category = 'all', $keyword = '') {
        return function($product) use ($category, $keyword) {
            if ($product->status == 'unlisted' && auth()->user()->type != 'admin') {
                return false;
            }
            $category = $category === null ? 'all' : $category;
            $keyword = $keyword === null ? '' : $keyword;
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
        ]);
    }

    public function getProduct($id)
    {
        $product = DataLayer::getProduct($id);
        if ($product == null) {
            return redirect()->route('error', ['messages' => ['Product not found']]);
        }
        if ($product->status == 'unlisted') {
            return redirect()->route('error', ['messages' => ['Product is unlisted']]);
        }
        return view('product', [
            'product' => $product,
            'rating' => 3,
            'related' => DataLayer::getRelatedProducts($product),
        ]);
    }

    public function getEditProduct($id)
    {
        if (auth()->user()->type != 'admin') {
            return redirect()->route('error', ['messages' => ['You are not authorized to edit products']]);
        }
        $product = DataLayer::getProduct($id);
        if ($product == null) {
            return redirect()->route('error', ['messages' => ['Product not found']]);
        }
        return view('product_form', [
            'product' => $product,
            'add' => false,
        ]);
    }

    public function postUnlistProduct($id)
    {
        if (auth()->user()->type != 'admin') {
            return redirect()->route('error', ['messages' => ['You are not authorized to edit products']]);
        }
        $product = DataLayer::getProduct($id);
        if ($product == null) {
            return redirect()->route('error', ['messages' => ['Product not found']]);
        }
        DataLayer::unlistProduct($id);
        return redirect()->route('product_list');
    }

    public function postRelistProduct($id)
    {
        if (auth()->user()->type != 'admin') {
            return redirect()->route('error', ['messages' => ['You are not authorized to edit products']]);
        }
        $product = DataLayer::getProduct($id);
        if ($product == null) {
            return redirect()->route('error', ['messages' => ['Product not found']]);
        }
        DataLayer::relistProduct($id);
        return redirect()->route('product_list');
    }
}
