<?php

namespace PW_runningExample_v6_Laravel;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 'author';
    public $timestamps = false;
    
    protected $fillable = ['firstname', 'lastname', 'user_id'];
    
    public function user() {
        // use the 'user' property: $author->user (returns an object LibUser)
        return $this->belongsTo('PW_runningExample_v6_Laravel\LibUser');
    }
    
    public function books() {
        // use the 'books' property: $author->books (returns an array)
        return $this->hasMany('PW_runningExample_v6_Laravel\Book');
    } 
    
}

