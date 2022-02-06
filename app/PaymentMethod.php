<?php

namespace dress_shop;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'payment_method';
    public $timestamps = false;

    // A user has many Payment Methods
    public function user()
    {
        return $this->belongsTo('dress_shop\User');
    }

    // An order has a payment method
    public function order()
    {
        return $this->belongsTo('dress_shop\Order');
    }
}
