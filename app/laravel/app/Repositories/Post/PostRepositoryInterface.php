<?php

namespace App\Repositories\Post;

interface PostRepositoryInterface {
    public function getListInAdmin();

    public function store($data);

    public function update($id, $data);

    public function getDetail($id);

    public function destroy($id);
}
