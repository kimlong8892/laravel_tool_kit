<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\PostStoreRequest;
use App\Http\Requests\Post\PostUpdateRequest;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\ProductShopeeApi\ProductShopeeApiRepositoryInterface;
use App\Repositories\Tag\TagRepositoryInterface;
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
    protected TagRepositoryInterface $tagRepository;
    protected ProductShopeeApiRepositoryInterface $productShopeeApiRepository;

    public function __construct(
        PostRepositoryInterface             $postRepository,
        CategoryRepositoryInterface         $categoryRepository,
        TagRepositoryInterface              $tagRepository,
        ProductShopeeApiRepositoryInterface $productShopeeApiRepository,
    ) {
        $this->postRepository = $postRepository;
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
        $this->productShopeeApiRepository = $productShopeeApiRepository;
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
        $listTag = $this->tagRepository->getListSelect();

        return view('admin.post.create', compact('listCategory', 'listTag'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostStoreRequest $request
     * @return JsonResponse
     */
    public function store(PostStoreRequest $request): JsonResponse {
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
        $listTag = $this->tagRepository->getListSelect();

        return view('admin.post.edit', compact('post', 'listCategory', 'listTag'));
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

    public function getProductSelectAjax(Request $request): JsonResponse {
        if (empty($request->get('term'))) {
            return response()->json([]);
        }

        $listProduct = $this->productShopeeApiRepository->getListProductApi($request->get('term'))['data']['productOfferV2']['nodes'] ?? [];
        return response()->json($listProduct);
    }

    public function renderChildField(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        $listField = $this->postRepository->getCustomFields($request->get('id'));

        return view('admin.post.include.list_field_for_group', compact('listField'));
    }
}
