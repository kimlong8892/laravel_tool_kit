<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\Accesstrade\AccesstradeRepositoryInterface;
use App\Repositories\AccesstradeApi\AccesstradeApiRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller {
    protected AccesstradeApiRepositoryInterface $accesstradeApiRepository;
    protected AccesstradeRepositoryInterface $accesstradeRepository;
    protected CategoryRepositoryInterface $categoryRepository;

    public function __construct(
        AccesstradeApiRepositoryInterface $accesstradeApiRepository,
        AccesstradeRepositoryInterface    $accesstradeRepository,
        CategoryRepositoryInterface       $categoryRepository
    ) {
        $this->accesstradeApiRepository = $accesstradeApiRepository;
        $this->accesstradeRepository = $accesstradeRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        $listCampaign = $this->accesstradeRepository->getListCampaignSelectBox();

        return view('web.home.index', compact('listCampaign'));
    }

    public function getListCouponAjax(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        $merchant = $request->get('merchant') ?? null;
        $page = $request->get('page');
        $listCoupon = $this->accesstradeApiRepository->getListPromotion($merchant, $page);

        return view('web.home._list_coupon', compact('listCoupon', 'page'));
    }

    public function getListCategoryByCampaignId(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        $listCategory = $this->categoryRepository->getListByCampaignId($request->get('campaign_id'));

        return view('web.home._list_category', compact('listCategory'));
    }
}
