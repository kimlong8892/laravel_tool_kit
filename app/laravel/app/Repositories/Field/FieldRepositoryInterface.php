<?php

namespace App\Repositories\Field;

interface FieldRepositoryInterface {
    public function getListInAdmin();

    public function store($data);

    public function update($id, $data);

    public function getDetail($id);
}
