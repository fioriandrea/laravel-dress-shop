<?php

namespace dress_shop;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $table = 'sizes';

    /* A size has the following properties:
        - name
        - product_id
        - available
    */
    protected $fillable = ['name', 'product_id', 'available'];

    // a size belongs to a product
    public function product() {
        return $this->belongsTo('dress_shop\Product');
    }
}
