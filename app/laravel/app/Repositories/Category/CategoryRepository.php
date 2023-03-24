<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface {
    public function getListSelect($exceptIds = []): \Illuminate\Support\Collection {
        if (!is_array($exceptIds)) {
            $exceptIds = [$exceptIds];
        }

        return Category::with(['ChildCategories'])
            ->where('parent_id', '=', null)
            ->whereNotIn('id', $exceptIds)
            ->get();
    }

    public function getListInAdmin(): \Illuminate\Contracts\Pagination\LengthAwarePaginator {
        $perPage = config('custom.category')['per_page'] ?? 10;

        return Category::with(['ChildCategories'])
            ->where('parent_id', '=', null)
            ->paginate($perPage);
    }

    public function store($data): int {
        $category = new Category();
        $image = $data['image'] ?? null;

        $data = $this->mapDataRequest($category, $data);
        $category->fill($data);
        $category->save();

        if (!empty($image)) {
            $category->setAttribute('image', $this->uploadImageAvatar($image, $category));
            $category->save();
        }

        return $category->getAttribute('id');
    }

    private function uploadImageAvatar($image, $category): string {
        $imagePath = 'images_upload/category_images/' . $category->getAttribute('id');
        return uploadImage($image, 'avatar', $imagePath, true);
    }

    public function update($id, $data): int {
        $category = Category::find($id);
        $image = $data['image'] ?? null;

        $data = $this->mapDataRequest($category, $data);
        $category->fill($data);

        if (!empty($image)) {
            $category->setAttribute('image', $this->uploadImageAvatar($image, $category));
        }

        $category->save();
        return $id;
    }

    public function destroy($id) {
        DB::table('categories')
            ->where('id', '=', $id)
            ->delete();

        return $id;
    }

    public function getDetail($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null {
        return Category::with(['ChildCategories'])
            ->find($id);
    }
}
