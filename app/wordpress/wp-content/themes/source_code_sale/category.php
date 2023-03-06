<?php
    $configTypePage = getNamePagination();
    $currentCategory = get_queried_object();
    $categoryId = $currentCategory->term_id;
    $itemPerPage = get_field('per_page', 'options')['category'] ?? getPerPageDefault();
    $page = isset($_GET[$configTypePage]) ? abs((int)$_GET[$configTypePage]) : 1;
    $offset = ($page * $itemPerPage) - $itemPerPage;

    $query = new WP_Query(array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'orderby' => array(
            'post_date' => 'DESC',
        ),
        'posts_per_page' => $itemPerPage,
        'offset' => $offset,
        'tax_query' => array(
            array(
                'taxonomy' => 'category',
                'field'    => 'id',
                'terms'    => $categoryId,
            ),
        ),
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
<!doctype html>
<html lang="vi">
<head>
    <?php include 'head.php'; ?>
    <title><?= $currentCategory->name; ?></title>
</head>
<body>
    <?php get_header(); ?>

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