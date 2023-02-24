<?php

namespace App\Repositories\Category;

interface CategoryRepositoryInterface {
    public function getList($name = null, $campaignId = null);

    public function store($data);
    public function getDetail($id);

    public function update($id, $data);

    public function destroy($id);

    public function getListSelect();

    public function getListByCampaignId($campaignId);
}
