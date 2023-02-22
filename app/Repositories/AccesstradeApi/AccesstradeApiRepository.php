<?php

namespace App\Repositories\AccesstradeApi;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\DB;

class AccesstradeApiRepository implements AccesstradeApiRepositoryInterface {
    /**
     * @throws GuzzleException
     */
    public function getListPromotion($merchant, $page = 1): array {
        $accessKey = env('ACCESSTRADE_KEY', '');
        $urlApi = config('custom.accesstrade_api')['URL_GET_LIST_PROMOTION'] ?? null;

        if (empty($accessKey) || empty($urlApi)) {
            return [];
        }

        return getApi($urlApi, [
            'merchant' => $merchant,
            'status' => 1,
            'page' => $page
        ], [
            'Authorization' => 'Token ' . $accessKey,
            'Content-Type' => 'application/json'
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function insertCampaigns(): bool {
        $accessKey = env('ACCESSTRADE_KEY', '');
        $urlApi = config('custom.accesstrade_api')['URL_GET_LIST_CAMPAIGN'] ?? null;

        if (empty($accessKey) || empty($urlApi)) {
            return false;
        }

        $listCampaign = getApi($urlApi, [
            'approval' => 'successful'
        ], [
            'Authorization' => 'Token ' . $accessKey,
            'Content-Type' => 'application/json'
        ]);

        if (!empty($listCampaign['data'])) {
            $isUpdate = false;
            $dataInsert = [];
            $listCampaignInDB = DB::table('accesstrade_campaigns')
                ->get()->pluck('accesstrade_id')->toArray();

            DB::beginTransaction();
            foreach ($listCampaign['data'] as $item) {
                $item = [
                    'cookie_duration' => $item['cookie_duration'] ?? null,
                    'logo' => $item['logo'] ?? null,
                    'max_com' => $item['max_com'] ?? null,
                    'merchant' => $item['merchant'] ?? null,
                    'name' => $item['name'] ?? null,
                    'scope' => $item['scope'] ?? null,
                    'accesstrade_id' => $item['id'] ?? null
                ];

                if (in_array($item['accesstrade_id'], $listCampaignInDB) === false) {
                    $dataInsert[] = $item;
                } else {
                    DB::table('accesstrade_campaigns')
                        ->where('accesstrade_id', $item['accesstrade_id'])
                        ->update($item);
                    $isUpdate = true;
                }
            }
            DB::commit();

            if (!empty($dataInsert)) {
                DB::table('accesstrade_campaigns')->insertOrIgnore($dataInsert);
                return true;
            }

            return $isUpdate;
        }

        return false;
    }
}
