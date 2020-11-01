<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');

Route::resource('/foodCategories', 'App\Http\Controllers\FoodCategoriesController');
Route::get('/foodCategories/destroy/{id}', 'App\Http\Controllers\FoodCategoriesController@destroy')->name('f.destroy');

Route::resource('/food', 'App\Http\Controllers\FoodController');
Route::get('/food/destroy/{id}', 'App\Http\Controllers\FoodController@destroy')->name('food.destroy');
