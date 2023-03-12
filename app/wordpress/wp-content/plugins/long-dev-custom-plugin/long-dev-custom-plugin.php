<?php
/**
 * Plugin Name: Long dev custom plugin
 * Description: Long dev custom plugin
 * Version: 1.0
 * Author: Nguyen Kim Long
 **/

if (!function_exists('baseDir')) {
    function baseDir (): string {
        $path = dirname(__FILE__);
        while (true) {
            if (file_exists($path."/wp-config.php")) {
                return $path."/";
            }
            $path = dirname($path);
        }
    }
}

$path = baseDir() . '/vendor/autoload.php';
require_once $path;

if (!function_exists('postApiShopee')) {
    function postApiShopee($url, $body = '', $headers = []) {
        try {
            $client = new \GuzzleHttp\Client();
            $client = $client->post($url, [
                'headers' => $headers,
                'body' => $body,
            ]);

            return json_decode($client->getBody()->getContents(), true);
        } catch (Exception $exception) {
            print_r($exception);
        }
    }
}

if (!function_exists('getListProductShopee')) {
    function getListProductShopee($keyword = '', $page = 1, $fields = 'productName itemId price'): array {

        $appId = get_option('long_dev_custom_plugin_shopee_app_id');
        $apiKey = get_option('long_dev_custom_plugin_shopee_api_key');
        $date = new \DateTime();
        $timestamp = $date->getTimestamp();
        $body = '{"query":"{  productOfferV2 (keyword: \"' . $keyword . '\", page: ' . (int) $page .  ', limit: 50) {    nodes {      ' . $fields . '          }, pageInfo { page limit hasNextPage }  }}","variables":null,"operationName":null}';
        $signature = hash('sha256', $appId . $timestamp . $body . $apiKey);
        $headers = [
            'authorization' => 'SHA256 Credential=' . $appId . ', Timestamp=' . $timestamp . ', Signature=' . $signature,
            'content-type' => 'application/json',
        ];
        return postApiShopee('https://open-api.affiliate.shopee.vn/graphql', $body, $headers);
    }
}

function custom_plugin_register_settings(): void {
    register_setting('long_dev_custom_plugin', 'long_dev_custom_plugin_shopee_app_id');
    register_setting('long_dev_custom_plugin', 'long_dev_custom_plugin_shopee_api_key');
}
add_action('admin_init', 'custom_plugin_register_settings');

function custom_plugin_register_options_page(): void {
    add_options_page('Custom plugin', 'Custom plugin', 'manage_options', 'custom_plugin', 'custom_plugin_options_page');
}
add_action('admin_menu', 'custom_plugin_register_options_page');

function custom_plugin_options_page(): void {
    include 'option_html.php';
}
