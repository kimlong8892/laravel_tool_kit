<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostCreateRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Post\PostRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use SebastianBergmann\ObjectEnumerator\Exception;

class PostController extends Controller {
    protected PostRepositoryInterface $postRepository;
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(
        PostRepositoryInterface     $postRepository,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View {
        $listPost = $this->postRepository->getListInAdmin();

        return view('admin.post.index', compact('listPost'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View {
        $listCategory = $this->categoryRepository->getListSelect();

        return view('admin.post.create', compact('listCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostCreateRequest $request
     * @return JsonResponse
     */
    public function store(PostCreateRequest $request): JsonResponse {
        try {
            $request->request->set('admin_id', Auth::guard('admin')->user()->getAttribute('id'));
            $postId = $this->postRepository->store($request->all());
            Session::flash('success', __('Create success', ['id' => $postId]));

            return response()->json([
                'success' => true,
                'url' => route('admin.posts.edit', $postId)
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'success' => false,
                'mgs' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View {
        $post = $this->postRepository->getDetail($id);
        $listCategory = $this->categoryRepository->getListSelect();

        return view('admin.post.edit', compact('post', 'listCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PostUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(PostUpdateRequest $request, int $id): JsonResponse {
        try {
            $postId = $this->postRepository->update($id, $request->all());
            Session::flash('success', __('Update success', ['id' => $postId]));

            return response()->json([
                'success' => true,
                'url' => route('admin.posts.edit', $postId)
            ]);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response()->json([
                'success' => false,
                'mgs' => $exception->getMessage()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse {
        try {
            $postId = $this->postRepository->destroy($id);

            return redirect()->route('admin.posts.index')->with('success', __('Delete success', ['id' => $postId]));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function fieldManagement(Request $request): View {
        return view('admin.post.field_management');
    }
}