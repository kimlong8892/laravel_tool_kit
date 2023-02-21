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

            $responseArray = json_decode($client->getBody()->getContents(), true);
            $responseArray['headers'] = $client->getHeaders();

            return $responseArray;
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

function validateCaptcha($response): bool {
    $secret = env('RECAPTCHA_SECRET_KEY');
    $captcha = trim($response);
    $ip = $_SERVER['REMOTE_ADDR'];
    $url = "https://www.google.com/recaptcha/api/siteverify?secret={$secret}&response={$captcha}&remoteip={$ip}";

    $options = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
        ),
    );
    $context = stream_context_create($options);
    $res = json_decode(file_get_contents($url, FILE_TEXT, $context));

    if ($res->success) {
        return true;
    }

    return false;
}
