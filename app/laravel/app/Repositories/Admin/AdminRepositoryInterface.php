<?php

namespace App\Repositories\Admin;

interface AdminRepositoryInterface {
    public function updateProfile($adminId, $name, $password);
}
