<?php

namespace dress_shop;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // A user has many cart products
    public function cartProducts()
    {
        return $this->hasMany('dress_shop\CartProduct');
    }

    // A user has many addresses
    public function addresses()
    {
        return $this->hasMany('dress_shop\Address');
    }

    public function validAddresses() {
        return $this->addresses->filter(function($address) {
            return $address->cancelled == 0;
        });
    }

    public function validPaymentMethods() {
        return $this->paymentMethods->filter(function($paymentMethod) {
            return $paymentMethod->cancelled == 0;
        });
    }

    // A user has many payment methods
    public function paymentMethods()
    {
        return $this->hasMany('dress_shop\PaymentMethod');
    }

    // A user has many orders
    public function orders()
    {
        return $this->hasMany('dress_shop\Order');
    }

    public function isAdmin()
    {
        return $this->type == 'admin';
    }

    // A user has many order products
    public function orderProducts()
    {
        return $this->hasMany('dress_shop\OrderProduct');
    }

    // A user has many reviews
    public function reviews()
    {
        return $this->hasMany('dress_shop\Review');
    }

    public function hasReviewed($productId)
    {
        return $this->reviews->contains('product_id', $productId);
    }

    public function reviewId($productId)
    {
        $review = $this->reviews->where('product_id', $productId)->first();
        if ($review == null) {
            return null;
        }
        return $review->id;
    }

    public function hasBought($productId)
    {
        $orderProducts = $this->orderProducts->where('product_id', $productId);
        foreach ($orderProducts as $orderProduct) {
            if ($orderProduct->order->status == 'confirmed') {
                return true;
            }
        }
        return false;
    }
}
