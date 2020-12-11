<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::resource('/categories', 'App\Http\Controllers\Api\CategoriesController');
Route::get('/categories/destroy/{id}', 'App\Http\Controllers\Api\CategoriesController@destroy')->name('c.destroy');


Route::resource('/faq', 'App\Http\Controllers\Api\FaqController');
Route::get('/faq/destroy/{id}', 'App\Http\Controllers\Api\FaqController@destroy')->name('f.destroy');