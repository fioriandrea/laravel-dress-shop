<?php

namespace dress_shop;

class DataLayer {

    public static function postModifyPaymentMethod($request) {
        $user = auth()->user();
        $payment = PaymentMethod::find($request->id);
        $payment->cc_number = $request->cc_number;
        $payment->expiration_date = $request->expiration_date;
        $payment->owner_first_name = $request->owner_first_name;
        $payment->owner_second_name = $request->owner_second_name;
        $payment->user_id = $user->id;
        $payment->save();
    }

    public static function postRemovePaymentMethod($request) {
        $paymentMethod = PaymentMethod::find($request->id);
        $paymentMethod->delete();
    }

    public static function postNewPaymentMethod($request) {
        $payment = new PaymentMethod();
        $payment->user_id = auth()->user()->id;
        $payment->owner_first_name = $request->owner_first_name;
        $payment->owner_second_name = $request->owner_second_name;
        $payment->cc_number = $request->cc_number;
        $payment->expiration_date = $request->expiration_date;
        $payment->save();
    }

    public static function postNewAddress($request) {
        $address = new Address();
        $address->user_id = $request->user()->id;
        $address->street = $request->street;
        $address->city = $request->city;
        $address->province = $request->province;
        $address->country = $request->country;
        $address->zip = $request->zip;
        $address->save();
    }

    public static function postRemoveAddress($request) {
        $address = Address::find($request->id);
        $address->delete();
    }

    public static function postModifyAddress($request) {
        $address = Address::find($request->id);
        $address->street = $request->street;
        $address->city = $request->city;
        $address->province = $request->province;
        $address->country = $request->country;
        $address->zip = $request->zip;
        $address->save();
    }

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
            $cartProduct->quantity = $request->quantity;
            $cartProduct->save();
        } else {
            $cartProduct->quantity += $request->quantity;
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

