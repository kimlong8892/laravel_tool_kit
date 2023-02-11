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

Route::get('/', [\App\Http\Controllers\Web\HomeController::class, 'index'])->name('home');

Route::get('/download-video-youtube', [\App\Http\Controllers\Web\DownloadVideoYoutube::class, 'downloadVideoPage'])->name('download_video_youtube');
