<?php

namespace App\Repositories\Category;

use Illuminate\Support\Facades\DB;

class CategoryRepository implements CategoryRepositoryInterface {
    public function getListSelect(): \Illuminate\Support\Collection {
        return DB::table('categories')->get();
    }
}
