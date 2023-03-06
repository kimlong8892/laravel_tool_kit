<?php
    $typeActionAlert = $_GET['type_action'] ?? null;
?>
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,600,700,900&amp;subset=latin-ext"
      rel="stylesheet">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

<!-- Tooltip plugin (zebra) css file -->
<link rel="stylesheet" type="text/css"
      href="<?= getPublicFile('theme/plugins/zebra-tooltip/zebra_tooltips.min.css') ?>">

<!-- Owl Carousel plugin css file. only used pages -->
<link rel="stylesheet" type="text/css"
      href="<?= getPublicFile('lib/owl-carousel/dist/assets/owl.carousel.css') ?>">

<!-- Ideabox main theme css file. you have to add all pages -->
<link rel="stylesheet" type="text/css" href="<?= getPublicFile('theme/css/main-style.css') ?>">

<!-- Ideabox responsive css file -->
<link rel="stylesheet" type="text/css" href="<?= getPublicFile('theme/css/responsive-style.css') ?>">
<link rel="stylesheet" href="<?= getPublicFile('lib/fontawesome/css/all.css') ?>">
<link rel="stylesheet" href="<?= getPublicFile('css/base.css') ?>">

<script src="<?= getPublicFile('theme/js/jquery-3.2.1.min.js') ?>"></script>

<!-- Tooltip plugin (zebra) js file -->
<script src="<?= getPublicFile('theme/plugins/zebra-tooltip/zebra_tooltips.min.js') ?>"></script>

<!-- Owl Carousel plugin js file -->
<script src="<?= getPublicFile('lib/owl-carousel/dist/owl.carousel.min.js') ?>"></script>

<!-- Ideabox theme js file. you have to add all pages. -->
<script src="<?= getPublicFile('theme/js/main-script.js') ?>"></script>
<?= get_field('script_html_head', 'options') ?? ''; ?>



<!-- Register popup html source start -->
<div class="m-modal-box"
    <?php if ($typeActionAlert == 'register'): ?> style="display: block;" <?php endif; ?>
     id="registerModal">
    <div class="m-modal-overlay"></div>
    <div class="m-modal-content small">
        <div class="m-modal-header">
            <h3 class="m-modal-title"><?= translate('Register'); ?></h3>
            <span class="m-modal-close"><i class="material-icons">&#xE5CD;</i></span>
        </div>
        <div class="m-modal-body">
            <?= do_shortcode('[login_form_social_login]'); ?>

            <?php if ($typeActionAlert == 'register' && !empty($_GET['error_mgs'])): ?>
                <div style="color: red; text-align: center;">
                    <?= $_GET['error_mgs']; ?>
                </div>
            <?php endif; ?>

            <form action="<?= get_site_url() . '/register-post' ?>" method="POST">
                <div class="frm-row">
                    <label>
                        <input class="frm-input" type="text" name="email" placeholder="<?= translate('Email'); ?>">
                    </label>
                </div>
                <div class="frm-row">
                    <label>
                        <input class="frm-input" type="password" name="password" placeholder="<?= translate('Password'); ?>">
                    </label>
                </div>
                <div class="frm-row">
                    <label>
                        <input class="frm-input" type="password" name="re_password" placeholder="<?= translate('re_password'); ?>">
                    </label>
                </div>
                <div class="frm-row">
                    <button class="frm-button material-button full" type="submit"><?= translate('Register'); ?></button>
                </div>
            </form>
            <div class="frm-row">
                <p class="txt-center"><?= translate('Do you already have an account'); ?>? <a href="#" data-modal="loginModal"><?= translate('Login'); ?></a></p>
            </div>
        </div>
    </div>
</div>
<!-- Register popup html source end ---->

<!-- Login popup html source start -->
<div class="m-modal-box"
     <?php if ($typeActionAlert == 'login'): ?> style="display: block;" <?php endif; ?>
     id="loginModal">
    <div class="m-modal-overlay"></div>
    <div class="m-modal-content small">
        <div class="m-modal-header">
            <h3 class="m-modal-title"><?= translate('Login'); ?></h3>
            <span class="m-modal-close"><i class="material-icons">&#xE5CD;</i></span>
        </div>
        <div class="m-modal-body">
            <?= do_shortcode('[login_form_social_login]'); ?>

            <?php if ($typeActionAlert == 'login' && !empty($_GET['error_mgs'])): ?>
                <div style="color: red; text-align: center;">
                    <?= $_GET['error_mgs']; ?>
                </div>
            <?php endif; ?>

            <form action="<?= get_site_url() . '/login-post'; ?>" method="POST">
                <div class="frm-row">
                    <label>
                        <input class="frm-input" type="text" name="email" value="<?= $_GET['email'] ?? ''; ?>" placeholder="<?= translate('Email'); ?>">
                    </label>
                </div>
                <div class="frm-row">
                    <label>
                        <input class="frm-input" type="password" name="password" placeholder="<?= translate('Password'); ?>">
                    </label>
                </div>
                <div class="frm-row">
                    <button class="frm-button material-button full" type="submit"><?= translate('Login'); ?></button>
                </div>
            </form>
            <div class="frm-row">
                <p class="txt-center"><?= translate("Don't you have an account yet"); ?>? <a href="#" data-modal="registerModal"><?= translate('Register'); ?></a>
                </p>
            </div>
        </div>
    </div>
</div>
<!-- Login popup html source end -->

<div class="overlay"></div>


<footer class="text-center">
    <h5>&copy;Copyright <?= date('Y') ?> by KimLong</h5>
</footer>