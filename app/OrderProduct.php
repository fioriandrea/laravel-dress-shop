<?php

namespace dress_shop;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    // table = order_product
    protected $table = 'order_product';
    // no time stamps
    public $timestamps = false;

    // A OrderProduct belongs to an Order
    public function order()
    {
        return $this->belongsTo('dress_shop\Order');
    }

    // A OrderProduct belongs to a Product
    public function product()
    {
        return $this->belongsTo('dress_shop\Product');
    }

}
