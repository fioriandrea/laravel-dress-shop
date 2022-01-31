<?php

namespace dress_shop;

class DataLayer {
    public static function getProducts() {
        return Product::all();
    }

    public static function getProductList() {
        $products = Product::all();
        return $products;
    }

    public static function getProductTotalSizes($id) {
        $product = Product::find($id);
        return $product->S + $product->M + $product->L + $product->XL;
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

