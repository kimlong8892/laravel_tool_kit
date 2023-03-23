<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryRepository implements CategoryRepositoryInterface {
    public function getListSelect(): \Illuminate\Support\Collection {
        return Category::with(['ChildCategories'])
            ->where('parent_id', '=', null)
            ->get();
    }
}
