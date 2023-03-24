<?php

namespace App\Repositories\Tag;

use App\Models\Tag;

class TagRepository implements TagRepositoryInterface {
    public function getListSelect(): \Illuminate\Database\Eloquent\Collection {
        return Tag::all();
    }
}
