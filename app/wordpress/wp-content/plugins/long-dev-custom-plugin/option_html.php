<div>
    <form action="<?= 'options.php'; ?>" style="padding: 10px;" method="POST">
        <?php settings_fields('long_dev_custom_plugin'); ?>
        <div class="form-group">
            <label for="long_dev_custom_plugin_shopee_app_id">AppId</label>
            <input type="text" class="form-control" name="long_dev_custom_plugin_shopee_app_id"
                   value="<?= get_option('long_dev_custom_plugin_shopee_app_id'); ?>">
        </div>

        <div class="form-group">
            <label for="long_dev_custom_plugin_shopee_api_key">Apikey</label>
            <input type="text" class="form-control" name="long_dev_custom_plugin_shopee_api_key"
                   value="<?= get_option('long_dev_custom_plugin_shopee_api_key'); ?>">
        </div>

        <?php submit_button('Save'); ?>
    </form>

    <form action="" method="GET">
        <input type="text" name="name" value="<?= $_GET['name'] ?? ''; ?>">
        <input type="hidden" name="page" value="custom_plugin">
        <?php submit_button('Search product shoppe'); ?>
    </form>

    <?php
        $listProductShopee = getListProductShopee($_GET['name'] ?? '', $_GET['cpage'] ?? 1);
    ?>
    <div>
        <?php if (!empty($listProductShopee['data']['productOfferV2']['pageInfo'])): ?>
            <?php
            $currentPage = $listProductShopee['data']['productOfferV2']['pageInfo']['page'] ?? null;
            ?>

            <p>Current page: <?= $currentPage ?? ''; ?></p>

            <?php if (!empty($currentPage) && $currentPage > 1): ?>
                <p>
                    <a href="<?= home_url($_SERVER['REQUEST_URI']) . '&cpage=' . $currentPage - 1; ?>">Previous</a>
                </p>
            <?php endif; ?>

            <?php if (!empty($listProductShopee['data']['productOfferV2']['pageInfo']['hasNextPage']) && !empty($currentPage)): ?>
                <p>
                    <a href="<?= home_url($_SERVER['REQUEST_URI']) . '&cpage=' . $currentPage + 1; ?>">Next</a>
                </p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <table width="100%" border="1px" cellspacing="0px">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
        </tr>
        <?php foreach ($listProductShopee['data']['productOfferV2']['nodes'] as $item): ?>
            <tr>
                <td><?= $item['itemId'] ?? ''; ?></td>
                <td><?= $item['productName'] ?? ''; ?></td>
                <td><?= $item['price'] ?? ''; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</div>

<style>
    div.form-group {
        margin-top: 10px;
    }

    table tr td, table tr th {
        padding: 5px;
    }
</style>