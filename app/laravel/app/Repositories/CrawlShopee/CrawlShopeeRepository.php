<?php

namespace App\Repositories\CrawlShopee;

use GuzzleHttp\Exception\GuzzleException;

class CrawlShopeeRepository implements CrawlShopeeRepositoryInterface {
    /**
     * @throws GuzzleException
     */
    public function getListCoupon($url) {
        $urlNodejs = env('NODEJS_URL') . '/crawl-shopee';

        return getApi($urlNodejs, [
            'url' => $url
        ]);
    }
}
