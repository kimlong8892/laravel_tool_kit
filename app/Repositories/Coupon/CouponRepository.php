<?php

namespace App\Repositories\Coupon;

use App\Models\Coupon;
use Illuminate\Support\Facades\File;

class CouponRepository implements CouponRepositoryInterface {
    public function getList($name, $categoryId) {
        return Coupon::where(function ($query) use ($name, $categoryId) {
            if (!empty($name)) {
                $query->where('name', 'like' , '%' . $name . '%');
            }

            if (!empty($categoryId)) {
                $query->where('category_id', '=', $categoryId);
            }
        })->paginate(5);
    }

    public function store($data): int {
        $coupon = new Coupon();
        $coupon->fill($data);
        $coupon->save();

        if (!empty($data['logo'])) {
            $imagePath = 'images_upload/coupons_image/' . $coupon->getAttribute('id');
            $imageUrl = uploadImage($data['logo'], 'logo', $imagePath);
            $coupon->setAttribute('logo', $imageUrl);
            $coupon->save();
        }

        return $coupon->getAttribute('id');
    }

    public function getDetail($id): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|array|null {
        return Coupon::with(['Category'])->find($id);
    }

    public function update($id, $data): int {
        $coupon = Coupon::find($id);
        $coupon->fill($data);

        if (!empty($data['logo'])) {
            $imagePath = 'images_upload/coupons_image/' . $coupon->getAttribute('id');
            $imageUrl = uploadImage($data['logo'], 'logo', $imagePath);
            $coupon->setAttribute('logo', $imageUrl);
        }

        $coupon->save();

        return $coupon->getAttribute('id');
    }

    public function destroy($id) {
        File::delete(public_path('images_upload/coupons_image/' . $id));
        Coupon::find($id)->delete();
    }

    public function getListByCategoryId($categoryId, $page = 1) {
        return Coupon::where('category_id', '=', $categoryId)
            ->limit(10)
            ->get();
    }
}
