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

?>


<?php
global $post;
$listComment = get_comments([
    'post_id' => $post->ID,
    'parent' => 0,
    'status' => 'approve',
    'order' => 'DESC'
]);
?>

<script src="<?= getPublicFile('lib/sweetalert2/sweetalert2.min.js'); ?>"></script>
<link rel="stylesheet" href="<?= getPublicFile('lib/sweetalert2/sweetalert2.min.css'); ?>">


<script>
    window.onload = function () {
        $('#replay-comment-parent').hide();

        function clearReplayComment() {
            $('#comment_parent').val('');
            $('#replay-comment').html('');
            $('#replay-comment-parent').hide();
        }


        $('body').on('click', '#replay-comment-parent button', function () {
            clearReplayComment();
        });

        $('body').on('click', '.replay-button', function () {
            $('#comment_parent').val($(this).attr('data-id'));
            $('#replay-comment').html('#' + $(this).attr('data-content'));
            $('#replay-comment-parent').show();
        });


        $('body').on('submit', '#comment-form', function (event) {
            event.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: {
                    comment: $('#comment-form #comment').val(),
                    comment_post_ID: $('#comment-form #comment_post_ID').val(),
                    comment_parent: $('#comment-form #comment_parent').val(),
                },
                success: function (data) {
                    let elements = $(data);
                    let list_comment_html = $('#list-comment-html', elements);
                    $('#list-comment-html').html(list_comment_html.html());
                    $('#comment-form #comment').val('');
                    clearReplayComment();

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: '<?= translate('Comment success'); ?>',
                        showConfirmButton: false,
                        timer: 1500
                    });

                }
            });
        });
    };
</script>

<?php if (is_user_logged_in()): ?>
    <form action="<?= get_site_url() . '/wp-comments-post.php'; ?>"
          method="post"
          id="comment-form"
          class="comment-form">

        <p id="replay-comment-parent">
            <span id="replay-comment"></span>
            <button type="button" class="frm-button material-button"><i class="fa fa-close"></i></button>
        </p>

        <textarea name="comment" id="comment" cols="30" rows="10" class="frm-input" placeholder="<?= translate('Comment'); ?>"></textarea>
        <div class="form-submit">
            <input type="hidden" name="comment_post_ID" value="<?= $post->ID; ?>" id="comment_post_ID">
            <input type="hidden" name="comment_parent" id="comment_parent" value="0">
        </div>


        <button type="submit" style="margin-top: 15px;"
                class="frm-button full material-button"><?= translate('Comment'); ?></button>
    </form>

<?php else: ?>
    <h2><?= translate('Please login to comment'); ?> (<a data-modal="loginModal" href="#"><?= translate('Login'); ?></a>)</h2>
<?php endif; ?>

<div class="row">
    <div class="col-md-12">
        <div class="blog-comment">
            <h3 class="text-success"><?= __('Comments'); ?></h3>
            <hr/>
            <div id="list-comment-html">
                <?php if (!empty($listComment) && count($listComment) > 0): ?>
                    <?php get_template_part('template-parts/comment/row', null, ['list_comment' => $listComment]); ?>
                <?php else: ?>
                    <h2><?= translate('No record comment') ?></h2>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>



