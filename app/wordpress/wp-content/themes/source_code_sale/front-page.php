<?php
    $configTypePage = getNamePagination();
    $itemPerPage = get_field('per_page', 'options')['category'] ?? getPerPageDefault();
    $page = isset($_GET[$configTypePage]) ? abs((int)$_GET[$configTypePage]) : 1;
    $offset = ($page * $itemPerPage) - $itemPerPage;
    $search = $_GET['search'] ?? '';

    if (!empty($search)) {
        $search = '%' . $search . '%';
    }

    searchQueryLikeNamePost();

    $query = new WP_Query(array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'orderby' => array(
            'post_date' => 'DESC',
        ),
        'posts_per_page' => $itemPerPage,
        'offset' => $offset,
        'post_title_like' => $search
    ));

    $paginate = null;
    $listPost = $query->get_posts();
    $total = $query->found_posts;

    if ($total > $itemPerPage) {
        $paginate = paginate_links(array(
            'base' => add_query_arg($configTypePage, '%#%'),
            'format' => '',
            'total' => ceil($total / $itemPerPage),
            'current' => $page,
            'type' => 'array',
            'prev_text'    => getPreviousIcon(),
            'next_text'    => getNextIcon(),
            'add_fragment' => '',
        ));
    }
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <?php include 'head.php'; ?>
    <title>Trang chủ</title>
</head>

<body>

<?php get_header(); ?>

<!--Main container start -->
<main class="main-container">
    <?php get_template_part('template-parts/post/list_post_pin', 'list_post_pin'); ?>
    <section class="main-content">
        <div class="main-content-wrapper">
            <div class="content-body">
                <div class="content-timeline">
                    <?php get_template_part('template-parts/post/list_post_result', 'list_post_result', [
                            'listPost' => $listPost
                    ]); ?>


                    <?php get_template_part('template-parts/include/paginate_render', null, [
                        'total' => $total,
                        'itemPerPage' => $itemPerPage,
                        'paginate' => $paginate
                    ]); ?>
                </div>

            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>

</body>

</html>