<?php
global $post;
$image = getFeaturedImage($post);
$tags = get_tags(array(
    'hide_empty' => false
));
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Trang chủ</title>
    <?php include 'head.php'; ?>
</head>
<body>
<?php include 'header.php'; ?>


<div class="container">
    <div class="mainheading">
        <h1 class="sitetitle"><?= get_bloginfo('name'); ?></h1>
        <p class="lead">
            <?= get_bloginfo('description'); ?>
        </p>
    </div>

    <div class="container">
        <div class="row">
            <!-- Begin Post -->
            <div class="col-md-8 col-md-offset-2 col-xs-12">
                <div class="mainheading">

                    <!-- Begin Top Meta -->
                    <div class="row post-top-meta">
                        <div class="col-md-2">
                            <a href="#"><img class="author-thumb"
                                             src="https://www.gravatar.com/avatar/e56154546cf4be74e393c62d1ae9f9d4?s=250&amp;d=mm&amp;r=x"
                                             alt="Sal"></a>
                        </div>
                        <div class="col-md-10">
                            <a class="link-dark"
                               href="#"><?php the_author_meta('display_name', $post->post_author); ?>
                            </a>
                            <p class="post-date"><?= $post->post_date; ?><br><?= timeElapsedString($post->post_date); ?></p>
                        </div>
                    </div>
                    <!-- End Top Menta -->

                    <h1 class="posttitle"><?= get_the_title($post); ?></h1>

                </div>

                <!-- Begin Featured Image -->
                <img class="featured-image img-fluid" src="<?= $image['url'] ?? ''; ?>" alt="">
                <!-- End Featured Image -->

                <!-- Begin Post Content -->
                <div class="article-post">
                    <?= apply_filters('the_content', get_the_content()); ?>
                </div>
                <!-- End Post Content -->

                <?php if (!empty($tags) && count($tags) > 0): ?>
                    <!-- Begin Tags -->
                    <div class="after-post-tags">
                        <ul class="tags">
                            <?php foreach ($tags as $tag): ?>
                                <li><a href="<?= get_tag_link($tag->term_id); ?>"><?= $tag->name ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <!-- End Tags -->
                <?php endif; ?>

            </div>
            <!-- End Post -->

        </div>
    </div>

    <?php include 'footer.php'; ?>
</div>