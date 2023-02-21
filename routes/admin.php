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
\Illuminate\Support\Facades\App::setLocale('vi');

Route::name('admin.')->group(function () {
    // login, forgot
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', 'Admin\Auth\LoginController@showLoginForm')->name('login');
        Route::post('login', 'Admin\Auth\LoginController@login');
        Route::get('password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Admin\Auth\ResetPasswordController@reset')->name('password.update');
    });
    // end login, forgot

    // need auth
    Route::middleware('auth:admin')->group(function () {
        Route::get('/index', function () {
            print_r(\Illuminate\Support\Facades\Auth::guard('admin')->user()->toArray());
        })->name('home');
        Route::get('logout', 'Admin\Auth\LoginController@logout')->name('logout');
    });
    // end need auth
});
