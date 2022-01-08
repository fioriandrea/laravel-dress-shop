<?php

namespace PW_runningExample_v6_Laravel;

use Illuminate\Database\Eloquent\Model;

class LibUser extends Model
{
    protected $table = "user";
    public $timestamps = false;
    
    protected $fillable = ['username', 'password', 'email'];
    
    public function authors() {
        // use the 'authors' property: $user->authors (returns an array)
        return $this->hasMany('PW_runningExample_v6_Laravel\Author');
    }    
    
    public function books() {
        // use the 'books' property: $user->books (returns an array)
        return $this->hasMany('PW_runningExample_v6_Laravel\Book');
    } 
}
