<?php

namespace App\Repositories\Accesstrade;

use Illuminate\Support\Facades\DB;

class AccesstradeRepository implements AccesstradeRepositoryInterface {
    public function getListCampaignSelectBox(): array {
        return DB::table('accesstrade_campaigns')
            ->where('name_custom', '<>', null)
            ->where('enabled', '=', true)
            ->get()
            ->toArray();
    }
}
