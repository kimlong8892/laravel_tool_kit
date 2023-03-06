<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CategoryRepository implements CategoryRepositoryInterface {
    public function getList($name = null, $campaignId = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator {
        return Category::with(['Campaign'])
            ->where(function ($query) use ($name, $campaignId) {
                if (!empty($name)) {
                    $query->where('name', 'like' , '%' . $name . '%');
                }

                if (!empty($campaignId)) {
                    $query->where('campaign_id', '=', $campaignId);
                }
            })->paginate(5);
    }

    public function store($data) {
        if (!empty($data['is_accesstrade'])) {
            DB::table('categories')
                ->where('campaign_id', $data['campaign_id'])
                ->update([
                    'is_accesstrade' => false
                ]);
        }

        $category = new Category();
        $category->setAttribute('name', $data['name'] ?? '');
        $category->setAttribute('campaign_id', $data['campaign_id'] ?? '');
        $category->setAttribute('enabled', $data['enabled'] ?? false);
        $category->setAttribute('type', $data['type'] ?? false);
        $category->setAttribute('api_url', $data['api_url'] ?? '');
        $category->save();

        if (!empty($data['logo'])) {
            $imagePath = 'images_upload/categories_image/' . $category->getAttribute('id');
            $imageUrl = uploadImage($data['logo'], 'logo', $imagePath);
            $category->setAttribute('logo', $imageUrl);
            $category->save();
        }

        return $category->getAttribute('id');
    }

    public function getDetail($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null {
        return Category::with(['Campaign'])->find($id);
    }

    public function update($id, $data) {
        if (!empty($data['is_accesstrade'])) {
            DB::table('categories')
                ->where('campaign_id', $data['campaign_id'])
                ->update([
                    'is_accesstrade' => false
                ]);
        }

        $category = Category::find($id);
        $category->setAttribute('campaign_id', $data['campaign_id'] ?? '');
        $category->setAttribute('name', $data['name'] ?? '');
        $category->setAttribute('enabled', $data['enabled'] ?? false);
        $category->setAttribute('type', $data['type'] ?? false);
        $category->setAttribute('api_url', $data['api_url'] ?? '');

        if (!empty($data['logo'])) {
            $imagePath = 'images_upload/categories_image/' . $category->getAttribute('id');
            $imageUrl = uploadImage($data['logo'], 'logo', $imagePath);
            $category->setAttribute('logo', $imageUrl);
        }

        $category->save();

        return $category->getAttribute('id');
    }

    public function destroy($id) {
        File::delete(public_path('images_upload/categories_image/' . $id));
        Category::find($id)->delete();
    }

    public function getListSelect(): \Illuminate\Support\Collection {
        return Category::with(['Campaign'])->where('enabled', true)->get();
    }

    public function getListByCampaignId($campaignId) {
        return Category::where('campaign_id', '=', $campaignId)
            ->where('enabled', true)
            ->get();
    }

    public function getListByCampaignAccesstradeMerchant($accesstradeMerchant) {
        return Category::whereHas('Campaign', function ($query) use ($accesstradeMerchant) {
            $query->where('accesstrade_merchant', $accesstradeMerchant);
        })->get();
    }
}
