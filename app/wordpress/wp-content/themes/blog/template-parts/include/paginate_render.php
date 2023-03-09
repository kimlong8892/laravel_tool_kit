<?php
$total = $args['total'] ?? null;
$itemPerPage = $args['itemPerPage'] ?? null;
$paginate = $args['paginate'] ?? null;
?>

<?php if ($total > $itemPerPage && !empty($paginate)): ?>
    <div>
        <ul class="pagination justify-content-center">
            <?php foreach ($paginate as $list): ?>
                <li class="page-item <?= (str_contains($list, 'current') ? ' active' : ''); ?>"><?= str_replace('page-numbers', 'page-link text-dark', $list); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>