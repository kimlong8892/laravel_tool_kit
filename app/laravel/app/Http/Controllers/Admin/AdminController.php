<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Repositories\Admin\AdminRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use SebastianBergmann\Diff\Exception;

class AdminController extends Controller {
    protected AdminRepositoryInterface $adminRepository;

    public function __construct(AdminRepositoryInterface $adminRepository) {
        $this->adminRepository = $adminRepository;
    }

    public function editProfile(Request $request): View {
        $admin = Auth::guard('admin')->user();

        return view('admin.admin.edit_profile', compact('admin'));
    }

    public function updateProfile(UpdateProfileRequest $request): \Illuminate\Http\RedirectResponse {
        try {
            $admin = Auth::guard('admin')->user();
            $this->adminRepository->updateProfile($admin->getAttribute('id'), $request->get('name'), $request->get('password'));

            return redirect()->back()->with('success', __('Update profile success'));
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}
