<?php

use Illuminate\Http\Request;

Route::post('/login','Admin\AuthController@login');

Route::get('/category','Admin\CategoryController@index');
Route::post('/category','Admin\CategoryController@store');
Route::put('/category/{category}','Admin\CategoryController@update');
Route::delete('/category/{category}','Admin\CategoryController@destroy');

Route::get('/branch','Admin\BranchController@index');
Route::post('/branch','Admin\BranchController@store');
Route::put('/branch/{branch}','Admin\BranchController@update');
Route::delete('/branch/{branch}','Admin\BranchController@destroy');
