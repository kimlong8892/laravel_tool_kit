<?php

namespace App\Providers;

use App\Repositories\Admin\AdminRepository;
use App\Repositories\Admin\AdminRepositoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Post\PostRepository;
use App\Repositories\Post\PostRepositoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\ProductShopeeApi\ProductShopeeApiRepository;
use App\Repositories\ProductShopeeApi\ProductShopeeApiRepositoryInterface;
use App\Repositories\SocialAccount\SocialAccountRepository;
use App\Repositories\SocialAccount\SocialAccountRepositoryInterface;
use App\Repositories\Tag\TagRepository;
use App\Repositories\Tag\TagRepositoryInterface;
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
        $this->app->bind(
            TagRepositoryInterface::class,
            TagRepository::class
        );
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );
        $this->app->bind(
            AdminRepositoryInterface::class,
            AdminRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void {
        if (checkUrlIsHttps(env('APP_URL'))) {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }

        Paginator::useBootstrap();
    }
}
