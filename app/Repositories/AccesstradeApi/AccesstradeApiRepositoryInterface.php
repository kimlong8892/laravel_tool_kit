<?php

namespace App\Repositories\AccesstradeApi;

interface AccesstradeApiRepositoryInterface {
    public function getListPromotion($merchant);
    public function insertCampaigns();
}
