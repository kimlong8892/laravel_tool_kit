<?php

namespace App\Repositories\AccesstradeApi;

interface AccesstradeApiRepositoryInterface {
    public function getListPromotion($merchant, $page = 1);
    public function insertCampaigns();
}
