<?php

use Illuminate\Support\Facades\Route;

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
//Static Pages
Route::get('/', 'StaticPageController@home')->name('homepage');
Route::get('/about', 'StaticPageController@about')->name('about');

//Resources Pages (CRUD)
Route::resource('products' , 'ProductController');
