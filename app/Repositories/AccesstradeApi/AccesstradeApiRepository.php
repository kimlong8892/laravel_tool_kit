<?php

namespace App\Repositories\AccesstradeApi;

use GuzzleHttp\Exception\GuzzleException;

class AccesstradeApiRepository implements AccesstradeApiRepositoryInterface {
    /**
     * @throws GuzzleException
     */
    public function getListPromotion() {
        $accessKey = env('ACCESSTRADE_KEY', '');

        if (empty($accessKey)) {
            return [];
        }

        return getApi('https://api.accesstrade.vn/v1/offers_informations', '', [
            'Authorization' => 'Token ' . $accessKey,
            'Content-Type' => 'application/json'
        ]);
    }
}
