<?php

namespace dress_shop;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    /* a product has the following properties:
        - id (primary key)
        - name
        - description
        - short_description
        - category
        - price
        - shipping
        - brand
    */
    protected $fillable = ['name', 'description', 'short_description', 'category', 'price', 'shipping', 'brand'];

    // a product has many images
    public function images() {
        return $this->hasMany('dress_shop\Image');
    }

    // a product has many sizes
    public function sizes() {
        return $this->hasMany('dress_shop\Size');
    }
}
