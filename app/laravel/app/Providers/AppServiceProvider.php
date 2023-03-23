<?php

namespace App\Providers;

use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Post\PostRepository;
use App\Repositories\Post\PostRepositoryInterface;
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
        $this->app->bind(
            PostRepositoryInterface::class,
            PostRepository::class
        );
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void {
        if (env('APP_ENV') != 'local') {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }

        Paginator::useBootstrap();
    }
}
