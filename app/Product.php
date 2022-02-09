<?php

namespace dress_shop;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
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

    // a product may have many reviews
    public function reviews() {
        return $this->hasMany('dress_shop\Review');
    }

    public function getRating() {
        $reviews = $this->reviews;
        $rating = 0;
        foreach ($reviews as $review) {
            $rating += $review->rating;
        }
        if ($rating == 0) {
            return 0;
        }
        return $rating / $reviews->count();
    }
}
