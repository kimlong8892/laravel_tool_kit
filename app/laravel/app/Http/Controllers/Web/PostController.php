<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\Post\PostRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller {
    protected PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository) {
        $this->postRepository = $postRepository;
    }

    public function postDetail(Request $request, $slug): View {
        $post = $this->postRepository->getDetailInWeb($slug);

        return view('web.post.detail', compact('post'));
    }
}
