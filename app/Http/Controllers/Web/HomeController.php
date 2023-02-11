<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use YouTube\Exception\YouTubeException;
use YouTube\YouTubeDownloader;

class HomeController extends Controller {
    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        return view('web.home.index');
    }
}
