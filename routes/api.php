
<?php

use Illuminate\Http\Request;

Route::post('/login','Admin\AuthController@login');


Route::get('/category','Admin\CategoryController@index');
Route::get('/category/{category}','Admin\CategoryController@show');
Route::get('/category/search/{keyword}','Admin\CategoryController@search');
Route::post('/category','Admin\CategoryController@store');
Route::put('/category/{category}','Admin\CategoryController@update');
Route::delete('/category/{category}','Admin\CategoryController@destroy');

Route::get('/toping','Admin\TopingController@index');
Route::get('/toping/category/{id}','Admin\TopingController@showByCategory');
Route::post('/toping','Admin\TopingController@store');
Route::get('/toping/{id}','Admin\TopingController@show');
Route::delete('/toping/{id}','Admin\TopingController@destroy');

// Route::put('/toping/{id}','Admin\TopingController@update');
// Route::delete('/toping/{id}','Admin\TopingController@destroy');

Route::get('/branch','Admin\BranchController@index');
Route::post('/branch','Admin\BranchController@store');
Route::put('/branch/{branch}','Admin\BranchController@update');
Route::delete('/branch/{branch}','Admin\BranchController@destroy');

Route::get('/product','Consumer\ProductController@index');
Route::get('/product/category/{id}','Consumer\ProductController@showByCategory');
Route::get('/product/search/{keyword}','Consumer\ProductController@search');
// Route::post('/produk/tambah','Admin\ProductController@store');

Route::group(['prefix' => '/admin'], function(){
  Route::get('/product','Admin\ProductController@index');
  Route::get('/product/category/{id}','Admin\ProductController@showByCategory');
  Route::get('/product/search/{keyword}','Admin\ProductController@search');
  Route::post('/product','Admin\ProductController@store');
  Route::post('/product/{id}','Admin\ProductController@update');

});
// Route::post('test', 'Consumer\OrderController@store');


// Route::get('test', function () {
//     event(new App\Events\Order('Someone',3,1));
//     return "Event has been sent!";
// });
