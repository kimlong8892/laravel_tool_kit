<!-- Navbar -->

<nav
    class="layout-navbar container-fluid navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
    id="layout-navbar"
>
    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
        <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
            <i class="bx bx-menu bx-sm"></i>
        </a>
    </div>

    <style>
        .pl-2 {
            padding-left: 10px;
        }
    </style>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">

        <ul class="navbar-nav flex-row align-items-center ms-auto">
            <!-- User -->
            @if(\Illuminate\Support\Facades\Auth::guard('admin')->check())
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                       data-bs-toggle="dropdown">

                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-online">
                                <img src="{{ asset('images_site/avatar_user_default.jpeg') }}" alt
                                     class="w-px-40 h-auto rounded-circle"/>
                            </div>
                            <div class="pl-2">{{ __('Hello') . ', ' . \Illuminate\Support\Facades\Auth::guard('admin')->user()->name }}</div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.edit_profile') }}">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="{{ asset('images_site/avatar_user_default.jpeg') }}" alt
                                                 class="w-px-40 h-auto rounded-circle"/>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold d-block">{{ \Illuminate\Support\Facades\Auth::guard('admin')->user()->name }}</span>
                                        <small class="text-muted">{{ __('Admin') }}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('admin.logout') }}">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">{{ __('Logout') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
            <!--/ User -->
        </ul>
    </div>
</nav>

<!-- / Navbar -->
