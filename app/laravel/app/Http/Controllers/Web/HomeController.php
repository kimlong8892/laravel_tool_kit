<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\Post\PostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\View\View;

class HomeController extends Controller {
    protected PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository) {
        $this->postRepository = $postRepository;
    }

    public function Index(Request $request): View {
        $listPost = $this->postRepository->getListPostInHomeWeb();
        //Artisan::call('command:update-product-price-history');
        return view('web.home.index', compact('listPost'));
    }

    public function searchProduct(Request $request) {

    }
}
