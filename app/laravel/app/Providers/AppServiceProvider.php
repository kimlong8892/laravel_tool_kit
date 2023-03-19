<?php

namespace App\Providers;

use App\Repositories\ProductShopeeApi\ProductShopeeApiRepository;
use App\Repositories\ProductShopeeApi\ProductShopeeApiRepositoryInterface;
use App\Repositories\SocialAccount\SocialAccountRepository;
use App\Repositories\SocialAccount\SocialAccountRepositoryInterface;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void {
        $this->app->bind(
            SocialAccountRepositoryInterface::class,
            SocialAccountRepository::class
        );
        $this->app->bind(
            ProductShopeeApiRepositoryInterface::class,
            ProductShopeeApiRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void {
        if (strpos(env('APP_URL'), 'https')) {
            URL::forceScheme('https');
        }

        Paginator::useBootstrap();
    }
}
