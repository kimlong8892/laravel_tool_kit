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

    @if(checkUrlIsHttps(env('APP_URL')))
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    @endif

    @hasSection('title')
        <title>@yield('title') - {{ env('APP_NAME') }}</title>
    @else
        <title>{{ env('APP_NAME') }}</title>
    @endif
</head>

<body>
<style>
    .text-right {
        text-align: right;
    }

    table tr th {
        text-align: center;
    }

    table * {
        word-break: break-all;
    }

    .font-weight-bold {
        font-weight: bold;
    }

    .form-group {
        margin-top: 15px;
    }

    .ml-2 {
        margin-left: 15px;
    }
</style>

<!-- Layout wrapper -->
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
        <!-- Menu -->
        <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
            <div class="app-brand demo">
                <a href="{{ route('admin.home') }}" class="app-brand-link">
              <span class="app-brand-logo demo mt-2">
                <img src="{{ asset('images_site/logo.png') }}" alt="" width="64px">
              </span>
                    <span
                        class="app-brand-text demo menu-text fw-bolder ms-2 text-uppercase">{{ __('Admin') }}</span>
                </a>

                <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                    <i class="bx bx-chevron-left bx-sm align-middle"></i>
                </a>
            </div>

            <div class="menu-inner-shadow"></div>

            <ul class="menu-inner py-1">
                @include('layouts._list_menu', ['listMenu' => config('custom.admin_menu')])
            </ul>

            <!-- Footer -->
            <footer class="content-footer footer">
                <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                    <div class="mb-2 mb-md-0">
                        ©copyright {{ date('Y') }} by {{ env('APP_NAME') }}
                    </div>
                </div>
            </footer>
            <!-- / Footer -->
        </aside>
        <!-- / Menu -->


        <!-- Layout container -->
        <div class="layout-page">
            @include('layouts._admin_nav')
            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->
                <div class="container-fluid container-p-y mb-5">
                    @if(session()->has('success'))
                        <h2 class="text-success p-2">
                            {{ session()->get('success') }}
                        </h2>
                    @endif

                    @if(session()->has('error'))
                        <h2 class="text-danger p-2">
                            {{ session()->get('error') }}
                        </h2>
                    @endif

                    <h2 class="text-uppercase font-weight-bold">@yield('title')</h2>

                    @yield('content')
                </div>
                <!-- / Content -->
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
{{--<script src="{{ asset('lib/ckeditor5/ckeditor.js') }}"></script>--}}
<script src="{{ asset('lib/ckeditor4/ckeditor.js') }}"></script>
<script src="{{ asset('lib/axios.min.js') }}"></script>
<script src="{{ asset('lib/loadingoverlay.min.js') }}"></script>
<link href="{{ asset('lib/select2/css/select2.min.css') }}" rel="stylesheet"/>
<script src="{{ asset('lib/select2/js/select2.min.js') }}"></script>
<style>
    .nowrap {
        white-space: nowrap;
    }

    img[src=""] {
        display: none;
    }
</style>
<script>
    function applyCkeditorAndSelect2() {
        CKEDITOR.replaceAll('ckeditor');

        $('.select2').each(function () {
            let config = {
                tags: true,
                tokenSeparators: [',']
            };

            if ($(this).attr('data-is-tags') === '0') {
                config.tags = false;
            }

            $(this).select2(config);
        });
    }

    $(document).ready(function () {
        function convertToSlug(str) {
            return str.toString().normalize('NFD').replace(/[\u0300-\u036f]/g, "") //remove diacritics
                .toLowerCase()
                .replace(/\s+/g, '-') //spaces to dashes
                .replace(/&/g, '-and-') //ampersand to and
                .replace(/[^\w\-]+/g, '') //remove non-words
                .replace(/\-\-+/g, '-') //collapse multiple dashes
                .replace(/^-+/, '') //trim starting dash
                .replace(/-+$/, ''); //trim ending dash
        }

        applyCkeditorAndSelect2();

        $('body').on('change', 'input[type="file"]', function () {
            $("#" + $(this).attr('data-id') + "-preview").fadeIn("fast").attr('src', URL.createObjectURL(event.target.files[0]));
        })

        $('input[data-is-gen-slug="1"]').change(function () {
            let value = $(this).val();
            let idElementSlug = $(this).attr('data-input-slug-id');
            $('#' + idElementSlug).val(convertToSlug(value));
        });

        $('[data-is-dependency="1"]').change(function () {
            const myArrayDependencyValue = $(this).attr('data-value-dependency-on').split(',');

            if (myArrayDependencyValue.indexOf($(this).val()) !== -1) {
                $($(this).attr('data-element-dependency')).show();
                $($(this).attr('data-element-dependency') + " *").prop('disabled', false);
            } else {
                $($(this).attr('data-element-dependency')).hide();
                $($(this).attr('data-element-dependency') + " *").prop('disabled', true)
            }
        });

        $('[data-is-dependency="1"]').change();
    });
</script>
@yield('js')

</body>
</html>
