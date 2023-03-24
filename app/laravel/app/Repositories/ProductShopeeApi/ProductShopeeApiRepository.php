<?php

namespace App\Repositories\ProductShopeeApi;

class ProductShopeeApiRepository implements ProductShopeeApiRepositoryInterface {
    public function getListProductApi($keyword = '', $page = 1) {
        $appId = env('SHOPEE_APP_ID');
        $apiKey = env('SHOPEE_API_KEY');
        $date = new \DateTime();
        $timestamp = $date->getTimestamp();
        $body = '{"query":"{  productOfferV2 (page: ' . (int)$page . ', limit: 50, keyword: \"' . $keyword . '\") {    nodes {shopName itemId price imageUrl productName offerLink productLink}, pageInfo { page limit hasNextPage }  }}","variables":null,"operationName":null}';
        $signature = hash('sha256', $appId . $timestamp . $body . $apiKey);
        $headers = [
            'authorization' => 'SHA256 Credential=' . $appId . ', Timestamp=' . $timestamp . ', Signature=' . $signature,
            'content-type' => 'application/json',
        ];
        return postApiShopee('https://open-api.affiliate.shopee.vn/graphql', $body, $headers);
    }
}
