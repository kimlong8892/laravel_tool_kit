<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\Accesstrade\AccesstradeRepositoryInterface;
use App\Repositories\AccesstradeApi\AccesstradeApiRepositoryInterface;
use Illuminate\Http\Request;

class HomeController extends Controller {
    protected AccesstradeApiRepositoryInterface $accesstradeApiRepository;
    protected AccesstradeRepositoryInterface $accesstradeRepository;

    public function __construct(
        AccesstradeApiRepositoryInterface $accesstradeApiRepository,
        AccesstradeRepositoryInterface $accesstradeRepository
    ) {
        $this->accesstradeApiRepository = $accesstradeApiRepository;
        $this->accesstradeRepository = $accesstradeRepository;
    }

    public function index(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        $listCampaign = $this->accesstradeRepository->getListCampaignSelectBox();

        return view('web.home.index', compact('listCampaign'));
    }

    public function getListCouponAjax(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application {
        $merchant = $request->get('merchant') ?? null;
        $listCoupon = $this->accesstradeApiRepository->getListPromotion($merchant);

        return view('web.home._list_coupon', compact('listCoupon'));
    }
}
