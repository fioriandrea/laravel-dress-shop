<?php

namespace dress_shop;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = ['id', 'name', 'category', 'brand', 'shipping', 'price', 'description', 'short_description', 'S', 'M', 'L', 'XL', 'status'];
    public $timestamps = false;

    public function images() {
        return $this->hasMany('dress_shop\Image');
    }

    public function sizes() {
        return $this->S + $this->M + $this->L + $this->XL;
    }

    public function firstImage() {
        $img = $this->images()->first();
        if ($img == null) {
            $img = new Image();
            $img->url = 'image_not_found.jpeg';
            $img->product_id = $this->id;
        }
        return $img;
    }

    // a product has many cart products
    public function cartProducts() {
        return $this->hasMany('dress_shop\CartProduct');
    }

    // a product may have an order product
    public function orderProducts() {
        return $this->hasMany('dress_shop\OrderProduct');
    }
}
