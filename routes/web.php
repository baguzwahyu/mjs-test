<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
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


Route::get('/admin', function () {
    return redirect(route('dashboard'));
});

Route::group(['prefix' => 'admin', 'middleware'=>'auth'],function (){
    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('dashboard','HomeController@index')->name('dashboard');

    Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
        Route::get('/read', 'ProductController@read')->name('read');
        Route::get('/read_detail', 'ProductController@read_detail')->name('read_detail');
        Route::get('/create', 'ProductController@create')->name('create');
        Route::post('/store', 'ProductController@store')->name('store');
        Route::get('/edit/{id}', 'ProductController@edit')->name('edit');
        Route::post('/update/{id}', 'ProductController@update')->name('update');
        Route::get('/detail/{id}', 'ProductController@detail')->name('detail');
        Route::get('/destroy/{id}', 'ProductController@destroy')->name('destroy');
        Route::get('/', 'ProductController@index')->name('index');
    });
    Route::group(['prefix' => 'transaction', 'as' => 'transaction.'], function () {
        Route::get('/read', 'TransactionController@read')->name('read');
        Route::get('/create', 'TransactionController@create')->name('create');
        Route::post('/store', 'TransactionController@store')->name('store');
        Route::get('/edit/{id}', 'TransactionController@edit')->name('edit');
        Route::post('/update/{id}', 'TransactionController@update')->name('update');
        Route::get('/destroy/{id}', 'TransactionController@destroy')->name('destroy');
        Route::get('/', 'TransactionController@index')->name('index');
    });

});

Route::get('/', function () {
    return view('auth.login');
});