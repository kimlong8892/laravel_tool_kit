<?php


namespace App\Repositories\SocialAccount;
use Laravel\Socialite\Contracts\User as ProviderUser;

interface SocialAccountRepositoryInterface
{
    public function createOrGetUser(ProviderUser $providerUser, $social);
}
