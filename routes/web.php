<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Define a route for the home page.
// It will be the default route.
Route::get('/', [
    'uses' => 'IndexController@getIndex',
    'as' => 'index'
]);

// Define a route for the user login page.
Route::get('/login', [
    'uses' => 'AuthController@getLogin',
    'as' => 'login'
]);

// Define a route to login a user.
Route::post('/login', [
    'uses' => 'AuthController@postLogin',
    'as' => 'login'
]);

// Define a route for the registration page.
Route::get('/register', [
    'uses' => 'AuthController@getRegister',
    'as' => 'register'
]);

// Define a route to register a user.
Route::post('/register', [
    'uses' => 'AuthController@postRegister',
    'as' => 'register'
]);

// Define a route to logout a user.
Route::post('/logout', [
    'uses' => 'AuthController@postLogout',
    'as' => 'logout'
]);

// Define a route for product_list. It will be used to show a list of products.
// This list will not, in general, have all the products in it.
// The products will be filtered based on search criteria.
Route::get('/product_list', [
    'uses' => 'ProductController@getProductList',
    'as' => 'product_list'
]);

// Define a route for product, which will be used to show a single product.
// The product will be filtered based on the product id.
Route::get('/product/{id}', [
    'uses' => 'ProductController@getProduct',
    'as' => 'product'
]);

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index')->name('home');

// Use auth middleware to redirect users who are not logged in.
// This will be used to prevent users from accessing pages that require
// a logged in user.
Route::group(['middleware' => ['auth']], function() {
    // Define a route for cart. It will be used to show the cart.
    // The cart is associeted with a logged in user.
    Route::get('/cart', [
        'uses' => 'CartController@getCart',
        'as' => 'cart'
    ]);

    // Define a route for add_to_cart. It will be used to add a product to the cart.
    // The product will be filtered based on the product id.
    Route::post('/add_to_cart', [
        'uses' => 'CartController@addToCart',
        'as' => 'add_to_cart'
    ]);

    // Define a route to update the number of items in the cart.
    // The product will be filtered based on the product id.
    Route::post('/update_cart', [
        'uses' => 'CartController@updateCart',
        'as' => 'update_cart'
    ]);
    
    // Define a route for remove_from_cart. It will be used to remove a product from the cart.
    // The product will be filtered based on the product id.
    Route::post('/remove_from_cart', [
        'uses' => 'CartController@removeFromCart',
        'as' => 'remove_from_cart'
    ]);

    // Define a route to get the user's orders.
    Route::get('/orders', [
        'uses' => 'OrderController@getOrders',
        'as' => 'orders'
    ]);

    // Define a route for the user profile.
    // The profile is associated with a logged in user.
    Route::get('/profile', [
        'uses' => 'UserController@getProfile',
        'as' => 'profile'
    ]);
});