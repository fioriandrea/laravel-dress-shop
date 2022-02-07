<?php

namespace dress_shop\Http\Controllers;

use Illuminate\Http\Request;

use dress_shop\DataLayer;
use dress_shop\Product;

class ProductController extends Controller
{
    private static function productsFilter($category = 'all', $keyword = '') {
        return function($product) use ($category, $keyword) {
            if ($product->status == 'unlisted') {
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
        return view('product', [
            'product' => $product,
            'rating' => 3,
            'related' => DataLayer::getRelatedProducts($product),
        ]);
    }

    public function getEditProduct($id)
    {
        $product = DataLayer::getProduct($id);
        return view('product_form', [
            'product' => $product,
            'add' => false,
        ]);
    }

    public function postUnlistProduct($id)
    {
        $product = DataLayer::getProduct($id);
        DataLayer::unlistProduct($id);
        return redirect()->route('product_list');
    }

    public function postEditProduct(Request $request, $id)
    {
        $request->new_images_names = DataLayer::saveImages($request->new_images);
        // save the product
        DataLayer::editProduct($request, $id);
        return redirect()->route('product', ['id' => $id]);
    }

    public function postAddProduct(Request $request)
    {
        $request->new_images_names = DataLayer::saveImages($request->new_images);
        // save the product
        DataLayer::newProduct($request);
        return redirect()->route('product_list');
    }

    public function getAddProduct()
    {
        return view('product_form', [
            'product' => new Product(),
            'add' => true,
        ]);
    }
}
