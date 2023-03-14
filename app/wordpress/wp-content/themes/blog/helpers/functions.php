<?php
if (!function_exists('getPublicFile')) {
    function getPublicFile($path): string {
        return get_stylesheet_directory_uri() . '/public/' . $path;
    }
}

if (!function_exists('getCurrentUserRole')) {
    function getCurrentUserRole() {
        if (is_user_logged_in()) {

            $user = wp_get_current_user();

            $roles = ( array )$user->roles;

            if (!empty($roles)) {
                return $roles[0];
            }
        }

        return null;
    }
}

if (!function_exists('getMenuItemsParent')) {
    function getMenuItemsParent($menuName): array {
        $locations = get_nav_menu_locations();
        $menu = wp_get_nav_menu_object($locations[$menuName]);

        $listMenuItem = (array)wp_get_nav_menu_items($menu->term_id, array('order' => 'DESC', 'menu_item_parent' => '0'));

        foreach ($listMenuItem as $key => $item) {
            if (!empty($item->menu_item_parent)) {
                unset($listMenuItem[$key]);
            }
        }

        return $listMenuItem;
    }
}

if (!function_exists('getMenuItemsByMenuId')) {
    function getMenuItemsByMenuId($menuName, $parentId): array {
        $locations = get_nav_menu_locations();
        $menu = wp_get_nav_menu_object($locations[$menuName]);

        $listMenuItem = (array)wp_get_nav_menu_items($menu->term_id, array('order' => 'DESC', 'menu_item_parent' => '0'));

        foreach ($listMenuItem as $key => $item) {
            if (empty($item->menu_item_parent) || $item->menu_item_parent != $parentId) {
                unset($listMenuItem[$key]);
            }
        }

        return $listMenuItem;
    }
}

if (!function_exists('getFeaturedImage')) {
    function getFeaturedImage($postItem, $imageUrlDefault = null): array {
        $imageUrl = get_the_post_thumbnail_url($postItem, 'full');
        $imageAlt = get_post_meta(attachment_url_to_postid($imageUrl), '_wp_attachment_image_alt', TRUE);

        if (empty($imageUrl)) {
            $imageUrl = $imageUrlDefault ?? get_stylesheet_directory_uri() . '/public/images/no-image.png';
        }

        return [
            'url' => $imageUrl,
            'alt' => $imageAlt
        ];
    }
}

if (!function_exists('limitText')) {
    function limitText($text, $limit) {
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }
}

if (!function_exists('getPerPageDefault')) {
    function getPerPageDefault(): int {
        return 6;
    }
}

if (!function_exists('getPreviousIcon')) {
    function getPreviousIcon(): string {
        return '<i class="fa fa-arrow-left"></i>';
    }
}

if (!function_exists('getNextIcon')) {
    function getNextIcon(): string {
        return '<i class="fa fa-arrow-right"></i>';
    }
}

if (!function_exists('time_elapsed_string')) {
    function timeElapsedString($datetime, $full = false): string {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;


        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . translate($v . ($diff->$k > 1 ? 's' : ''));
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ' . translate('ago') : translate('just now');
    }
}

if (!function_exists('searchQueryLikeNamePost')) {
    function searchQueryLikeNamePost(): void {
        add_filter('posts_where', 'wp_query_search_query_like_name_post', 10, 2);
        function wp_query_search_query_like_name_post($where, $wp_query) {
            global $wpdb;
            if ($value = $wp_query->get('post_title_like')) {
                $where .= ' AND (' . $wpdb->posts . '.post_title LIKE \'' . $value . '\'';
                $where .= ' OR ' . $wpdb->posts . '.post_content LIKE \'' . $value . '\')';
            }
            return $where;
        }
    }
}

if (!function_exists('getNamePagination')) {
    function getNamePagination(): string {
        return 'page';
    }
}

if (!function_exists('getShortLinkMegaUrlApi')) {
    function getShortLinkMegaUrlApi($url) {
        $megaUrlConfig = get_field('mega_url_config', 'options');
        $apiToken = $megaUrlConfig['token'] ?? null;

        if (empty($apiToken) || empty($url)) {
            return $url;
        }

        $apiUrl = "https://megaurl.io/api?api={$apiToken}&url={$url}";
        $result = @json_decode(file_get_contents($apiUrl), TRUE);

        if (!empty($result["shortenedUrl"])) {
            return $result["shortenedUrl"];
        }

        return $url;
    }
}

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

if (!function_exists('getListCategoryShopee')) {
    function getListCategoryShopee($page = 1): array {
        $appId = get_option('long_dev_custom_plugin_shopee_app_id');
        $apiKey = get_option('long_dev_custom_plugin_shopee_api_key');
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