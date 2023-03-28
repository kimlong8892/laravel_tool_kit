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
        Route::get('index', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('home');
        Route::get('logout', [\App\Http\Controllers\Admin\Auth\LoginController::class, 'logout'])->name('logout');

        Route::resource('posts', \App\Http\Controllers\Admin\PostController::class);
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);

        Route::name('ajax.')->prefix('ajax')->group(function () {
            Route::get('get-product-select', [\App\Http\Controllers\Admin\PostController::class, 'getProductSelectAjax'])
                ->name('get_product_select');

            Route::get('render-product-row-in-post', [\App\Http\Controllers\Admin\PostController::class, 'renderProductRow'])
                ->name('render_product_row_in_post');
        });
    });
    // end need auth
});
