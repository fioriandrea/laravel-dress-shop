<?php

namespace dress_shop;

class DataLayer {
    public static function getProducts($phpPredicate) {
        $products = Product::all();
        $products = $products->filter($phpPredicate);
        return $products;
    }

    public static function getCartProduct($user_id, $product_id, $size) {
        $cartProduct = CartProduct::where('user_id', $user_id)
            ->where('product_id', $product_id)
            ->where('size', $size)
            ->first();
        return $cartProduct;
    }

    public static function addToCart($request)
    {
        $product = Product::find($request->product_id);
        $cartProduct = CartProduct::where('user_id', auth()->user()->id)->where('product_id', $request->product_id)->where('size', $request->size)->first();
        if ($cartProduct == null) {
            $cartProduct = new CartProduct();
            $cartProduct->user_id = auth()->user()->id;
            $cartProduct->product_id = $request->product_id;
            $cartProduct->size = $request->size;
            $cartProduct->quantity = 1;
            $cartProduct->save();
        } else {
            $cartProduct->quantity++;
            $cartProduct->save();
        }
    }

    // remove a product from the cart
    public static function removeFromCart($request)
    {
        // find the cart product to remove, given the product id and user id
        $cartProduct = CartProduct::where('user_id', auth()->user()->id)->where('product_id', $request->product_id)->where('size', $request->size)->first();
        // if the cart product exists, delete it
        if ($cartProduct != null) {
            $cartProduct->delete();
        }
    }

    // get a user's cart products
    public static function getCartProducts($user) {
        $cartProducts = CartProduct::where('user_id', $user->id)->get();
        return $cartProducts;
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

    // given a user, return the number of items in the user's cart
    public static function getCartCount($user) {
        $cart = CartProduct::where('user_id', $user->id)->get();
        return count($cart);
    }

    // given a user, return the total price of all products in the user's cart
    public static function getCartTotal($user) {
        $cartProducts = $user->cartProducts;
        $total = 0;
        foreach ($cartProducts as $cartProduct) {
            $total += $cartProduct->product->price * $cartProduct->quantity;
        }
        return $total;
    }

    // given a user, return the total shipping of all products in the user's cart
    public static function getCartShipping($user) {
        $cartProducts = $user->cartProducts;
        $total = 0;
        foreach ($cartProducts as $cartProduct) {
            $total += $cartProduct->product->shipping * $cartProduct->quantity;
        }
        return $total;
    }
}

