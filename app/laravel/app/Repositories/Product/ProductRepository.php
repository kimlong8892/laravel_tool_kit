<?php

namespace App\Repositories\Product;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface {
    public function getDetailWeb($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null {
        return Product::with(['ProductsHistoryPrice'])->find($id);
    }

    public function searchProductTiki($search) {
        $data = getApi(env('URL_NODEJS') . '/' . 'tiki/list-product', [
            'search' => $search
        ]);

        $a = 1;
    }
}
