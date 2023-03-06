<?php
    $listComment = $args['list_comment'] ?? null;
?>

<?php if (!empty($listComment) && count($listComment) > 0): ?>
    <div class="all-comments">
        <?php foreach ($listComment as $item): ?>
            <div class="comment-item">
                <div class="comment-avatar">
                    <span class="comment-img"><img src="<?= get_avatar_url($item->comment_author_email, ['size' => '50']); ?>" width="50" height="50"></span>
                </div>
                <div class="comment-content">
                    <div class="comment-header">
                        <span class="author-name"><?= $item->comment_author; ?></span> -
                        <span class="comment-date"><?= timeElapsedString($item->comment_date); ?></span>
                    </div>
                    <div class="comment-wrapper"><?= $item->comment_content; ?></div>
                    <div class="comment-meta">
                        <span class="replay-button" data-id="<?= $item->comment_ID; ?>" data-content="<?= $item->comment_content; ?>"><?= translate('Replay'); ?></span>
                    </div>

                    <?php
                    $listComment = get_comments([
                        'parent' => $item->comment_ID,
                        'status' => 'approve',
                        'order' => 'ASC'
                    ]);
                    ?>

                    <?php if (!empty($listComment) && count($listComment) > 0): ?>
                        <?php get_template_part('template-parts/comment/row', null, ['list_comment' => $listComment]); ?>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>