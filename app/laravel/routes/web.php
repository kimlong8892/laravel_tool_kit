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


Route::middleware('auth:web')->group(function () {
    Route::get('logout', [\App\Http\Controllers\Web\Auth\LoginController::class, 'logout'])->name('logout');
});

Route::get('/', [\App\Http\Controllers\Web\HomeController::class, 'index'])->name('home');
Route::get('/get_list_category_by_campaign_id', [\App\Http\Controllers\Web\HomeController::class, 'getListCategoryByCampaignId'])->name('ajax.get_list_category_by_campaign_id');
Route::get('/get-list-coupon-ajax', [\App\Http\Controllers\Web\HomeController::class, 'getListCouponAjax'])->name('ajax.get_list_coupon');
Route::get('/download-video-youtube', [\App\Http\Controllers\Web\DownloadVideoYoutube::class, 'downloadVideoPage'])->name('download_video_youtube');
