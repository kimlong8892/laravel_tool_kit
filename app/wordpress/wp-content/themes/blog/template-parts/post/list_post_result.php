<?php
    $listPost = $args['listPost'] ?? null;
?>
<?php if (!empty($listPost) && count($listPost) > 0): ?>
    <section class="recent-posts">
        <div class="section-title">
            <h2><span>Tất cả bài viết</span></h2>
        </div>
        <div class="card-columns listrecent">
            <?php foreach ($listPost as $item): ?>
                <?php
                    $image = getFeaturedImage($item);
                    $listCategoryOfItem = wp_get_post_categories($item->ID, ['fields' => 'all']);
                ?>
                <!-- begin post -->
                <div class="card">
                    <a href="<?= get_permalink($item); ?>">
                        <img class="img-fluid" src="<?= $image['url'] ?? ''; ?>" alt="">
                    </a>
                    <div class="card-block">
                        <h2 class="card-title"><a href="<?= get_permalink($item); ?>"><?= get_the_title($item); ?></a>
                        </h2>
                        <h4 class="card-text"><?php the_content('Xem thêm...'); ?></h4>
                        <div class="metafooter">
                            <div class="wrapfooter">
						<span class="meta-footer-thumb">
						<a href="#"><img class="author-thumb"
                                                   src="<?= get_avatar_url(get_the_author_meta('ID', $item->post_author), ['size' => '40']); ?>"
                                                   alt="Sal"></a>
						</span>
                                <span class="author-meta">
						<span class="post-name"><a href="#">Sal</a></span><br/>
						<span class="post-date"><?= $item->post_date; ?></span><span class="dot"></span><span class="post-read"><?= timeElapsedString($item->post_date); ?></span>
						</span>
                                <span class="post-read-more"><a href="<?= get_permalink($item); ?>" title="Read Story"><svg
                                                class="svgIcon-use"
                                                width="25"
                                                height="25"
                                                viewbox="0 0 25 25"><path
                                                    d="M19 6c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v14.66h.012c.01.103.045.204.12.285a.5.5 0 0 0 .706.03L12.5 16.85l5.662 4.126a.508.508 0 0 0 .708-.03.5.5 0 0 0 .118-.285H19V6zm-6.838 9.97L7 19.636V6c0-.55.45-1 1-1h9c.55 0 1 .45 1 1v13.637l-5.162-3.668a.49.49 0 0 0-.676 0z"
                                                    fill-rule="evenodd"></path></svg></a></span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end post -->
            <?php endforeach; ?>
        </div>
    </section>
<?php endif; ?>
