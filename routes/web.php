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

Route::view('/', 'index');

Auth::routes();

Route::group(['middleware' => ['auth', 'role:admin']], function() {
    Route::prefix('backend')->group(function () {
        Route::resource('draws', 'Backend\DrawController')->only(['create', 'store']);
        Route::get('winning-number', 'Backend\WinningNumberController@show');
    });
});

Route::get('/home', 'HomeController@index')->name('home');
