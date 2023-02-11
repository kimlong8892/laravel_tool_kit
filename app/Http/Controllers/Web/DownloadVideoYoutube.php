<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\DownloadVideoPageRequest;
use App\Repositories\DownloadVideoYoutube\DownloadVideoYoutubeRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DownloadVideoYoutube extends Controller {
    protected DownloadVideoYoutubeRepositoryInterface $downloadVideoYoutubeRepository;

    public function __construct(DownloadVideoYoutubeRepositoryInterface $downloadVideoYoutubeRepository) {
        $this->downloadVideoYoutubeRepository = $downloadVideoYoutubeRepository;
    }

    public function downloadVideoPage(Request $request): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View {
        $videoId = $request->get('video_url') ?? null;

        if (!empty($videoId)) {
            try {
                $listVideo = $this->downloadVideoYoutubeRepository->renderListUrlVideo($request->get('video_url'));

                return view('web.download_video_youtube.index', compact('listVideo'));
            } catch (\Exception $exception) {
                Log::error($exception->getMessage());
            }
        }

        return view('web.download_video_youtube.index');
    }
}
