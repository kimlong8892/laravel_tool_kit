<?php

namespace App\Repositories\Campaign;

use App\Models\Campaign;

class CampaignRepository implements CampaignRepositoryInterface {
    public function getList(): \Illuminate\Database\Eloquent\Collection {
        return Campaign::all();
    }

    public function destroy($id) {
        Campaign::find($id)->delete();
    }

    public function getDetail($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null {
        return Campaign::find($id);
    }

    public function store($data) {
        $campaign = new Campaign($data);
        $campaign->save();

        return $campaign->getAttribute('id');
    }

    public function update($id, $data) {
        $campaign = Campaign::find($id);
        $campaign->fill($data);
        $campaign->save();

        return $id;
    }
}
