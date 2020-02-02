<?php

use Illuminate\Http\Request;

Route::post('/login','Admin\AuthController@login');

Route::get('/category','Admin\CategoryController@index');
Route::post('/category','Admin\CategoryController@store');
Route::put('/category/{category}','Admin\CategoryController@update');
Route::delete('/category/{category}','Admin\CategoryController@destroy');

Route::get('/toping','Admin\TopingController@index');
Route::get('/toping/category/{id}','Admin\TopingController@showByCategory');
Route::post('/toping','Admin\TopingController@store');
Route::put('/toping/{toping}','Admin\TopingController@update');
Route::delete('/toping/{toping}','Admin\TopingController@destroy');

Route::get('/branch','Admin\BranchController@index');
Route::post('/branch','Admin\BranchController@store');
Route::put('/branch/{branch}','Admin\BranchController@update');
Route::delete('/branch/{branch}','Admin\BranchController@destroy');

Route::get('/product','Admin\ProductController@index');
Route::post('/product','Admin\ProductController@store');
Route::get('/product/category/{id}','Admin\ProductController@showByCategory');



Route::post('test', 'Consumer\OrderController@store');

// Route::post('test', function () {
//     event(new App\Events\Order('Someone',3,1));
//     return "Event has been sent!";
// });
