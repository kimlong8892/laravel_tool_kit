<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\SocialAccount\SocialAccountRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller {
    protected SocialAccountRepositoryInterface $socialAccountRepository;

    public function __construct(SocialAccountRepositoryInterface $socialAccountRepository) {
        $this->socialAccountRepository = $socialAccountRepository;
    }

    public function redirect($social): \Symfony\Component\HttpFoundation\RedirectResponse|\Illuminate\Http\RedirectResponse {
        return \Laravel\Socialite\Facades\Socialite::driver($social)->redirect();
    }

    public function callback($social): \Illuminate\Routing\Redirector|\Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse {
        $user = $this->socialAccountRepository->createOrGetUser(Socialite::driver($social)->user(), $social);
        Auth::guard('web')->login($user, true);

        return redirect('/');
    }
}
