<?php

namespace dress_shop;

class DataLayer {
    // get all products
    // use Laravel's Eloquent ORM to get all products
    // do not use foreach loops
    public static function getProducts() {
        return Product::all();
    }

    // get all products, and for each product, get the first image's url and the sum of all sizes' available
    // use Laravel's Eloquent ORM to get all products
    // do not use foreach loops
    public static function getProductList() {
        return DataLayer::getProducts()->map(function($product) {
            $product->image = $product->images()->first()->url;
            $product->available = $product->sizes()->sum('available');
            return $product;
        });
    }

    // return a product given its id
    // use Laravel's Eloquent ORM to get a product
    // do not use foreach loops
    public static function getProduct($id) {
        $product = Product::find($id);
        return $product;
    }

    // get all sizes of a product
    // use Laravel's Eloquent ORM to get all sizes of a product
    // do not use foreach loops
    public static function getProductSizes($id) {
        $sizes = Size::where('product_id', $id)->get();
        return $sizes;
    }

    // get all images of a product
    // use Laravel's Eloquent ORM to get all images of a product
    // do not use foreach loops
    public static function getProductImages($id) {
        $images = Image::where('product_id', $id)->get();
        return $images;
    }
}

