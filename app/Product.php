<?php

namespace dress_shop;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = ['id', 'name', 'category', 'brand', 'shipping', 'price', 'description', 'short_description', 'S', 'M', 'L', 'XL'];

    // a product has many images
    public function images() {
        return $this->hasMany('dress_shop\Image');
    }
}
