<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
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
{{--                <li>--}}
{{--                    <a href="<?= get_site_url(); ?>" class="material-button">--}}
{{--                        <i class="fa fa-home"></i>--}}
{{--                        <?= translate('Home page'); ?>--}}
{{--                    </a>--}}
{{--                </li>--}}
            </ul>
            <!-- header left menu end -->

        </div>
        <div class="header-right with-seperator">
            <!-- header right menu start -->
            <ul class="header-navigation">
                <li>
                    <a href="#" class="material-button search-toggle"><i class="material-icons">&#xE8B6;</i></a>
                </li>
            </ul>
            <!-- header right menu end -->
        </div>

        <!--header search panel start -->
        <div class="search-bar">
            <form class="search-form" action="" method="GET">
                <div class="search-input-wrapper">
                    <input type="text" name="search" placeholder="" class="search-input" value="<?= $_GET['search'] ?? ''; ?>">
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
{{--            <li class="active">--}}
{{--                <a href="" class="material-button">--}}
{{--                    <span class="menu-icon"><i class="material-icons">&#xE88A;</i></span>--}}
{{--                    <span class="menu-label"></span>--}}
{{--                </a>--}}
{{--            </li>--}}

            <li>
                <a href="#" class="material-button">
                    <span class="menu-icon">
                        <i class="fa fa-pager"></i>
                    </span>
                    <span class="menu-label"></span>
                    <span class="multimenu-icon"><i class="material-icons">&#xE313;</i></span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- Left sidebar menu end -->


    <footer class="text-center">
        <h5>&copy;Copyright <?= date('Y') ?> by KimLong</h5>
    </footer>

    <link rel="stylesheet" type="text/css"
          href="{{ asset('lib/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/user/css/main-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('theme/user/css/responsive-style.css') }}">
    <link rel="stylesheet" href="{{ asset('lib/fontawesome/css/all.css') }}">
    <script src="{{ asset('lib/jquery.js') }}"></script>
    <script src="{{ asset('theme/user/plugins/zebra-tooltip/zebra_tooltips.min.js') }}"></script>
    <script src="{{ asset('lib/owl-carousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('theme/user/js/main-script.js') }}"></script>
</body>
</html>
