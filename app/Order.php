<?php

namespace dress_shop;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // table = user_order
    protected $table = 'user_order';

    // A user has many orders
    public function user()
    {
        return $this->belongsTo('dress_shop\User');
    }

    // A OrderProduct belongs to an Order
    public function orderProducts()
    {
        return $this->hasMany('dress_shop\OrderProduct');
    }

    // An order has a payment method
    public function paymentMethod()
    {
        return $this->belongsTo('dress_shop\PaymentMethod');
    }

    // An order has a shipping address
    public function address()
    {
        return $this->belongsTo('dress_shop\Address');
    }
}
