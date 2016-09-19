<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
 */

Route::get('/', [
	'uses' => 'ProductController@getIndex',
	'as' => 'product.index',
]);

Route::get('add-to-cart/{id}', [
	'uses' => 'ProductController@getAddToCart',
	'as' => 'product.addToCart',
]);

Route::get('reduce/{id}', [
	'uses' => 'ProductController@getReduceByOne',
	'as' => 'product.reduceByOne',
]);

Route::get('removeall/{id}', [
	'uses' => 'ProductController@getRemoveItem',
	'as' => 'product.removeAll',
]);

Route::get('checkout', [
	'uses' => 'ProductController@getCheckout',
	'as' => 'checkout',
]);

Route::post('checkout', [
	'uses' => 'ProductController@postCheckout',
	'as' => 'checkout',
]);

Route::get('shopping-cart', [
	'uses' => 'ProductController@getCart',
	'as' => 'product.shoppingCart',
]);

Route::get('profile', [
	'uses' => 'ProductController@getProfile',
	'as' => 'view.Profile',
]);

Route::group(['prefix' => 'users'], function () {});

Auth::routes();
