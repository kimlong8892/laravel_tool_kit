<?php

namespace App\Repositories\Product;

interface ProductRepositoryInterface {
    public function getDetailWeb($id);

    public function searchProductTiki($search);
}
