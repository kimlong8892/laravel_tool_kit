<?php

namespace App\Repositories\ProductShopeeApi;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProductShopeeApiRepository implements ProductShopeeApiRepositoryInterface {
    public function getListProductApi($keyword = '', $page = 1, $limit = 10) {
        $appId = env('SHOPEE_APP_ID');
        $apiKey = env('SHOPEE_API_KEY');
        $date = new \DateTime();
        $timestamp = $date->getTimestamp();
        $body = '{"query":"{  productOfferV2 (page: ' . (int)$page . ', limit: ' . $limit . ', keyword: \"' . $keyword . '\")';
        $body .= '{nodes {shopName itemId price imageUrl productName offerLink productLink}, pageInfo { page limit hasNextPage }}}';
        $body .= '","variables":null,"operationName":null}';
        $signature = hash('sha256', $appId . $timestamp . $body . $apiKey);
        $headers = [
            'authorization' => 'SHA256 Credential=' . $appId . ', Timestamp=' . $timestamp . ', Signature=' . $signature,
            'content-type' => 'application/json',
        ];
        return postApiShopee('https://open-api.affiliate.shopee.vn/graphql', $body, $headers);
    }

    public function updateProductPriceHistory() {
        $listProduct = DB::table('products')->get();
        $arrayInsertProductHistory = [];

        DB::beginTransaction();
        foreach ($listProduct as $product) {
            $productName = $product->productName;

            $productInShopee = $this->getListProductApi($productName, 1, 1);
            $productInShopee = $productInShopee['data']['productOfferV2']['nodes'][0] ?? null;

            if (!empty($productInShopee) && !empty($productInShopee['price'])) {
                if ($productInShopee['price'] != $product->price) {
                    $arrayInsertProductHistory[] = [
                        'product_id' => $product->id,
                        'price' => $productInShopee['price'],
                        'created_at' => Carbon::now()
                    ];

                    DB::table('products')->where('id', '=', $product->id)
                        ->update([
                            'price' => $productInShopee['price']
                        ]);
                }
            }
        }

        if (!empty($arrayInsertProductHistory)) {
            DB::table('product_history')
                ->insert($arrayInsertProductHistory);
        }

        DB::commit();
    }
}
