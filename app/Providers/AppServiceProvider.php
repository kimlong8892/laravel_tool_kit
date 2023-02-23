<?php

namespace App\Providers;

use App\Repositories\Accesstrade\AccesstradeRepository;
use App\Repositories\Accesstrade\AccesstradeRepositoryInterface;
use App\Repositories\AccesstradeApi\AccesstradeApiRepository;
use App\Repositories\AccesstradeApi\AccesstradeApiRepositoryInterface;
use App\Repositories\Campaign\CampaignRepository;
use App\Repositories\Campaign\CampaignRepositoryInterface;
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
            DownloadVideoYoutubeRepositoryInterface::class,
            DownloadVideoYoutubeRepository::class
        );

        $this->app->bind(
            AccesstradeApiRepositoryInterface::class,
            AccesstradeApiRepository::class
        );

        $this->app->bind(
            AccesstradeRepositoryInterface::class,
            AccesstradeRepository::class
        );

        $this->app->bind(
            SocialAccountRepositoryInterface::class,
            SocialAccountRepository::class
        );

        $this->app->bind(
            CampaignRepositoryInterface::class,
            CampaignRepository::class
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
