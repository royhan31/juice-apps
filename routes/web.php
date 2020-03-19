
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

Route::get('/', function () {
    return view('login');
})->name('login')->middleware('guest');

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('test', function () {
  event(new App\Events\Order('Someone',1));
  return "Event has been sent!";
});

Route::post('/login','Admin\AuthController@webLogin')->name('web-login');
Route::get('/beranda', 'HomeController@index')->name('dashboard');
Route::get('/kategori', 'HomeController@category')->name('category');
Route::get('/produk', 'HomeController@product')->name('product');
Route::get('/produk/tambah', 'HomeController@productCreate')->name('productCreate');
Route::get('/produk/edit/{id}', 'HomeController@productEdit')->name('productEdit');
Route::get('/toping','HomeController@toping')->name('toping');
Route::get('/cabang','HomeController@branch')->name('branch');
Route::get('/laporan','HomeController@order')->name('order');
