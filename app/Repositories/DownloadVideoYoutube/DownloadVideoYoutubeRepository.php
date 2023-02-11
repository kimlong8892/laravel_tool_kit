<?php

namespace App\Repositories\DownloadVideoYoutube;

use YouTube\Exception\TooManyRequestsException;
use YouTube\Exception\YouTubeException;
use YouTube\YouTubeDownloader;

class DownloadVideoYoutubeRepository implements DownloadVideoYoutubeRepositoryInterface {
    /**
     * @throws YouTubeException
     * @throws TooManyRequestsException
     */
        public function renderListUrlVideo($videoUrl): array {
        $youtube = new YouTubeDownloader();
        $downloadOptions = $youtube->getDownloadLinks($videoUrl);

        if ($downloadOptions->getAllFormats()) {
            return $downloadOptions->getAllFormats();
        }

        return [];
    }
}
