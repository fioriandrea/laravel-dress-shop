<?php

namespace dress_shop;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';
    protected $fillable = ['id', 'name', 'category', 'brand', 'shipping', 'price', 'description', 'short_description', 'S', 'M', 'L', 'XL'];

    public function images() {
        return $this->hasMany('dress_shop\Image');
    }

    public function sizes() {
        return $this->S + $this->M + $this->L + $this->XL;
    }

    public function firstImage() {
        return $this->images()->first();
    }
}
