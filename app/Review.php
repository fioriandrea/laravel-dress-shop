<?php

namespace dress_shop;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'review';
    public $timestamps = false;

    // a review belongs to a product
    public function product()
    {
        return $this->belongsTo('dress_shop\Product');
    }

    // a review belongs to a user
    public function user()
    {
        return $this->belongsTo('dress_shop\User');
    }
}
