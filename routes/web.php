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
    'uses' => 'HomeController@getHome',
    'as' => 'home'
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

// Define a route for cart. It will be used to show the cart.
// The cart is associeted with a logged in user.
Route::get('/cart', [
    'uses' => 'CartController@getCart',
    'as' => 'cart'
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

// Define a route to change user's email.
// The email will be associated with a logged in user.
// The page will bring up a form to change the email.
Route::get('/change_email', [
    'uses' => 'UserController@getChangeEmail',
    'as' => 'change_email'
]);

// Define a route to change user's password.
// The password will be associated with a logged in user.
// The page will bring up a form to change the password.
Route::get('/change_password', [
    'uses' => 'UserController@getChangePassword',
    'as' => 'change_password'
]);

// Define a route to add a new address.
// The address will be associated with a logged in user.
// The page will bring up a form to add an address.
Route::get('/add_address', [
    'uses' => 'UserController@getAddAddress',
    'as' => 'add_address'
]);

// Define a route to change one of the user's addresses.
// The address will be associated with a logged in user.
// The page will bring up a form to change the specified address.
Route::get('/change_address/{id}', [
    'uses' => 'UserController@getChangeAddress',
    'as' => 'change_address'
]);

// Define a route to delete an address.
// The address will be associated with a logged in user.
// The page will bring up a form to delete the specified address.
// The address cannot be deleted if it is the only address for the user.
Route::get('/delete_address/{id}', [
    'uses' => 'UserController@getDeleteAddress',
    'as' => 'delete_address'
]);

// Define a route to add a new payment method.
// The payment method will be associated with a logged in user.
// The page will bring up a form to add a payment method.
Route::get('/add_payment_method', [
    'uses' => 'UserController@getAddPaymentMethod',
    'as' => 'add_payment_method'
]);

// Define a route to change one of the user's payment method.
// The payment method will be associated with a logged in user.
// The page will bring up a form to change a payment method.
Route::get('/change_payment_method/{id}', [
    'uses' => 'UserController@getChangePaymentMethod',
    'as' => 'change_payment_method'
]);

// Define a route to delete a payment method.
// The payment method will be associated with a logged in user.
// The page will bring up a form to delete a payment method.
Route::get('/delete_payment_method/{id}', [
    'uses' => 'UserController@getDeletePaymentMethod',
    'as' => 'delete_payment_method'
]);
