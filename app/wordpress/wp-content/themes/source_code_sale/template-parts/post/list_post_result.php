<?php
    $listPost = $args['listPost'] ?? null;
?>

<?php if (!empty($listPost) && count($listPost) > 0): ?>
    <div class="timeline-items">
        <?php foreach ($listPost as $item): ?>
            <?php
                $image = getFeaturedImage($item);
                $listCategoryOfItem = wp_get_post_categories($item->ID, ['fields' => 'all']);
            ?>

            <div class="timeline-item">
                <div class="timeline-left">
                    <div class="timeline-left-wrapper">
                        <a href="#" class="timeline-category" data-zebra-tooltip title="<?= $item->post_date; ?>"><i
                                class="material-icons">&#xE894;</i></a>
                        <span class="timeline-date"><?= timeElapsedString($item->post_date); ?></span>
                    </div>
                </div>
                <div class="timeline-right">
                    <div class="timeline-post-image">
                        <a href="<?= get_permalink($item); ?>">
                            <img src="<?= $image['url'] ?? ''; ?>" width="260" alt="<?= get_the_title($item); ?>">
                        </a>
                    </div>
                    <div class="timeline-post-content">
                        <?php if (!empty($listCategoryOfItem) && count($listCategoryOfItem) > 0): ?>
                            <?php foreach ($listCategoryOfItem as $itemCategory): ?>
                                <a href="<?= get_term_link($itemCategory); ?>" class="timeline-category-name"><?= $itemCategory->name; ?></a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <a href="<?= get_permalink($item); ?>">
                            <h3 class="timeline-post-title"><?= get_the_title($item); ?></h3>
                        </a>
                        <div class="timeline-post-info">
                            <a href="#" class="author"><?php the_author_meta('display_name', $item->post_author); ?></a>
                            <span class="dot"></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>