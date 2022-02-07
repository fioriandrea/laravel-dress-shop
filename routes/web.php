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

    // Define a route to get to the form to add a new address.
    Route::get('/profile/add_address', [
        'uses' => 'AddressController@getAddAddress',
        'as' => 'get_add_address'
    ]);

    // Define route to add a new address.
    Route::post('/profile/add_address', [
        'uses' => 'AddressController@postAddAddress',
        'as' => 'add_address'
    ]);

    // Define a route to remove an existing address.
    Route::post('/profile/remove_address/{id}', [
        'uses' => 'AddressController@postRemoveAddress',
        'as' => 'remove_address'
    ]);

    // Define a route to get to the form to modify an existing address.
    Route::get('/profile/modify_address/{id}', [
        'uses' => 'AddressController@getModifyAddress',
        'as' => 'get_modify_address'
    ]);

    // Define a route to modify an existing address.
    Route::post('/profile/modify_address/{id}', [
        'uses' => 'AddressController@postModifyAddress',
        'as' => 'modify_address'
    ]);

    // Define a route to get to the form to add a new payment method.
    Route::get('/profile/add_payment_method', [
        'uses' => 'PaymentController@getAddPaymentMethod',
        'as' => 'get_add_payment_method'
    ]);

    // Define a route to add a new payment method.
    Route::post('/profile/add_payment_method', [
        'uses' => 'PaymentController@postAddPaymentMethod',
        'as' => 'add_payment_method'
    ]);

    // Define a route to modify an existing payment method.
    Route::post('/profile/modify_payment_method/{id}', [
        'uses' => 'PaymentController@postModifyPaymentMethod',
        'as' => 'modify_payment_method'
    ]);

    // Define a route to remove a payment method
    Route::post('/profile/remove_payment_method/{id}', [
        'uses' => 'PaymentController@postRemovePaymentMethod',
        'as' => 'remove_payment_method'
    ]);

    // Define a route to get to the form to modify an existing payment method.
    Route::get('/profile/modify_payment_method/{id}', [
        'uses' => 'PaymentController@getModifyPaymentMethod',
        'as' => 'get_modify_payment_method'
    ]);

    // Define a route to get to the checkout page
    Route::get('/checkout', [
        'uses' => 'CheckoutController@getCheckout',
        'as' => 'get_checkout'
    ]);

    // Define a route to process the checkout page
    Route::post('/checkout', [
        'uses' => 'CheckoutController@postCheckout',
        'as' => 'post_checkout'
    ]);

    // Define a route to get to the user's orders page
    Route::get('/orders', [
        'uses' => 'OrderController@getOrders',
        'as' => 'orders'
    ]);

    Route::post('/delete_order/{id}', [
        'uses' => 'OrderController@postDeleteOrder',
        'as' => 'delete_order'
    ]);

    // Error page route.
    Route::get('/error', [
        'uses' => 'ErrorController@getError',
        'as' => 'error'
    ]);

    // Define a route to get to the form to edit an existing product.
    Route::get('/product/edit/{id}', [
        'uses' => 'ProductController@getEditProduct',
        'as' => 'get_edit_product'
    ]);

    // Define a route to edit an existing product.
    Route::post('/product/edit/{id}', [
        'uses' => 'ProductController@postEditProduct',
        'as' => 'post_edit_product'
    ]);

    // Define a route to unlist an existing product.
    Route::post('/product/delete/{id}', [
        'uses' => 'ProductController@postUnlistProduct',
        'as' => 'post_unlist_product'
    ]);

    // Define a route to relist an existing product.
    Route::post('/product/relist/{id}', [
        'uses' => 'ProductController@postRelistProduct',
        'as' => 'post_relist_product'
    ]);
});
