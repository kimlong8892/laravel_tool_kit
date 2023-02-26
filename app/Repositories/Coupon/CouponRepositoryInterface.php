<?php

namespace App\Repositories\Coupon;

interface CouponRepositoryInterface {
    public function getList($name, $categoryId);
    public function store($data);

    public function getDetail($id);

    public function update($id, $data);

    public function destroy($id);

    public function getListByCategoryId($categoryId, $page = 1);
}
