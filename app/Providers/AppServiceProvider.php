<?php

namespace App\Providers;

use App\Repositories\Accesstrade\AccesstradeRepository;
use App\Repositories\Accesstrade\AccesstradeRepositoryInterface;
use App\Repositories\AccesstradeApi\AccesstradeApiRepository;
use App\Repositories\AccesstradeApi\AccesstradeApiRepositoryInterface;
use App\Repositories\DownloadVideoYoutube\DownloadVideoYoutubeRepository;
use App\Repositories\DownloadVideoYoutube\DownloadVideoYoutubeRepositoryInterface;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void {
        //
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
    }
}
