<?php

namespace App\Repositories\ProductShopeeApi;

interface ProductShopeeApiRepositoryInterface {
    public function getListProductApi($keyword = '', $page = 1);
}
