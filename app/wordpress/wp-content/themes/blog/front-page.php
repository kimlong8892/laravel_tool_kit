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
        'prev_text' => getPreviousIcon(),
        'next_text' => getNextIcon(),
        'add_fragment' => '',
    ));
}
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

    <?php if (empty($search)): ?>
        <?php get_template_part('template-parts/post/list_post_pin', 'list_post_pin'); ?>
    <?php endif; ?>

    <?php get_template_part('template-parts/post/list_post_result', 'list_post_result', [
        'listPost' => $listPost
    ]); ?>

    <?php get_template_part('template-parts/include/paginate_render', null, [
        'total' => $total,
        'itemPerPage' => $itemPerPage,
        'paginate' => $paginate
    ]); ?>

    <?php include 'footer.php'; ?>
</div>


</body>
</html>