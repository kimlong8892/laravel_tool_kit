<?php
global $post;
$image = getFeaturedImage($post);
$tags = get_tags(array(
    'hide_empty' => false
));
$groupContents = get_field('group_content', $post->ID);
$listPostDependency = get_field('list_post_dependency', $post->ID);
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
            <div class="col-12">
                <div class="mainheading">

                    <!-- Begin Top Meta -->
                    <div class="row post-top-meta">
                        <div class="col-md-2">
                            <a href="#"><img class="author-thumb"
                                             src="<?= get_avatar_url(get_the_author_meta('ID', $post->post_author), ['size' => '40']); ?>"
                                             alt="Sal"></a>
                        </div>
                        <div class="col-md-10">
                            <a class="link-dark"
                               href="#"><?php the_author_meta('display_name', $post->post_author); ?>
                            </a>
                            <p class="post-date"><?= $post->post_date; ?><br><?= timeElapsedString($post->post_date); ?>
                            </p>
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
                    <?php if (!empty($groupContents)): ?>
                        <?php foreach ($groupContents as $groupContent): ?>
                        <?php if (!empty($groupContent['acf_fc_layout'])): ?>
                            <?php if ($groupContent['acf_fc_layout'] == 'image_content_vertical'): ?>
                                <?php if (!empty($groupContent['list_image'])): ?>
                                    <?php foreach ($groupContent['list_image'] as $image): ?>
                                        <div class="mb-3">
                                            <img src="<?= $image['image']['url']; ?>" width="100%">
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <div>
                                    <?= $groupContent['content'] ?? ''; ?>
                                </div>
                            <?php elseif ($groupContent['acf_fc_layout'] == 'image_content_horizontal'): ?>
                                <div class="row align-items-center">
                                    <div class="col-6">
                                        <?php if (!empty($groupContent['list_image'])): ?>
                                            <?php foreach ($groupContent['list_image'] as $image): ?>
                                                <div class="mb-3">
                                                    <img src="<?= $image['image']['url']; ?>" width="100%">
                                                </div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-6">
                                        <?= $groupContent['content'] ?? ''; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php endif; ?>
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

    <?php if (!empty($listPostDependency)): ?>
        <div class="graybg">
            <div class="container">
                <div class="row mb-3">
                    <h4 class="col-12">Bài viết liên quan</h4>
                </div>
                <div class="row listrecent listrelated">
                    <?php foreach ($listPostDependency as $item): ?>
                        <?php
                            $image = getFeaturedImage($item);
                            $listCategoryOfItem = wp_get_post_categories($item->ID, ['fields' => 'all']);
                        ?>
                        <!-- begin post -->
                        <div class="col">
                            <div class="card">
                                <a href="<?= get_permalink($item); ?>">
                                    <img class="img-fluid img-thumb" src="<?= $image['url'] ?? ''; ?>" alt="">
                                </a>
                                <div class="card-block">
                                    <h2 class="card-title"><a href="<?= get_permalink($item); ?>"><?= get_the_title($item); ?></a>
                                    </h2>
                                    <div class="metafooter">
                                        <div class="wrapfooter">
                                        <span class="meta-footer-thumb">
                                        <a href="#"><img class="author-thumb"
                                                                   src="<?= get_avatar_url(get_the_author_meta('ID', $item->post_author), ['size' => '40']); ?>"
                                                                   alt="Sal"></a>
                                        </span>
                                            <span class="author-meta">
                                        <span class="post-name"><a href="#"><?php the_author_meta('display_name', $item->post_author); ?></a></span><br>
                                        <span class="post-date"><?= $item->post_date; ?></span><span class="dot"></span><span
                                                        class="post-read"><?= timeElapsedString($item->post_date); ?></span>
                                        </span>
                                            <span class="post-read-more"><a href="<?= get_permalink($item); ?>" title="Read Story"><svg
                                                            class="svgIcon-use" width="25" height="25" viewBox="0 0 25 25"><path
                                                                d="M19 6c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v14.66h.012c.01.103.045.204.12.285a.5.5 0 0 0 .706.03L12.5 16.85l5.662 4.126a.508.508 0 0 0 .708-.03.5.5 0 0 0 .118-.285H19V6zm-6.838 9.97L7 19.636V6c0-.55.45-1 1-1h9c.55 0 1 .45 1 1v13.637l-5.162-3.668a.49.49 0 0 0-.676 0z"
                                                                fill-rule="evenodd"></path></svg></a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end post -->
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php include 'footer.php'; ?>
</div>