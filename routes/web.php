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

// Auth routes

Auth::routes();

// home page route

Route::get('/', 'PagesController@index');

Route::get('privacy', 'PagesController@privacy');

Route::get('terms-of-service', 'PagesController@terms');

// admin route

Route::get('/admin', 'AdminController@index')->name('admin');

// test route

Route::get('test','TestController@index');

// Widget routes

Route::get('widget/create', 'WidgetController@create')->name('widget.create');

Route::get('widget/{widget}-{slug?}', 'WidgetController@show')->name('widget.show');

Route::resource('widget', 'WidgetController', ['except' => ['show', 'create']]);
