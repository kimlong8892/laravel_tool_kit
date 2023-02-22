<?php

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

if (!function_exists('getApi')) {
    /**
     * @throws GuzzleException
     * @throws Exception
     */
    function getApi($url, $params = [], $headers = []) {
        try {
            $client = new Client();
            $client = $client->request('GET', $url, [
                'headers' => $headers,
                'query' => $params
            ]);

            return json_decode($client->getBody()->getContents(), true);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }
    }
}

if (!function_exists('postApi')) {
    /**
     * @throws GuzzleException
     * @throws Exception
     */
    function postApi($url, $params = [], $headers = []) {
        try {
            $client = new Client();
            $client = $client->post($url, [
                'headers' => $headers,
                'form_params' => $params
            ]);

            return json_decode($client->getBody()->getContents(), true);
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
            throw $exception;
        }
    }
}

if (!function_exists('renderUrlApiWp')) {
    function renderUrlApiWp($path): string {
        return env('WP_SERVER_URL') . '/' . $path;
    }
}

if (!function_exists('getUrlFullWithReplaceRequest')) {
    function getUrlFullWithReplaceRequest($arrayRequest): array {
        $requestCurrent = request()->toArray();

        if (!empty($arrayRequest) && is_array($arrayRequest)) {
            foreach ($arrayRequest as $key => $value) {
                $requestCurrent[$key] = $value;
            }
        }

        return $requestCurrent;
    }
}

if (!function_exists('isMobile')) {
    function isMobile() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }
}

if (!function_exists('limitWord')) {
    function limitWord($s, $limit): string {
        return Str::words(strip_tags($s), $limit, '...');
    }
}

if (!function_exists('upLoadImage')) {
    function upLoadImage($imageFile, $imageName, $imagePath): string {
        $file = $imageFile;
        $ext = $file->extension();
        $fileName =  $imageName . '.' . $ext;
        $file->move(public_path($imagePath), $fileName);

        return $imagePath . '/' . $fileName;
    }
}

if (!function_exists('getDayOfDateToDate')) {
    function getDayOfDateToDate($date): int {
        $now = time();
        $your_date = strtotime($date);

        return date('d', round($now - $your_date / (60 * 60 * 24)));
    }
}
