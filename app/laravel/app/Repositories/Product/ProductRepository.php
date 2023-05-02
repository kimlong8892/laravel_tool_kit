<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\ProductShopeeApi\ProductShopeeApiRepositoryInterface;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\DB;

class ProductRepository implements ProductRepositoryInterface {
    protected ProductShopeeApiRepositoryInterface $productShopeeApiRepository;

    public function __construct(ProductShopeeApiRepositoryInterface $productShopeeApiRepository) {
        $this->productShopeeApiRepository = $productShopeeApiRepository;
    }

    public function getDetailWeb($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null {
        return Product::with(['ProductsHistoryPrice'])->find($id);
    }

    private function addEcSiteToArray(&$listProduct, $ecSite) {
        foreach ($listProduct as $key => $item) {
            $listProduct[$key]['ec_site'] = $ecSite;
        }
    }

    public function searchListProduct($search): \Illuminate\Contracts\Pagination\LengthAwarePaginator {
        return Product::with(['EcSite'])
            ->where('productName', 'like', '%' . $search . '%')
            ->orderBy('price', 'ASC')
            ->paginate(12);
    }

    /**
     * @throws GuzzleException
     */
    public function insertListProductWithSearch($search) {
        DB::beginTransaction();
        $existsSearch = DB::table('history_search')
            ->where('search', '=', $search)
            ->exists();

        if (!$existsSearch) {
            DB::table('history_search')->insert([
                'search' => $search,
                'created_at' => Carbon::now()
            ]);

            $listProductInsert = [];
            $listProductTiki = getApi(env('URL_NODEJS') . '/' . 'tiki/list-product', [
                'search' => $search
            ]);
            $listProductLazada = getApi(env('URL_NODEJS') . '/' . 'lazada/list-product', [
                'search' => $search
            ]);
            $listProductShopee = $this->productShopeeApiRepository->getListProductApi($search, 1, 50);
            $listProductCrawl = [];

            if (!empty($listProductTiki['success']) && !empty($listProductTiki['data']['listProduct'])) {
                $this->addEcSiteToArray($listProductTiki['data']['listProduct'], 2);
                $listProductCrawl = $listProductTiki['data']['listProduct'];
            }

            if (!empty($listProductLazada['success']) && !empty($listProductLazada['data']['listProduct'])) {
                $this->addEcSiteToArray($listProductLazada['data']['listProduct'], 3);
                $listProductCrawl = array_merge($listProductCrawl, $listProductLazada['data']['listProduct']);
            }

            foreach ($listProductCrawl as $item) {
                $listProductInsert[] = [
                    'itemId' => $item['itemId'] ?? '',
                    'price' => $item['price'] ?? 0,
                    'imageUrl' => $item['image'] ?? '',
                    'productName' => $item['name'] ?? '',
                    'offerLink' => 'test',
                    'productLink' => $item['link'] ?? '',
                    'shopName' => '',
                    'ec_site' => $item['ec_site'] ?? null,
                    'created_at' => Carbon::now()
                ];
            }

            if (!empty($listProductShopee['data']['productOfferV2']['nodes'])) {
                $this->addEcSiteToArray($listProductShopee['data']['productOfferV2']['nodes'], 1);

                foreach ($listProductShopee['data']['productOfferV2']['nodes'] as $item) {
                    $item['created_at'] = Carbon::now();
                    $listProductInsert[] = $item;
                }
            }

            if (!empty($listProductInsert)) {
                foreach ($listProductInsert as $item) {
                    DB::table('products')->insert($item);
                }
            }

            DB::commit();
        }
    }
}
