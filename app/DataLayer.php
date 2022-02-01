<?php

namespace dress_shop;

class DataLayer {
    public static function getProducts($phpPredicate) {
        $products = Product::all();
        $products = $products->filter($phpPredicate);
        return $products;
    }

    public static function getProductFirstImage($id) {
        $product = Product::find($id);
        return $product->images()->first()->url;
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

