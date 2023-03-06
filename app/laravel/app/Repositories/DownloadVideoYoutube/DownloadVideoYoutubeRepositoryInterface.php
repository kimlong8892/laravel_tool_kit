<?php

namespace App\Repositories\DownloadVideoYoutube;

interface DownloadVideoYoutubeRepositoryInterface {
    public function renderListUrlVideo($videoUrl): array;
}
