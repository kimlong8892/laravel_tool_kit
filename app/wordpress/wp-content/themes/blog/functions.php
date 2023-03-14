<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
// functions helper
include 'helpers/functions.php';

add_theme_support('post-thumbnails');
add_post_type_support('post', 'thumbnail');

/*
* =================== START THEME OPTIONS PAGE ===================
*/
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title' => 'Configs',
        'menu_title' => 'Configs',
        'menu_slug' => '',
        'position' => 2,
        'icon_url' => false
    ));
}
/*
* =================== END THEME OPTIONS PAGE ===================
*/


add_action('init', 'init_function');
function init_function(): void {
    //cron_get_category_from_shopee();
}

function setAcfOfProductCategory($termId, $data): void {
    if (!empty($termId)) {
        foreach ($data as $key => $value) {
            update_field($key, $value, 'product_category' . '_' . $termId);
        }
    }
}

function custom_plugin_register_options_page(): void {
    add_options_page('Custom plugin', 'Custom plugin', 'manage_options', 'custom_plugin', 'custom_plugin_options_page');
}

add_action('admin_menu', 'custom_plugin_register_options_page');

function custom_plugin_options_page(): void {
    include 'html_admin/option_html.php';
}

function map_category_shopee_id(): array {
    $listProductCategoryDB = get_terms([
        'taxonomy' => 'product_category',
        'hide_empty' => false,
    ]);
    $listProductCategory = [];

    foreach ($listProductCategoryDB as $value) {
        $value = (array)$value;
        $idFromApi = get_field('id_from_api', 'product_category_' . $value['term_id']);

        if (!empty($idFromApi)) {
            $listProductCategory[$idFromApi] = $value;
        }
    }

    return $listProductCategory;
}

function map_product_shopee_id(): array {
    $listProductDB = new WP_Query([
        'post_type'=> 'product',
        'posts_per_page' => -1
    ]);
    $listProductDB = $listProductDB->get_posts();
    $listProduct = [];

    if (!empty($listProductDB) && count($listProductDB) > 0) {
        foreach ($listProductDB as $value) {
            $value = (array)$value;
            $idFromApi = get_field('id_from_api', $value['ID']);

            if (!empty($idFromApi)) {
                $listProduct[$idFromApi] = $value;
            }
        }
    }

    return $listProduct;
}

function cron_get_category_from_shopee(): void {
    $listCategoryShopee = getListCategoryShopee();
    $listCategoryShopee = $listCategoryShopee['data']['shopeeOfferV2']['nodes'] ?? null;

    if (!empty($listCategoryShopee)) {
        $listProductCategory = map_category_shopee_id();

        foreach ($listCategoryShopee as $node) {
            $termId = null;
            $idFromApi = $node['categoryId'] ?? '';
            $imageFromApi = $node['imageUrl'] ?? '';
            $titleFromApi = $node['offerName'] ?? '';

            if (!empty($listProductCategory[$idFromApi])) {
                $termId = $listProductCategory[$idFromApi]['term_id'];

                if (!empty($termId)) {
                    update_field('id_from_api', $idFromApi, 'product_category' . '_' . $termId);
                }
            } else {
                $productCategory = wp_insert_term($node['offerName'], 'product_category', [
                    'name' => $node['offerName'],
                ]);

                if (!$productCategory instanceof WP_Error && !empty($productCategory['term_id'])) {
                    $termId = $productCategory['term_id'];
                }
            }

            setAcfOfProductCategory($termId, [
                'id_from_api' => $idFromApi,
                'image_from_api' => $imageFromApi,
                'title_from_api' => $titleFromApi,
                'type' => 'shopee'
            ]);
        }
    }
}


function cron_get_product_from_shopee(): void {
    $listProductCategory = map_category_shopee_id();
    $listProduct = map_product_shopee_id();

    foreach ($listProductCategory as $categoryId => $value) {
        $listProductShopee = getListProductShopee($categoryId);

        foreach ($listProductShopee as $product) {
            $productId = null;
            $idFromApi = $product['itemId'] ?? '';

            if (!empty($listProduct[$idFromApi])) {
                $productId = $listProduct[$idFromApi]['ID'] ?? null;
            } else {
                $productId = wp_insert_post([
                    'post_title' => $product['productName'] ?? '',
                    'post_type' => 'product',
                    'post_status' => 'publish'
                ]);
                wp_set_post_terms($productId, $value['term_id'], 'product_category');
            }

            if (!empty($productId)) {
                update_field('id_from_api', $product['itemId'] ?? '', $productId);
                update_field('price_from_api', $product['price'] ?? '', $productId);
                update_field('link_from_api', $product['offerLink'] ?? '', $productId);
                update_field('name_from_api', $product['productName'] ?? '', $productId);
                update_field('image_from_api', $product['imageUrl'] ?? '', $productId);
            }
        }
    }
}