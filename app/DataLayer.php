<?php

namespace dress_shop;

class DataLayer {

    public static function getUserOrders() {
        // get orders sorted by date, from most recent to least recent
        return auth()->user()->orders()->orderBy('created_at', 'desc')->get();
    }

    public static function deleteOrder($id) {
        $order = Order::find($id);
        // for each product in the order, add it back to the inventory using the right size
        foreach ($order->orderProducts as $op) {
            $product = $op->product;
            $size = $op->size;
            $product->{$size} += $op->quantity;
            $product->save();
        }
        // delete the order
        $order->delete();
    }

    public static function postCreateOrder($data) {
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->address_id = $data->address_id;
        $order->payment_method_id = $data->payment_method_id;
        $order->total = DataLayer::getCartTotal(auth()->user());
        $order->status = 'pending';
        $order->save();
        foreach (auth()->user()->cartProducts as $cartProduct) {
            $orderProduct = new OrderProduct();
            $orderProduct->order_id = $order->id;
            $orderProduct->user_id = auth()->user()->id;
            $orderProduct->product_id = $cartProduct->product_id;
            $orderProduct->quantity = $cartProduct->quantity;
            $orderProduct->size = $cartProduct->size;
            $orderProduct->save();
        }
        foreach (auth()->user()->cartProducts as $cartProduct) {
            // update product quantity (based on size (e.g. L, XL, etc.))
            $product = Product::find($cartProduct->product_id);
            //$product->{$cartProduct->size} -= $cartProduct->quantity;
            $product->save();
        }
        auth()->user()->cartProducts()->delete();
    }

    public static function postModifyPaymentMethod($id, $data) {
        $user = auth()->user();
        $payment = PaymentMethod::find($id);
        $payment->cc_number = $data->cc_number;
        $payment->expiration_date = $data->expiration_date;
        $payment->owner_first_name = $data->owner_first_name;
        $payment->owner_second_name = $data->owner_second_name;
        $payment->user_id = $user->id;
        $payment->save();
    }

    public static function postRemovePaymentMethod($id) {
        $paymentMethod = PaymentMethod::find($id);
        $paymentMethod->delete();
    }

    public static function postNewPaymentMethod($data) {
        $payment = new PaymentMethod();
        $payment->user_id = auth()->user()->id;
        $payment->owner_first_name = $data->owner_first_name;
        $payment->owner_second_name = $data->owner_second_name;
        $payment->cc_number = $data->cc_number;
        $payment->expiration_date = $data->expiration_date;
        $payment->save();
    }

    public static function postNewAddress($data) {
        $address = new Address();
        $address->user_id = auth()->user()->id;
        $address->street = $data->street;
        $address->city = $data->city;
        $address->province = $data->province;
        $address->country = $data->country;
        $address->zip = $data->zip;
        $address->save();
    }

    public static function postRemoveAddress($id) {
        $address = Address::find($id);
        $address->delete();
    }

    public static function postModifyAddress($id, $data) {
        $address = Address::find($id);
        $address->street = $data->street;
        $address->city = $data->city;
        $address->province = $data->province;
        $address->country = $data->country;
        $address->zip = $data->zip;
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

    public static function addToCart($data)
    {
        $product = Product::find($data->product_id);
        $product->{$data->size} -= $data->quantity;
        $product->save();
        $cartProduct = CartProduct::where('user_id', auth()->user()->id)->where('product_id', $data->product_id)->where('size', $data->size)->first();
        if ($cartProduct == null) {
            $cartProduct = new CartProduct();
            $cartProduct->user_id = auth()->user()->id;
            $cartProduct->product_id = $data->product_id;
            $cartProduct->size = $data->size;
            $cartProduct->quantity = $data->quantity;
            $cartProduct->save();
        } else {
            $cartProduct->quantity += $data->quantity;
            $cartProduct->save();
        }
    }

    // remove a product from the cart
    public static function removeFromCart($data)
    {
        // find the cart product to remove, given the product id and user id
        $cartProduct = CartProduct::where('user_id', auth()->user()->id)->where('product_id', $data->product_id)->where('size', $data->size)->first();
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

    public static function getCartTotal($user) {
        return DataLayer::getCartTotalPrices($user) + DataLayer::getCartShipping($user);
    }

    // given a user, return the total price of all products in the user's cart
    public static function getCartTotalPrices($user) {
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

