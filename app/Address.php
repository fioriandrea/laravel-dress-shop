<?php

namespace dress_shop;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'address';
    public $timestamps = false;

    // A user has many addresses
    public function user()
    {
        return $this->belongsTo('dress_shop\User');
    }

    // An order has a shipping address
    public function order()
    {
        return $this->belongsTo('dress_shop\Order');
    }
}
