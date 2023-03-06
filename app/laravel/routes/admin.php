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
        Route::get('login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'login']);
        Route::get('password/reset', [\App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
        Route::post('password/email', [\App\Http\Controllers\Admin\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
        Route::get('password/reset/{token}', [\App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
        Route::post('password/reset', [\App\Http\Controllers\Admin\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
    });
    // end login, forgot

    // need auth
    Route::middleware('auth:admin')->group(function () {
        Route::get('/index', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('home');
        Route::get('logout', 'Admin\Auth\LoginController@logout')->name('logout');

        Route::resource('campaigns', \App\Http\Controllers\Admin\CampaignController::class);
        Route::post('update-info-campaigns-accesstrade', [\App\Http\Controllers\Admin\CampaignController::class, 'updateInfoCampaignsAccesstrade'])->name('update-info-campaigns-accesstrade');

        Route::resource('campaigns', \App\Http\Controllers\Admin\CampaignController::class);
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('coupons', \App\Http\Controllers\Admin\CouponController::class);
    });
    // end need auth
});
