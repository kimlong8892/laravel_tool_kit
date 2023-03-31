<?php

use Illuminate\Support\Facades\Route;


\Illuminate\Support\Facades\App::setLocale('vi');

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

// login with social
Route::get('/redirect/{social}', [\App\Http\Controllers\Web\SocialAuthController::class, 'redirect'])->name('social.redirect');
Route::get('/callback/{social}', [\App\Http\Controllers\Web\SocialAuthController::class, 'callback'])->name('social.callback');
// end login with social

// login, reg, forgot
Route::middleware('guest:web')->group(function () {
    Route::get('login', [\App\Http\Controllers\Web\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [\App\Http\Controllers\Web\Auth\LoginController::class, 'login']);
    Route::get('register', [\App\Http\Controllers\Web\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [\App\Http\Controllers\Web\Auth\RegisterController::class, 'register']);

    Route::get('password/reset', [\App\Http\Controllers\Web\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [\App\Http\Controllers\Web\Auth\ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [\App\Http\Controllers\Web\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [\App\Http\Controllers\Web\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});
// end login, reg, forgot

Route::name('post.')->prefix('post')->group(function () {
    Route::get('{slug}', [\App\Http\Controllers\Web\PostController::class, 'postDetail'])->name('detail');
});

Route::name('product.')->prefix('product')->group(function () {
    Route::get('{id}', [\App\Http\Controllers\Web\ProductController::class, 'Detail'])->name('detail');
});

Route::middleware('auth:web')->group(function () {
    Route::get('logout', [\App\Http\Controllers\Web\Auth\LoginController::class, 'logout'])->name('logout');
});

Route::get('/', [\App\Http\Controllers\Web\HomeController::class, 'Index'])->name('home');
