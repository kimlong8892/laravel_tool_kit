<?php
    $listPostPin = get_field('list_post_pin_home', 'options');
?>

<?php if (!empty($listPostPin)): ?>
    <section class="main-highlight">
        <div class="highlight-carousel slider-carousel">
            <div class="owl-carousel" id="postCarousel">
                <?php foreach ($listPostPin as $item): ?>
                    <?php
                    $image = getFeaturedImage($item);
                    $listCategoryOfItem = wp_get_post_categories($item->ID, ['fields' => 'all']);
                    ?>

                    <div class="item">
                        <article class="post-box"
                                 style="background-image: url('<?php echo $image['url'] ?? ''; ?>');">
                            <div class="post-overlay">
                                <?php if (!empty($listCategoryOfItem) && count($listCategoryOfItem) > 0): ?>
                                    <?php foreach ($listCategoryOfItem as $itemCategory): ?>
                                        <a href="<?= get_term_link($itemCategory); ?>" class="post-category" title="<?= $itemCategory->name; ?>"
                                           rel="tag"><?= $itemCategory->name; ?></a>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                                <h3 class="post-title"><?= get_the_title($item); ?></h3>
                                <div class="post-meta">
                                    <div class="post-meta-author-avatar">
                                        <img alt="avatar"
                                             src="<?= get_avatar_url(get_the_author_meta('ID', $item->post_author), ['size' => '40']); ?>"
                                             class="avatar" height="24" width="24">
                                    </div>
                                    <div class="post-meta-author-info">
                                                <span class="post-meta-author-name">
                                                    <a href="#" title="Posts by John Doe" rel="author">
                                                        <?php the_author_meta('display_name', $item->post_author); ?>
                                                    </a>
                                                </span>
                                        <span class="middot">·</span>
                                        <span class="post-meta-date">
                                                    <abbr class="published updated" title="<?= $item->post_date; ?>"><?= timeElapsedString($item->post_date); ?></abbr>
                                                </span>
                                    </div>
                                </div>
                            </div>
                            <a href="<?= get_permalink($item); ?>" class="post-overlayLink"></a>
                        </article>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<script type="text/javascript">
    window.onload = function () {
        $('#postCarousel').owlCarousel({
            loop: true,
            dots: true,
            nav: true,
            navText: ['<span><i class="material-icons">&#xE314;</i></span>', '<span><i class="material-icons">&#xE315;</i></span>'],
            items: 1,
            margin: 10,
            responsive : {
                // breakpoint from 0 up
                0 : {
                    stagePadding: 0,
                    loop: false,
                    responsiveClass: true,
                    dots: false,
                    nav: true,
                    autoHeight: true,
                    items: 1
                },
                // breakpoint from 768 up
                768 : {
                    items: 3
                }
            }
        });
    };
</script>
