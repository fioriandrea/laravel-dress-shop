<?php

namespace dress_shop;

use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    protected $table = 'cart';
    public $timestamps = false;

    // A cart product belongs to a user
    public function user()
    {
        return $this->belongsTo('dress_shop\User');
    }

    // A cart product belongs to a product
    public function product()
    {
        return $this->belongsTo('dress_shop\Product');
    }
}
