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

Route::resource('ingredients', 'IngredientController');
Route::resource('dishes', 'DishController');
Route::resource('orders', 'OrderController');
Route::match(['put', 'patch'], 'orders/{id}/close', 'OrderController@close')->name('orders.close');
Route::match(['get', 'head'], 'orders/search/list', 'OrderController@search')->name('orders.search');
Route::match(['get', 'head'], 'orders/list/show','OrderController@orderList')->name('orders.orderList');


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');
