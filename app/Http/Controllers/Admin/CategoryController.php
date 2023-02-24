<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Repositories\Campaign\CampaignRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use PHPUnit\Exception;

class CategoryController extends Controller {
    protected CategoryRepositoryInterface $categoryRepository;
    protected CampaignRepositoryInterface $campaignRepository;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        CampaignRepositoryInterface $campaignRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->campaignRepository = $campaignRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request): View {
        $listCategory = $this->categoryRepository->getList($request->get('name'), $request->get('campaign_id'));
        $listCampaign = $this->campaignRepository->getListSelect();

        return view('admin.category.index', compact('listCategory', 'listCampaign'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View {
        $listCampaign = $this->campaignRepository->getListSelect();

        return view('admin.category.create', compact('listCampaign'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CategoryStoreRequest $request): RedirectResponse {
        try {
            $campaignId = $this->categoryRepository->store($request->toArray());

            return redirect()->route('admin.categories.edit', $campaignId)->with('success', __('Create success', ['id' => $campaignId]));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View {
        $category = $this->categoryRepository->getDetail($id);
        $listCampaign = $this->campaignRepository->getListSelect();

        return view('admin.category.edit', compact('category', 'listCampaign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse {
        try {
            $campaignId = $this->categoryRepository->update($id, $request->toArray());

            return redirect()->route('admin.categories.edit', $campaignId)->with('success', __('Update success', ['id' => $campaignId]));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', $exception->getMessage());
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
            $this->categoryRepository->destroy($id);

            return redirect()->back()->with('success', __('Destroy success', ['id' => $id]));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
