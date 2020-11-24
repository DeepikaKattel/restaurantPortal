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

Route::resource('/categories', 'App\Http\Controllers\CategoriesController');
Route::get('/categories/destroy/{id}', 'App\Http\Controllers\CategoriesController@destroy')->name('c.destroy');

Route::resource('/item', 'App\Http\Controllers\ItemController');
Route::get('/item/destroy/{id}', 'App\Http\Controllers\ItemController@destroy')->name('item.destroy');

Route::resource('/order', 'App\Http\Controllers\OrderController');
Route::get('/order/destroy/{id}', 'App\Http\Controllers\OrderController@destroy')->name('order.destroy');

Route::resource('/offer', 'App\Http\Controllers\OfferController');
Route::get('/offer/destroy/{id}', 'App\Http\Controllers\OfferController@destroy')->name('offer.destroy');

Route::resource('/adminAbout', 'App\Http\Controllers\AboutController');
Route::get('/adminAbout/destroy/{id}', 'App\Http\Controllers\AboutController@destroy')->name('a.destroy');

Route::resource('/terms', 'App\Http\Controllers\TermsConditionController');
Route::get('/terms/destroy/{id}', 'App\Http\Controllers\TermsConditionController@destroy')->name('t.destroy');


Route::resource('/privacy', 'App\Http\Controllers\PrivacyPolicyController');
Route::get('/privacy/destroy/{id}', 'App\Http\Controllers\PrivacyPolicyController@destroy')->name('p.destroy');

Route::resource('/profile', 'App\Http\Controllers\ProfileController');
