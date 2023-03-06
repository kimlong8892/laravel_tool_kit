<?php
global $post;
$image = getFeaturedImage($post);
$listCategoryOfItem = wp_get_post_categories($post->ID, ['fields' => 'all']);

$listPostRelated = get_posts([
    'category__in' => array_column($listCategoryOfItem, 'term_id'),
    'numberposts' => 3,
    'post__not_in' => [$post->ID],
    'orderby' => array(
        'post_date' => 'DESC',
    ),
]);

$linkDownload = get_field('link_download', $post->ID);
$listPostDependency = get_field('list_post_dependency', $post->ID);

if (!empty($linkDownload) && count($linkDownload) > 0) {
    foreach ($linkDownload as $key => &$value) {
        if (!empty($value['is_short_link'])) {
            if (!empty($value['url'])) {
                $linkDownload[$key]['url'] = getShortLinkMegaUrlApi($value['url']);
            }
        }
    }
}

if (!empty($listPostDependency) && count($listPostDependency) > 0) {
    foreach ($listPostDependency as $key => $valuePostDependency) {
        if ($valuePostDependency->ID == $post->ID) {
            unset($listPostDependency[$key]);
            break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <?php include 'head.php'; ?>
    <title><?= get_the_title($post); ?></title>
</head>

<body>

<?php include 'header.php'; ?>

<main class="main-container full-width">

    <!-- Detail extra post start -->
    <div class="extra-posts">
        <div class="extra-post-wrapper">

            <?php if (!empty($listPostRelated) && count($listPostRelated) > 0): ?>
                <?php foreach ($listPostRelated as $postRelated): ?>
                    <?php
                        $imagePostRelated = getFeaturedImage($postRelated);
                    ?>
                    <div class="columns column-2">
                        <article class="extra-post-box">
                            <a href="<?= get_permalink($postRelated); ?>" class="extra-post-link">
                                <div class="post-image">
                                    <span><img src="<?= $imagePostRelated['url'] ?? '' ?>" width="80" height="80" alt="<?= get_the_title($postRelated); ?>"></span>
                                </div>
                                <div class="post-title">
                                    <?= get_the_title($postRelated); ?>
                                    <span class="post-date"><?= timeElapsedString($postRelated->post_date); ?></span>
                                </div>
                            </a>
                        </article>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <!-- Detail extra post start -->

    <section class="sub-highlight">

        <!-- Detail parallax start -->
        <div class="parallax-box">
            <div class="parallax-image"
                 style="background-image: url('<?= $image['url'] ?? ''; ?>'); transform: translate3d(0px, 0px, 0px);"></div>
            <article class="post-box">
                <div class="post-overlay">
                    <div class="post-overlay-inner" style="opacity: 1;">

                        <?php if (!empty($listCategoryOfItem) && count($listCategoryOfItem) > 0): ?>
                            <?php foreach ($listCategoryOfItem as $itemCategory): ?>
                                <a href="<?= get_term_link($itemCategory); ?>" class="post-category" title="<?= $itemCategory->name; ?>"
                                   rel="tag"><?= $itemCategory->name; ?></a>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <h1 class="post-title"><?= get_the_title($post); ?></h1>
                        <div class="post-meta">
                            <div class="post-meta-author-avatar">
                                <img alt="avatar"  src="<?= get_avatar_url(get_the_author_meta('ID', $post->post_author), ['size' => '40']); ?>"
                                     class="avatar" height="24" width="24">
                            </div>
                            <div class="post-meta-author-info">
			    					<span class="post-meta-author-name">
			    						<a href="#"
                                           title="<?php the_author_meta('display_name', $post->post_author); ?>"
                                           rel="author"><?php the_author_meta('display_name', $post->post_author); ?></a>
			    					</span>
                                <span class="middot">·</span>
                                <span class="post-meta-date">
			    						<abbr class="published updated"
                                              title="<?= $post->post_date; ?>"><?= timeElapsedString($post->post_date); ?></abbr>
			    					</span>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <!-- Detail parallax end -->

    </section>
    <section class="main-content">
        <div class="main-content-wrapper">
            <div class="content-body">
                <!-- article body start -->
                <article class="article-wrapper">
                    <div class="article-header">
                        <div class="breadcrumb">
                            <ul>
                                <li><a href="<?= get_site_url(); ?>"><span><?= translate('Home page'); ?></span></a> <i
                                            class="material-icons"></i></li>
                                <li><span><?= get_the_title($post); ?></span></li>
                            </ul>
                        </div>
                    </div>

                    <?php if (!empty($listPostDependency) && count($listPostDependency) > 0): ?>
                        <div style="border: solid 1px; padding: 7px; border-radius: 10px;">
                            <h2><?= translate('List post dependency') ?></h2>
                            <ul style="list-style: -moz-ethiopic-numeric;">
                                <?php foreach ($listPostDependency as $postDependency): ?>
                                    <li>
                                        <a target="_blank" href="<?= get_permalink($postDependency); ?>"><?= get_the_title($postDependency); ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <div class="article-content"> <!-- adbox120 or adbox160 -->
                        <div>
                            <?= apply_filters('the_content', get_the_content()); ?>
                        </div>
                    </div>

                    <?php if (!empty($linkDownload) && count($linkDownload) > 0): ?>
                        <div style="border: solid 1px; padding: 7px; border-radius: 10px;">
                            <h2><?= translate('List link download') ?></h2>
                            <ul style="list-style: -moz-ethiopic-numeric;">
                                <?php foreach ($linkDownload as $linkDownloadItem): ?>
                                    <li>
                                        <a target="_blank" href="<?= $linkDownloadItem['url'] ?? '#' ?>"><?= $linkDownloadItem['title'] ?? $linkDownloadItem['url'] ?? '' ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </article>
                <!-- article body end -->

                <?php comments_template(); ?>
            </div>
        </div>
    </section>

</main>


<?php include 'footer.php'; ?>

<script type="text/javascript">

    //Owl carousel initializing
    $('#postCarousel').owlCarousel({
        loop: true,
        dots: true,
        nav: true,
        navText: ['<span><i class="material-icons">&#xE314;</i></span>', '<span><i class="material-icons">&#xE315;</i></span>'],
        items: 1,
        margin: 20
    })

    //widget carousel initialize
    $('#widgetCarousel').owlCarousel({
        dots: true,
        nav: false,
        items: 1
    })

</script>

</body>

</html>