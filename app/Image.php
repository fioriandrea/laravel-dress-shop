<?php

namespace dress_shop;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'picture';
    public $timestamps = false;
    protected $fillable = ['product_id', 'url'];

    // an image belongs to a product
    public function product() {
        return $this->belongsTo('dress_shop\Product');
    }
}
