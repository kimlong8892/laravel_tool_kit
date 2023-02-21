<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\AccesstradeApi\AccesstradeApiRepositoryInterface;
use Illuminate\Http\Request;
use YouTube\Exception\YouTubeException;
use YouTube\YouTubeDownloader;

class HomeController extends Controller {
    protected AccesstradeApiRepositoryInterface $accesstradeApiRepository;

    public function __construct(AccesstradeApiRepositoryInterface $accesstradeApiRepository) {
        $this->accesstradeApiRepository = $accesstradeApiRepository;
    }

    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        //$listPromotion = $this->accesstradeApiRepository->getListPromotion();

        return view('web.home.index');
    }
}
