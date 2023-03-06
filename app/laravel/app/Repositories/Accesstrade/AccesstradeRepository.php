<?php

namespace App\Repositories\Accesstrade;

use Illuminate\Support\Facades\DB;

class AccesstradeRepository implements AccesstradeRepositoryInterface {
    public function getListCampaignSelectBox(): array {
        return DB::table('campaigns')
            ->where('name', '<>', null)
            ->where('enabled', '=', true)
            ->get()
            ->toArray();
    }
}
