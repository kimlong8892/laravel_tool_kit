<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\Accesstrade\AccesstradeRepositoryInterface;
use App\Repositories\AccesstradeApi\AccesstradeApiRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Coupon\CouponRepositoryInterface;
use App\Repositories\CrawlShopee\CrawlShopeeRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller {
    protected AccesstradeApiRepositoryInterface $accesstradeApiRepository;
    protected AccesstradeRepositoryInterface $accesstradeRepository;
    protected CategoryRepositoryInterface $categoryRepository;
    protected CouponRepositoryInterface $couponRepository;
    protected CrawlShopeeRepositoryInterface $crawlShopeeRepository;

    public function __construct(
        AccesstradeApiRepositoryInterface $accesstradeApiRepository,
        AccesstradeRepositoryInterface    $accesstradeRepository,
        CategoryRepositoryInterface       $categoryRepository,
        CouponRepositoryInterface         $couponRepository,
        CrawlShopeeRepositoryInterface    $crawlShopeeRepository
    ) {
        $this->accesstradeApiRepository = $accesstradeApiRepository;
        $this->accesstradeRepository = $accesstradeRepository;
        $this->categoryRepository = $categoryRepository;
        $this->couponRepository = $couponRepository;
        $this->crawlShopeeRepository = $crawlShopeeRepository;
    }

    public function index(Request $request): Factory|View|Application {
        $listCampaign = $this->accesstradeRepository->getListCampaignSelectBox();
        $merchant = $request->get('merchant');
        $categoryId = $request->get('category_id');
        $type = 'DEFAULT';
        $listCategory = [];
        $listCoupon = [];
        $page = $request->get('page') ?? 1;

        if (!empty($merchant)) {
            $listCategory = $this->categoryRepository->getListByCampaignAccesstradeMerchant($request->get('merchant'));
        }

        if (!empty($categoryId)) {
            $category = $this->categoryRepository->getDetail($categoryId);
            $type = $category->type;

            if ($type === 'ACCESSTRADE') {
                $listCoupon = $this->accesstradeApiRepository->getListPromotion($merchant, $page);
            } else if ($type === 'DEFAULT') {
                $listCoupon = $this->couponRepository->getListByCategoryId($categoryId, $page);
            } else if ($type === 'SHOPEE' && !empty($category->api_url)) {
                $listCoupon = $this->crawlShopeeRepository->getListCoupon($category->api_url);
            }
        }

        return view('web.home.index', compact('listCampaign', 'listCategory', 'listCoupon', 'type', 'page'));
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
