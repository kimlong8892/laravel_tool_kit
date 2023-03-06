<!-- header start -->
<header class="header">
    <div class="header-wrapper">

        <!--sidebar menu toggler start -->
        <div class="toggle-sidebar material-button">
            <i class="material-icons">&#xE5D2;</i>
        </div>
        <!--sidebar menu toggler end -->

        <!--logo start -->
        <div class="logo-box">
            <h1>
                <a href="index.html" class="logo"></a>
            </h1>
        </div>
        <!--logo end -->

        <div class="header-menu">

            <!-- header left menu start -->
            <ul class="header-navigation" data-show-menu-on-mobile>
                <li>
                    <a href="<?= get_site_url(); ?>" class="material-button">
                        <i class="fa fa-home"></i>
                        <?= translate('Home page'); ?>
                    </a>
                </li>
                <?php
                $listCategoryMenu = get_categories();
                ?>
                <?php if (!empty($listCategoryMenu) && count($listCategoryMenu) > 0): ?>
                    <li>
                        <a href="#" class="material-button submenu-toggle">
                            <i class="fa fa-pager"></i>
                            <?= translate('Categories') ?>
                            <i class="material-icons">&#xE313;</i></a>
                        <div class="header-submenu">
                            <ul>
                                <?php foreach ($listCategoryMenu as $categoryMenu): ?>
                                    <li><a href="<?= get_term_link($categoryMenu); ?>"><?= $categoryMenu->name; ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
            <!-- header left menu end -->

        </div>
        <div class="header-right with-seperator">

            <!-- header right menu start -->
            <ul class="header-navigation">
                <li>
                    <a href="#" class="material-button search-toggle"><i class="material-icons">&#xE8B6;</i></a>
                </li>
                <?php if (is_user_logged_in()): ?>
                    <li>
                        <a href="#" class="material-button submenu-toggle"><i class="material-icons">&#xE7FD;</i> <span
                                    class="hide-on-tablet"><?= wp_get_current_user()->display_name; ?></span></a>
                        <div class="header-submenu">
                            <ul>
                                <li><a href="<?= get_site_url() . '/logout'; ?>"><?= translate('logout'); ?></a></li>
                            </ul>
                        </div>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="#" class="material-button submenu-toggle"><i class="material-icons">&#xE7FD;</i> <span
                                    class="hide-on-tablet"><?= translate('Login') ?></span></a>
                        <div class="header-submenu">
                            <ul>
                                <li><a href="#" data-modal="loginModal"><?= translate('Login'); ?></a></li>
                                <li><a href="#" data-modal="registerModal"><?= translate('Register'); ?></a></li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
            <!-- header right menu end -->

        </div>

        <!--header search panel start -->
        <div class="search-bar">
            <form class="search-form" action="<?= get_site_url(); ?>" method="GET">
                <div class="search-input-wrapper">
                    <input type="text" name="search" placeholder="<?= translate('search something'); ?>" class="search-input" value="<?= $_GET['search'] ?? ''; ?>">
                    <button type="submit" class="search-submit"><i class="material-icons">&#xE5C8;</i>
                    </button>
                </div>
                <span class="search-close search-toggle">
						<i class="material-icons">&#xE5CD;</i>
					</span>
            </form>
        </div>
        <!--header search panel end -->

    </div>
</header>
<!-- header end -->


<!-- Left sidebar menu start -->
<div class="sidebar">
    <div class="sidebar-wrapper">

        <!-- side menu logo start -->
        <div class="sidebar-logo">
            <a href="#"></a>
            <div class="sidebar-toggle-button">
                <i class="material-icons">&#xE317;</i>
            </div>
        </div>
        <!-- side menu logo end -->

        <!-- sidebar menu start -->
        <ul class="sidebar-menu">
            <li class="active">
                <a href="<?= get_site_url(); ?>" class="material-button">
                    <span class="menu-icon"><i class="material-icons">&#xE88A;</i></span>
                    <span class="menu-label"><?= translate('Home page'); ?></span>
                </a>
            </li>

            <li>
                <a href="#" class="material-button">
                    <span class="menu-icon">
                        <i class="fa fa-pager"></i>
                    </span>
                    <span class="menu-label"><?= translate('Categories'); ?></span>
                    <span class="multimenu-icon"><i class="material-icons">&#xE313;</i></span>
                </a>

                <?php if (!empty($listCategoryMenu) && count($listCategoryMenu) > 0): ?>
                    <ul>
                        <?php foreach ($listCategoryMenu as $categoryMenu): ?>
                            <li>
                                <a href="<?= get_term_link($categoryMenu); ?>"><span class="menu-label"><?= $categoryMenu->name; ?></span></a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </li>
        </ul>
    </div>
</div>
<!-- Left sidebar menu end -->