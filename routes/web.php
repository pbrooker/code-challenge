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

Route::get('/', "SearchController@index")->name('home');
Route::post('/search', "SearchController@search");
Route::get('/detail/{type}/{id}/{name}', 'DetailController@show')->name('detail.show');
