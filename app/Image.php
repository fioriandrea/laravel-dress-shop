<?php

namespace dress_shop;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    /* an image has the following properties:
        - product_id
        - url
    */
    protected $fillable = ['product_id', 'url'];

    // an image belongs to a product
    public function product() {
        return $this->belongsTo('dress_shop\Product');
    }
}
