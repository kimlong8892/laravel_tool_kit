<?php

namespace App\Repositories\Category;

interface CategoryRepositoryInterface {
    public function getListSelect($exceptIds = []);
    public function getListInAdmin();
    public function store($data);
    public function update($id, $data);
    public function destroy($id);

    public function getDetail($id);
}
