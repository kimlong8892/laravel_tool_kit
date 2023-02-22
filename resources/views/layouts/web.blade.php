<!DOCTYPE html>
<html
    lang="en"
    class="light-style layout-menu-fixed"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="../assets/"
    data-template="vertical-menu-template-free"
>
<head>
    <meta charset="utf-8"/>
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <link rel="icon" type="image/x-icon" href="{{ asset('images_site/logo.png') }}">

    @if(checkUrlIsHttps(url('')))
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif

    @hasSection('title')
        <title>@yield('title') - {{ env('APP_NAME') }}</title>
    @else
        <title>{{ env('APP_NAME') }}</title>
    @endif
</head>

<body>

<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="{{ route('web.home') }}" class="app-brand-link">
              <span class="app-brand-logo demo mt-2">
                <img src="{{ asset('images_site/logo.png') }}" alt="" width="64px">
              </span>
                    <span
                        class="app-brand-text demo menu-text fw-bolder ms-2 text-uppercase">{{ env('APP_NAME') }}</span>
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">
                @php
                    $listMenuWeb = config('custom.web_menu');
                @endphp


                @foreach($listMenuWeb as $menu)
                    @if(empty($menu['list_child']))
                        <li class="menu-item  @if($menu['route'] == \Request::route()->getName()) active @endif">
                            <a href="{{ route($menu['route']) }}" class="menu-link">
                                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                                <div data-i18n="Analytics">{{ __($menu['title'] ?? '') }}</div>
                            </a>
                        </li>
                    @else
                        @php
                            $isCurrentRoute = false;
                            foreach ($menu['list_child'] as $menuChild) {
                                if ($menuChild['route'] == \Request::route()->getName()) {
                                    $isCurrentRoute = true;
                                }
                            }
                        @endphp

                        <li class="menu-item @if($isCurrentRoute) active @endif">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons bx bx-layout"></i>
                                <div data-i18n="Layouts">{{ __($menu['title'] ?? '') }}</div>
                            </a>

                            <ul class="menu-sub">
                                @foreach($menu['list_child'] as $menuChild)
                                    <li class="menu-item">
                                        <a href="{{ route($menuChild['route']) }}" class="menu-link">
                                            <div data-i18n="Without menu">{{ __($menuChild['title'] ?? '') }}</div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                @endforeach
            </ul>
        </aside>
        <!-- / Menu -->


        <!-- Layout container -->
        <div class="layout-page">
            @include('layouts._web_nav')
            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="container-xxl flex-grow-1 container-p-y">
                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                    @endif

                    @if(session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                    @endif
                    @yield('content')
                </div>
                <!-- / Content -->

                <!-- Footer -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                        <div class="mb-2 mb-md-0">
                            ©copyright {{ date('Y') }} by {{ env('APP_NAME') }}
                        </div>
                    </div>
                </footer>
                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>
            <!-- Content wrapper -->
        </div>
        <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>
<!-- / Layout wrapper -->
<link rel="stylesheet" href="{{ asset('lib/fontawesome/css/all.css') }}">
<link rel="stylesheet" href="{{ asset('theme/user/assets/vendor/fonts/boxicons.css') }}"/>
<link rel="stylesheet" href="{{ asset('theme/user/assets/vendor/css/core.css') }}"
      class="template-customizer-core-css"/>
<link rel="stylesheet" href="{{ asset('theme/user/assets/vendor/css/theme-default.css') }}"
      class="template-customizer-theme-css"/>

<link rel="stylesheet" href="{{ asset('theme/user/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}"/>
<link rel="stylesheet" href="{{ asset('theme/user/assets/vendor/libs/apex-charts/apex-charts.css') }}"/>
<script src="{{ asset('theme/user/assets/vendor/js/helpers.js') }}"></script>
<script src="{{ asset('theme/user/assets/js/config.js') }}"></script>


<script src="{{ asset('theme/user/assets/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('theme/user/assets/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('theme/user/assets/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('theme/user/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('theme/user/assets/vendor/js/menu.js') }}"></script>
<script src="{{ asset('theme/user/assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script src="{{ asset('theme/user/assets/js/main.js') }}"></script>
<script src="{{ asset('theme/user/assets/js/dashboards-analytics.js') }}"></script>

<script src="{{ asset('lib/sweetalert2/sweetalert2.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('lib/sweetalert2/sweetalert2.min.css') }}">
<script src="{{ asset('lib/helper/functions.js') }}"></script>
<script src="{{ asset('lib/loadingoverlay.min.js') }}"></script>
@yield('js')

</body>
</html>
