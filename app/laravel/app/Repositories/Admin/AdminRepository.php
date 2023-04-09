<?php

namespace App\Repositories\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminRepository implements AdminRepositoryInterface {
    public function updateProfile($adminId, $name, $password) {
        $admin = Admin::find($adminId);

        if (!empty($name)) {
            $admin->setAttribute('name', $name);
        }

        if (!empty($password)) {
            $admin->setAttribute('password', Hash::make($password));
        }

        $admin->save();

        return $adminId;
    }
}
