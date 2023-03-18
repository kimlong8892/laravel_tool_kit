<?php

namespace App\Providers;

use App\Repositories\Accesstrade\AccesstradeRepository;
use App\Repositories\Accesstrade\AccesstradeRepositoryInterface;
use App\Repositories\AccesstradeApi\AccesstradeApiRepository;
use App\Repositories\AccesstradeApi\AccesstradeApiRepositoryInterface;
use App\Repositories\Campaign\CampaignRepository;
use App\Repositories\Campaign\CampaignRepositoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Coupon\CouponRepository;
use App\Repositories\Coupon\CouponRepositoryInterface;
use App\Repositories\CrawlShopee\CrawlShopeeRepository;
use App\Repositories\CrawlShopee\CrawlShopeeRepositoryInterface;
use App\Repositories\DownloadVideoYoutube\DownloadVideoYoutubeRepository;
use App\Repositories\DownloadVideoYoutube\DownloadVideoYoutubeRepositoryInterface;
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
