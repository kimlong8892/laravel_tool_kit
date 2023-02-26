<?php

namespace App\Repositories\Campaign;

use App\Models\Campaign;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;


class CampaignRepository implements CampaignRepositoryInterface {
    public function getList(): Collection {
        return Campaign::all();
    }

    public function destroy($id) {
        Campaign::find($id)->delete();
    }

    public function getDetail($id): Model|Collection|Builder|array|null {
        return Campaign::find($id);
    }

    public function store($data): int {
        $campaign = new Campaign($data);
        $campaign->save();

        return $campaign->getAttribute('id');
    }

    public function update($id, $data): int {
        $campaign = Campaign::find($id);

        if (empty($data['enabled'])) {
            $data['enabled'] = false;
        }

        $campaign->fill($data);
        $campaign->save();

        return $id;
    }

    public function getListSelect(): \Illuminate\Support\Collection {
        return DB::table('campaigns')
            ->where('enabled', '=', true)
            ->where('name', '<>', '')
            ->get();
    }
}
