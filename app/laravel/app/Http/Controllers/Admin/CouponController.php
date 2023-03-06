<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CouponStoreRequest;
use App\Http\Requests\CouponUpdateRequest;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Coupon\CouponRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use PHPUnit\Exception;

class CouponController extends Controller {
    protected CouponRepositoryInterface $couponRepository;
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(
        CouponRepositoryInterface $couponRepository,
        CategoryRepositoryInterface $categoryRepository
    ) {
        $this->couponRepository = $couponRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request): View {
        $listCoupon = $this->couponRepository->getList($request->get('name'), $request->get('category_id'));
        $listCategory = $this->categoryRepository->getListSelect();

        return view('admin.coupon.index', compact('listCoupon', 'listCategory'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View {
        $listCategory = $this->categoryRepository->getListSelect();

        return view('admin.coupon.create', compact('listCategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CouponStoreRequest $request
     * @return RedirectResponse
     */
    public function store(CouponStoreRequest $request): RedirectResponse {
        try {
            $couponId = $this->couponRepository->store($request->toArray());

            return redirect()->route('admin.coupons.edit', $couponId)->with('success', __('Create success', ['id' => $couponId]));
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
        $coupon = $this->couponRepository->getDetail($id);
        $listCategory = $this->categoryRepository->getListSelect();

        return view('admin.coupon.edit', compact('coupon', 'listCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CouponUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(CouponUpdateRequest $request, int $id): RedirectResponse {
        try {
            $couponId = $this->couponRepository->update($id, $request->toArray());

            return redirect()->route('admin.coupons.edit', $couponId)->with('success', __('Update success', ['id' => $couponId]));
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
            $this->couponRepository->destroy($id);

            return redirect()->back()->with('success', __('Destroy success', ['id' => $id]));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
