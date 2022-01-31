<?php

namespace dress_shop\Providers;

use Illuminate\Support\ServiceProvider;

// import View class
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('categories', ['Shirts', 'Shoes', 'Suits', 'Hats', 'Pants', 'Ties']);
        View::share('sizes', ['S', 'M', 'L', 'XL']);
    }
}
