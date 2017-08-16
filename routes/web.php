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
Auth::routes();

Route::get('/', 'FrontController@index')->name('index');
Route::post('/search', 'FrontController@search')->name('search');
Route::get('/archive/{date?}', 'FrontController@archive')->name('archive');
Route::get('/archive_day/{date?}', 'FrontController@archiveDay')->name('archive_day');



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

// Tag
Route::get('/admin/tag', 'AdminTagController@index')->name('admin.tag.index');
Route::get('/admin/tag/create', 'AdminTagController@create')->name('admin.tag.create');
Route::post('/admin/tag', 'AdminTagController@store')->name('admin.tag.store');
Route::get('/admin/tag/edit/{id?}', 'AdminTagController@edit')->name('admin.tag.edit');
Route::put('/admin/tag/edit/{id?}', 'AdminTagController@update')->name('admin.tag.update');
Route::delete('/admin/tag/delete/{id?}', 'AdminTagController@destroy')->name('admin.tag.delete');

// Image
Route::get('/admin/image', 'AdminImageController@index')->name('admin.image.index');
Route::post('/admin/image', 'AdminImageController@store')->name('admin.image.store');
Route::put('/admin/image/edit/{id?}', 'AdminImageController@update')->name('admin.image.update');
Route::delete('/admin/image/{id?}', 'AdminImageController@destroy')->name('admin.image.delete');


// Comment
Route::get('admin/comment', 'AdminCommentController@index')->name('admin.comment.index');
Route::delete('admin/comment/{id}', 'AdminCommentController@destroy')->name('admin.comment.index');
Route::post('/{id}/comment', 'CommentController@store')->name('post.comment.store');
Route::get('/{link}', 'PostController@show')->name('post.detail');

// Template
Route::resource('/admin/template', 'AdminTemplateController');


