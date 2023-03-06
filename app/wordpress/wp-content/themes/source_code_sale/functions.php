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

    add_action('init', function () {
        $currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $currentUrl = explode('?', $currentUrl);
        $currentUrl = $currentUrl[0] ?? null;

        if (get_site_url() . '/login-post' === $currentUrl) {
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
            $isWrongEmailOrPassword = null;

            if (!empty($email) && !empty($password)) {
                $user = get_user_by('email', $email);

                if (!empty($user)) {
                    $successPassword = wp_check_password($password, $user->data->user_pass, $user->ID);

                    if (!$successPassword) {
                        $isWrongEmailOrPassword = false;
                    } else {
                        wp_signon([
                            'user_login'    => $email,
                            'user_password' => $password,
                            'remember'      => $_POST['remember'] ?? false
                        ]);
                        wp_redirect(get_site_url());
                    }
                } else {
                    $isWrongEmailOrPassword = true;
                }
            } else {
                wp_redirect(get_site_url() . '?type_action=login&error_mgs=' . translate('Email or password empty') . '&email=' . $email);
            }

            if ($isWrongEmailOrPassword === true) {
                wp_redirect(get_site_url() . '?type_action=login&error_mgs=' . translate('Email or password wrong') . '&email=' . $email);
            }

            exit();
        }

        if (get_site_url() . '/register-post' === $currentUrl) {
            $email = $_POST['email'] ?? null;
            $password = $_POST['password'] ?? null;
            $rePassword = $_POST['re_password'] ?? null;

            if (!empty($email) && !empty($password) && !empty($rePassword)) {
                if ($password != $rePassword) {
                    wp_redirect(get_site_url() . '?type_action=register&error_mgs=' . __('Password not equal re password') . '&email=' . $email);
                    exit();
                }

                $userByEmail = get_user_by('email', $email);

                if (!empty($userByEmail)) {
                    wp_redirect(get_site_url() . '?type_action=register&error_mgs=' . __('Email exists in system') . '&email=' . $email);
                } else {
                    wp_insert_user([
                        'user_login' => $email,
                        'user_email' => $email,
                        'nickname' => $email,
                        'user_pass' => $password,
                        'role' => 'user'
                    ]);
                    wp_signon([
                        'user_login'    => $email,
                        'user_password' => $password,
                    ]);
                    wp_redirect(get_site_url());
                }
            } else {
                wp_redirect(get_site_url() . '?type_action=register&error_mgs=' . __('Info empty') . '&email=' . $email);
            }

            exit();
        }

        if (get_site_url() . '/logout' === $currentUrl) {
            if (is_user_logged_in()) {
                wp_logout();
                wp_redirect(get_site_url());
                exit();
            }
        }
    });

