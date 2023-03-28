<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\Post\PostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller {
    protected PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository) {
        $this->postRepository = $postRepository;
    }

    public function Index(Request $request): View {
        $listPost = $this->postRepository->getListPostInHomeWeb();

        return view('web.home.index', compact('listPost'));
    }
}
