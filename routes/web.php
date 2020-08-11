<?php

use App\Http\Controllers\ProductTypeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/admin', function () {
    return view('admin.pages.index');
});
Route::get('getproducttype','AjaxController@getProductType');
Route::group(['prefix' =>'admin'],function(){
    Route::resource('category', 'CategoryController');
    Route::resource('producttype', 'ProductTypeController');
    Route::resource('product', 'ProductController');
    Route::post('updatePro/{id}','ProductController@update');
});


