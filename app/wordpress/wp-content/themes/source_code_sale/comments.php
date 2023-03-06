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


