<?php

namespace App\Repositories\Campaign;

use App\Models\Campaign;

class CampaignRepository implements CampaignRepositoryInterface {
    public function getList() {
        return Campaign::paginate(5);
    }

    public function destroy($id) {
        Campaign::find($id)->delete();
    }

    public function getDetail($id) {
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
