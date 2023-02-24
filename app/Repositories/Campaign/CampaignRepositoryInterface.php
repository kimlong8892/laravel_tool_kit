<?php

namespace App\Repositories\Campaign;

interface CampaignRepositoryInterface {
    public function getList();
    public function destroy($id);
    public function getDetail($id);
    public function store($data);
    public function update($id, $data);
    public function getListSelect();
}
