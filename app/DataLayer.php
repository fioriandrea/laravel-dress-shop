<?php

namespace dress_shop;

class DataLayer {

    public static function confirmOrder($id) {
        $order = Order::find($id);
        $order->status = 'confirmed';
        $order->save();
    }

    public static function getPendingOrders() {
        $orders = Order::where('status', '=', 'pending')->get();
        return $orders;
    }

    public static function saveImages($images) {
        $img_names = [];
        if ($images != null) {
            foreach ($images as $image) {
                // get a temp name based on the current time
                $temp_name = time() . rand() . '.' . $image->getClientOriginalExtension();
                // save the image with the temp name into the img folder
                $image->storeAs('public/img/', $temp_name);
                // append the temp name to the img_names array
                array_push($img_names, $temp_name);
            }
        }
        return $img_names;
    }

    public static function newProduct($data) {
        $product = new Product();
        DataLayer::editProductObj($product, $data);
    }

    public static function editProduct($data, $id) {
        $product = Product::find($id);
        DataLayer::editProductObj($product, $data);
    }

    private static function editProductObj($product, $data) {
        $product->name = $data->name;
        $product->description = $data->description;
        $product->short_description = $data->short_description;
        $product->category = $data->category;
        $product->brand = $data->brand;
        $product->shipping = $data->shipping;
        $product->price = $data->price;
        $product->S = $data->S;
        $product->M = $data->M;
        $product->L = $data->L;
        $product->XL = $data->XL;
        // delete all the images with id in $data->todelete_images
        // use a foreach
        if ($data->todelete_images != null) {
            foreach ($data->todelete_images as $image_id) {
                $image = Image::find($image_id);
                $image->delete();
            }
        }
        $product->save();
        // add new images, given as files in $data->new_images_names
        // use a foreach
        if ($data->new_images_names != null) {
            foreach ($data->new_images_names as $image_name) {
                $image = new Image();
                $image->product_id = $product->id;
                $image->url = $image_name;
                $image->save();
            }
        }
    }

    public static function unlistProduct($id) {
        $product = DataLayer::getProduct($id);
        $product->status = 'unlisted';
        $product->save();
    }

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
            $orderProduct->price = $cartProduct->product->price;
            $orderProduct->shipping = $cartProduct->product->shipping;
            $orderProduct->save();
        }
        foreach (auth()->user()->cartProducts as $cartProduct) {
            // update product quantity (based on size (e.g. L, XL, etc.))
            $product = Product::find($cartProduct->product_id);
            $product->{$cartProduct->size} -= $cartProduct->quantity;
            $product->save();
        }
        auth()->user()->cartProducts()->delete();
    }

    public static function postModifyPaymentMethod($id, $data) {
        $payment = PaymentMethod::find($id);
        DataLayer::editPaymentMethodObj($payment, $data);
    }

    public static function postRemovePaymentMethod($id) {
        $paymentMethod = PaymentMethod::find($id);
        $paymentMethod->delete();
    }

    public static function postNewPaymentMethod($data) {
        $payment = new PaymentMethod();
        DataLayer::editPaymentMethodObj($payment, $data);
    }

    private static function editPaymentMethodObj($payment, $data) {
        $payment->user_id = auth()->user()->id;
        $payment->owner_first_name = $data->owner_first_name;
        $payment->owner_second_name = $data->owner_second_name;
        $payment->cc_number = $data->cc_number;
        $payment->expiration_date = $data->expiration_date;
        $payment->save();
    }

    public static function postNewAddress($data) {
        $address = new Address();
        DataLayer::editAddressObj($address, $data);
    }

    public static function postRemoveAddress($id) {
        $address = Address::find($id);
        $address->delete();
    }

    public static function postModifyAddress($id, $data) {
        $address = Address::find($id);
        DataLayer::editAddressObj($address, $data);
    }

    private static function editAddressObj($address, $data) {
        $address->user_id = auth()->user()->id;
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

    public static function removeFromCart($data)
    {
        // find the cart product to remove, given the product id and user id
        $cartProduct = CartProduct::where('user_id', auth()->user()->id)->where('product_id', $data->product_id)->where('size', $data->size)->first();
        // if the cart product exists, delete it
        if ($cartProduct != null) {
            $cartProduct->delete();
        }
    }

    public static function getCartProducts($user) {
        $cartProducts = CartProduct::where('user_id', $user->id)->get();
        return $cartProducts;
    }

    public static function getRelatedProducts($_product, $n = 7) {
        $products = DataLayer::getProducts(function ($product) use ($_product) {
            return $product->category == $_product->category && $product->id != $_product->id && $product->status != 'unlisted';
        });
        $products = $products->shuffle();
        return $products->take($n);
    }

    public static function getProduct($id) {
        $product = Product::find($id);
        return $product;
    }

    public static function getCartCount($user) {
        $cart = CartProduct::where('user_id', $user->id)->get();
        return count($cart);
    }

    public static function getCartTotal($user) {
        return DataLayer::getCartTotalPrices($user) + DataLayer::getCartShipping($user);
    }

    public static function getCartTotalPrices($user) {
        $cartProducts = $user->cartProducts;
        $total = 0;
        foreach ($cartProducts as $cartProduct) {
            $total += $cartProduct->product->price * $cartProduct->quantity;
        }
        return $total;
    }

    public static function getCartShipping($user) {
        $cartProducts = $user->cartProducts;
        $total = 0;
        foreach ($cartProducts as $cartProduct) {
            $total += $cartProduct->product->shipping * $cartProduct->quantity;
        }
        return $total;
    }
}

