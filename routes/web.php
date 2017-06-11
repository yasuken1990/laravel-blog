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
Route::get('/', 'FrontController@index')->name('index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/admin', 'AdminController@index')->name('admin.index');
Route::get('/admin/basic', 'AdminBasicController@index')->name('admin.basic.index');
Route::put('/admin/basic', 'AdminBasicController@update')->name('admin.basic.update');

// Category
Route::get('/admin/categories', 'AdminCategoryController@index')->name('admin.categories.index');
Route::get('/admin/categories/create', 'AdminCategoryController@create')->name('admin.categories.create');
Route::post('/admin/categories', 'AdminCategoryController@store')->name('admin.categories.store');
Route::get('/admin/categories/edit/{id}', 'AdminCategoryController@edit')->name('admin.categories.edit');
Route::put('/admin/categories/edit/{id}', 'AdminCategoryController@update')->name('admin.categories.update');
Route::delete('/admin/categories/{id}', 'AdminCategoryController@destroy')->name('admin.categories.delete');

// Post
Route::get('/admin/posts', 'AdminPostController@index')->name('admin.post.index');
Route::get('/admin/posts/create', 'AdminPostController@create')->name('admin.post.create');
Route::post('/admin/posts', 'AdminPostController@store')->name('admin.post.store');
Route::get('/admin/posts/edit/{id}', 'AdminPostController@edit')->name('admin.post.edit');
Route::put('/admin/posts/edit/{id}', 'AdminPostController@update')->name('admin.post.update');
Route::delete('/admin/posts/delete/{id}', 'AdminPostController@destroy')->name('admin.post.delete');

Route::get('/{link}', 'PostController@show')->name('post.detail');
