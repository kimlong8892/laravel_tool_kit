<?php
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    // functions helper
    include 'helpers/functions.php';

    add_theme_support('post-thumbnails');
    add_post_type_support( 'post', 'thumbnail' );

    /*
    * =================== START THEME OPTIONS PAGE ===================
    */
    if(function_exists('acf_add_options_page')) {
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

