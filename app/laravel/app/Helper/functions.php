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


if (!function_exists('postApiShopee')) {
    /**
     * @throws GuzzleException
     * @throws Exception
     */
    function postApiShopee($url, $body = '', $headers = []) {
        try {
            $client = new Client();
            $client = $client->post($url, [
                'headers' => $headers,
                'body' => $body
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

if (!function_exists('getDayOfDateToDate')) {
    function getDayOfDateToDate($date): int {
        $diff = strtotime($date) - strtotime(now());

        return round($diff / 86400);
    }
}

if (!function_exists('checkUrlIsHttps')) {
    function checkUrlIsHttps($url): bool {
        $url = parse_url($url);

        if (!empty($url['scheme']) && $url['scheme'] == 'https') {
            return true;
        }

        return false;
    }
}

if (!function_exists('uploadImage')) {
    function uploadImage($imageFile, $imageName, $imagePath, $isReturnFileName = false): string {
        if (!empty($imageFile) && $imageFile instanceof \Illuminate\Http\UploadedFile) {
            $file = $imageFile;
            $ext = $file->extension();
            $fileName =  $imageName . '.' . $ext;
            $file->move(public_path($imagePath), $fileName);

            if ($isReturnFileName) {
                return $fileName;
            }

            return $imagePath . '/' . $fileName;
        }

        return '';
    }
}

if (!function_exists('getListCategoryShopee')) {
    function getListCategoryShopee($page = 1): array {
        $appId = '17342940062';
        $apiKey = '6ERDUYBANO7VTIBSFNQOAHDTLRU3MRV6';
        $date = new \DateTime();
        $timestamp = $date->getTimestamp();
        $body = '{"query":"{  shopeeOfferV2 (page: ' . (int)$page . ', limit: 50) {    nodes {offerName categoryId imageUrl}, pageInfo { page limit hasNextPage }  }}","variables":null,"operationName":null}';
        $signature = hash('sha256', $appId . $timestamp . $body . $apiKey);
        $headers = [
            'authorization' => 'SHA256 Credential=' . $appId . ', Timestamp=' . $timestamp . ', Signature=' . $signature,
            'content-type' => 'application/json',
        ];
        return postApiShopee('https://open-api.affiliate.shopee.vn/graphql', $body, $headers);
    }
}

if (!function_exists('getConversionReportShopee')) {
    function getConversionReportShopee() {
        $appId = env('SHOPEE_APP_ID');
        $apiKey = env('SHOPEE_API_KEY');
        $date = new \DateTime();
        $timestamp = $date->getTimestamp();
        $body = '{"query":"{  conversionReport(limit: 500) {    nodes {conversionStatus purchaseTime totalBrandCommission totalCommission orders{items{itemName itemPrice itemCommission itemTotalCommission qty imageUrl }}}, pageInfo { page limit hasNextPage }  }}","variables":null,"operationName":null}';
        $signature = hash('sha256', $appId . $timestamp . $body . $apiKey);
        $headers = [
            'authorization' => 'SHA256 Credential=' . $appId . ', Timestamp=' . $timestamp . ', Signature=' . $signature,
            'content-type' => 'application/json',
        ];
        return postApiShopee('https://open-api.affiliate.shopee.vn/graphql', $body, $headers);
    }
}

if (!function_exists('formatVnd')) {
    function formatVnd($value, $isShowExt = true): string {
        if ($isShowExt) {
            return number_format($value, 0, '', ',') . ' (VND)';
        }

        return number_format($value, 0, '', ',');
    }
}

if (!function_exists('getCurrentAdminId')) {
    function getCurrentAdminId() {
        return \Illuminate\Support\Facades\Auth::guard('admin')
            ->user()
            ->getAttribute('id');
    }
}

if (!function_exists('makeSlug')) {
    function makeSlug($text): string {
        return preg_replace('/[^A-Za-z0-9-]+/', '-', $text);
    }
}

if (!function_exists('renderNameCustomField')) {
    function renderNameCustomField($field): string {
        $fieldId = $field->id;

        return "custom_field[$fieldId]";
    }
}

if (!function_exists('getImageCustomField')) {
    function getImageCustomField($imagePath, $fieldId): string {
        if (empty($imagePath)) {
            return '';
        }

        if (is_file(public_path('images_upload/custom_field_images/' . $fieldId . '/' . $imagePath))) {
            return asset('images_upload/custom_field_images/' . $fieldId . '/' . $imagePath);
        }

        return '';
    }
}

if (!function_exists('getImageInProductPost')) {
    function getImageInProductPost($imageUrl, $postId): String {
        if (empty($imageUrl)) {
            return '';
        }

        if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            return $imageUrl;
        }

        return asset('images_upload/post_images/' . $postId . '/products/' . $imageUrl);
    }
}
