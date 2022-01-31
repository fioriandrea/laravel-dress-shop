<?php

namespace dress_shop;

class DataLayer {
    public static function getProducts() {
        return Product::all();
    }

    public static function getProductList() {
        $products = Product::all();
        foreach ($products as $product) {
            $product->image = $product->images()->first()->url;
            $product->sizes = $product->S + $product->M + $product->L + $product->XL;
        }
        return $products;
    }

    public static function getProduct($id) {
        $product = Product::find($id);
        return $product;
    }

    public static function getProductImages($id) {
        $images = Image::where('product_id', $id)->get();
        return $images;
    }
}

