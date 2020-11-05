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
    return view('auth.login');
});

Auth::routes();
Route::get('/logout', [App\Http\Controllers\HomeController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/approval', [App\Http\Controllers\HomeController::class, 'approval'])->name('approval');
    Route::middleware(['approved'])->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    });
    Route::middleware(['admin'])->group(function () {
        Route::get('/usersUnapproved', [App\Http\Controllers\UserController::class, 'unapproved'])->name('admin.unapproved');
        Route::get('/users/{user_id}/approve', [App\Http\Controllers\UserController::class, 'approve'])->name('admin.approve');

        Route::resource('/users', 'App\Http\Controllers\UserController');
        Route::get('/users/destroy/{id}', 'App\Http\Controllers\UserController@destroy')->name('u.destroy');
    });
});

Route::resource('/foodCategories', 'App\Http\Controllers\FoodCategoriesController');
Route::get('/foodCategories/destroy/{id}', 'App\Http\Controllers\FoodCategoriesController@destroy')->name('f.destroy');

Route::resource('/food', 'App\Http\Controllers\FoodController');
Route::get('/food/destroy/{id}', 'App\Http\Controllers\FoodController@destroy')->name('food.destroy');

Route::resource('/profile', 'App\Http\Controllers\ProfileController');
