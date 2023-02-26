<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\Accesstrade\AccesstradeRepositoryInterface;
use App\Repositories\AccesstradeApi\AccesstradeApiRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Coupon\CouponRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Contracts\Foundation\Application;

class HomeController extends Controller {
    protected AccesstradeApiRepositoryInterface $accesstradeApiRepository;
    protected AccesstradeRepositoryInterface $accesstradeRepository;
    protected CategoryRepositoryInterface $categoryRepository;
    protected CouponRepositoryInterface $couponRepository;

    public function __construct(
        AccesstradeApiRepositoryInterface $accesstradeApiRepository,
        AccesstradeRepositoryInterface    $accesstradeRepository,
        CategoryRepositoryInterface       $categoryRepository,
        CouponRepositoryInterface         $couponRepository,
    ) {
        $this->accesstradeApiRepository = $accesstradeApiRepository;
        $this->accesstradeRepository = $accesstradeRepository;
        $this->categoryRepository = $categoryRepository;
        $this->couponRepository = $couponRepository;
    }

    public function index(Request $request): Factory|View|Application {
        $listCampaign = $this->accesstradeRepository->getListCampaignSelectBox();
        $merchant = $request->get('merchant');
        $categoryId = $request->get('category_id');
        $isAccesstrade = false;
        $listCategory = [];
        $listCoupon = [];
        $page = $request->get('page') ?? 1;

        if (!empty($merchant)) {
            $listCategory = $this->categoryRepository->getListByCampaignAccesstradeMerchant($request->get('merchant'));
        }

        if (!empty($categoryId)) {
            $category = $this->categoryRepository->getDetail($categoryId);
            $isAccesstrade = $category->is_accesstrade;

            if ($isAccesstrade) {
                $listCoupon = $this->accesstradeApiRepository->getListPromotion($merchant, $page);
            } else {
                $listCoupon = $this->couponRepository->getListByCategoryId($categoryId, $page);
            }
        }

        return view('web.home.index', compact('listCampaign', 'listCategory', 'listCoupon', 'isAccesstrade', 'page'));
    }

    public function getListCouponAjax(Request $request): Factory|View|Application {
        $merchant = $request->get('merchant') ?? null;
        $page = $request->get('page');
        $listCoupon = $this->accesstradeApiRepository->getListPromotion($merchant, $page);

        return view('web.home._list_coupon', compact('listCoupon', 'page'));
    }

    public function getListCategoryByCampaignId(Request $request): Factory|View|Application {
        $listCategory = $this->categoryRepository->getListByCampaignId($request->get('campaign_id'));

        return view('web.home._list_category', compact('listCategory'));
    }
}
