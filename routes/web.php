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

    Route::get('/', 'Front\HomeController@index')->name('index');
    Route::post('/search', 'Front\HomeController@search')->name('search');
    Route::get('/archive/{date?}', 'Front\HomeController@archive')->name('archive');
    Route::get('/archive_day/{date?}', 'Front\HomeController@archiveDay')->name('archive_day');

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function() {
    Route::get('/', 'Admin\HomeController@index')->name('admin.index');
    Route::get('/password', 'Admin\PasswordController@index')->name('admin.password.index');
    Route::put('/password', 'Admin\PasswordController@update')->name('admin.password.update');
    Route::get('/site', 'Admin\SiteController@index')->name('admin.site.index');
    Route::put('/site', 'Admin\SiteController@update')->name('admin.site.update');


    Route::get('/user', 'Admin\UserController@index')->name('admin.user.index');
    Route::put('/user', 'Admin\UserController@update')->name('admin.user.update');

// Category
    Route::get('/category', 'Admin\CategoryController@index')->name('admin.category.index');
    Route::get('/category/create', 'Admin\CategoryController@create')->name('admin.category.create');
    Route::post('/category', 'Admin\CategoryController@store')->name('admin.category.store');
    Route::get('/category/edit/{id?}', 'Admin\CategoryController@edit')->name('admin.category.edit');
    Route::put('/category/edit/{id?}', 'Admin\CategoryController@update')->name('admin.category.update');
    Route::delete('/category/{id?}', 'Admin\CategoryController@destroy')->name('admin.category.delete');

// Post
    Route::get('/post', 'Admin\PostController@index')->name('admin.post.index');
    Route::get('/post/create', 'Admin\PostController@create')->name('admin.post.create');
    Route::post('/post', 'Admin\PostController@store')->name('admin.post.store');
    Route::get('/post/edit/{id?}', 'Admin\PostController@edit')->name('admin.post.edit');
    Route::put('/post/edit/{id?}', 'Admin\PostController@update')->name('admin.post.update');
    Route::delete('/post/delete/{id?}', 'Admin\PostController@destroy')->name('admin.post.delete');

// Tag
    Route::get('/tag', 'Admin\TagController@index')->name('admin.tag.index');
    Route::get('/tag/create', 'Admin\TagController@create')->name('admin.tag.create');
    Route::post('/tag', 'Admin\TagController@store')->name('admin.tag.store');
    Route::get('/tag/edit/{id?}', 'Admin\TagController@edit')->name('admin.tag.edit');
    Route::put('/tag/edit/{id?}', 'Admin\TagController@update')->name('admin.tag.update');
    Route::delete('/tag/delete/{id?}', 'Admin\TagController@destroy')->name('admin.tag.delete');

// Image
    Route::get('/image', 'Admin\ImageController@index')->name('admin.image.index');
    Route::post('/image', 'Admin\ImageController@store')->name('admin.image.store');
    Route::put('/image/edit/{id?}', 'Admin\ImageController@update')->name('admin.image.update');
    Route::delete('/image/{id?}', 'Admin\ImageController@destroy')->name('admin.image.delete');


// Comment
    Route::get('/comment', 'Admin\CommentController@index')->name('admin.comment.index');
    Route::delete('/comment/{id}', 'Admin\CommentController@destroy')->name('admin.comment.index');

// Template
    Route::resource('/template', 'Admin\TemplateController');
});

Route::post('/{id}/comment', 'Front\CommentController@store')->name('post.comment.store');
Route::get('/{link}', 'Front\PostController@show')->name('post.detail');



