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

    // return n random products (they should all be different from each other and from the given product)
    public static function getRandomProducts($_product, $n = 5) {
        $products = Product::all();
        $products = $products->filter(function($product) use ($_product) {
            return $product->id != $_product->id;
        });
        $products = $products->shuffle();
        $products = $products->take($n);
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

