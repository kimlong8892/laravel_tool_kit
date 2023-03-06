@foreach($listMenu as $menu)
    @if(empty($menu['list_child']))
        <li class="menu-item  @if($menu['route'] == \Request::route()->getName()) active @endif">
            <a href="{{ route($menu['route']) }}" class="menu-link">
                @if(empty($menu['icon']))
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                @else
                    {!! $menu['icon'] !!}
                @endif
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

        <li class="menu-item @if($isCurrentRoute) active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                @if(empty($menu['icon']))
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                @else
                    {!! $menu['icon'] !!}
                @endif
                <div data-i18n="Layouts">{{ __($menu['title'] ?? '') }}</div>
            </a>

            <ul class="menu-sub">
                @foreach($menu['list_child'] as $menuChild)
                    <li class="menu-item @if($menuChild['route'] == \Request::route()->getName()) active @endif">
                        <a href="{{ route($menuChild['route']) }}" class="menu-link">
                            <div data-i18n="Without menu">{{ __($menuChild['title'] ?? '') }}</div>
                        </a>
                    </li>
                @endforeach
            </ul>
        </li>
    @endif
@endforeach
