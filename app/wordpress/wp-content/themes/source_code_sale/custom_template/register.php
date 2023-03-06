<!doctype html>
<html lang="vi">
<head>
    <?php include get_template_directory() . '/head.php'; ?>
</head>
<body>
<?php get_header(); ?>

<div class="container mt-3">
    <?php get_template_part('template-parts/include/breadcrumb_render', null, [
        'list_breadcrumb' => [
            [
                'is_current' => true,
                'title' => __('Register')
            ]
        ]
    ]); ?>

    <div class="row">
        <div class="col-md-6">
            <?php if (!empty($_GET['error'])): ?>
                <h3 class="aler alert-danger p-2 border-radius-10px"><?= $_GET['error']; ?></h3>
            <?php endif; ?>

            <form action="<?= get_site_url() . '/register-post' ?>" method="POST">
                <div class="form-group mb-2">
                    <label for="email">
                        <?= __('Email') ?>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                    </label>
                    <input type="text" class="form-control" name="email" value="<?= $_GET['email'] ?? ''; ?>">
                </div>

                <div class="form-group mb-2">
                    <label for="password">
                        <?= __('Password') ?>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                    </label>
                    <input type="password" class="form-control" name="password">
                </div>

                <div class="form-group mb-2">
                    <label for="re_password">
                        <?= __('Re password') ?>
                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                    </label>
                    <input type="password" class="form-control" name="re_password">
                </div>

                <button class="btn btn-primary">
                    <i class="fa fa-plus-circle"></i>
                    <?= __('Register') ?>
                </button>
            </form>
        </div>
    </div>
</div>

<?php get_footer(); ?>
</body>
</html>