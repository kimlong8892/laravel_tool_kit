<?php if (is_user_logged_in()): ?>
    <li>
        <a href="#" class="material-button submenu-toggle"><i class="material-icons">&#xE7FD;</i> <span
                class="hide-on-tablet"><?= wp_get_current_user()->display_name; ?></span></a>
        <div class="header-submenu">
            <ul>
                <li><a href="<?= get_site_url() . '/logout'; ?>"><?= translate('logout'); ?></a></li>
            </ul>
        </div>
    </li>
<?php else: ?>
    <li>
        <a href="#" class="material-button submenu-toggle"><i class="material-icons">&#xE7FD;</i> <span
                class="hide-on-tablet"><?= translate('Login') ?></span></a>
        <div class="header-submenu">
            <ul>
                <li><a href="#" data-modal="loginModal"><?= translate('Login'); ?></a></li>
                <li><a href="#" data-modal="registerModal"><?= translate('Register'); ?></a></li>
            </ul>
        </div>
    </li>
<?php endif; ?>


<?php
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
