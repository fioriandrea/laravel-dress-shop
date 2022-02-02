<?php

namespace dress_shop;

class DataLayer {
    public static function getProducts($phpPredicate) {
        $products = Product::all();
        $products = $products->filter($phpPredicate);
        return $products;
    }

    // return n random products (they should all be different from each other and from the given product)
    // the products should have the same category as the given product
    public static function getRelatedProducts($_product, $n = 7) {
        $products = Product::all();
        $products = $products->filter(function($product) use ($_product) {
            return $product->category == $_product->category;
        });
        $products = $products->filter(function($product) use ($_product) {
            return $product->id != $_product->id;
        });
        $products = $products->shuffle();
        return $products->take($n);
    }

    public static function getProduct($id) {
        $product = Product::find($id);
        return $product;
    }
}

