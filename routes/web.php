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

Route::get('/admin', 'AdminController@index')->name('admin.index');
Route::get('/admin/password', 'AdminPasswordController@index')->name('admin.password.index');
Route::put('/admin/password', 'AdminPasswordController@update')->name('admin.password.update');
Route::get('/admin/site', 'AdminSiteController@index')->name('admin.site.index');
Route::put('/admin/site', 'AdminSiteController@update')->name('admin.site.update');


Route::get('/admin/user', 'AdminUserController@index')->name('admin.user.index');
Route::put('/admin/user', 'AdminUserController@update')->name('admin.user.update');

// Category
Route::get('/admin/category', 'AdminCategoryController@index')->name('admin.category.index');
Route::get('/admin/category/create', 'AdminCategoryController@create')->name('admin.category.create');
Route::post('/admin/category', 'AdminCategoryController@store')->name('admin.category.store');
Route::get('/admin/category/edit/{id?}', 'AdminCategoryController@edit')->name('admin.category.edit');
Route::put('/admin/category/edit/{id?}', 'AdminCategoryController@update')->name('admin.category.update');
Route::delete('/admin/category/{id?}', 'AdminCategoryController@destroy')->name('admin.category.delete');

// Post
Route::get('/admin/post', 'AdminPostController@index')->name('admin.post.index');
Route::get('/admin/post/create', 'AdminPostController@create')->name('admin.post.create');
Route::post('/admin/post', 'AdminPostController@store')->name('admin.post.store');
Route::get('/admin/post/edit/{id?}', 'AdminPostController@edit')->name('admin.post.edit');
Route::put('/admin/post/edit/{id?}', 'AdminPostController@update')->name('admin.post.update');
Route::delete('/admin/post/delete/{id?}', 'AdminPostController@destroy')->name('admin.post.delete');

Route::get('/{link}', 'PostController@show')->name('post.detail');
