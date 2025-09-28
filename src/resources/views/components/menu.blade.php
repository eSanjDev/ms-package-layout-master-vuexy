<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu flex-grow-0">
    <div class="container d-flex h-100">
        <ul class="menu-inner">
            @foreach ($menuData['menu'] ?? [] as $menu)
                {{-- main menu --}}
                <li class="menu-item {{$menu['slug'] == $currentRouteName ? 'active' : ''}}">
                    <a href="{{ isset($menu['url']) ? url($menu['url']) : 'javascript:void(0);' }}"
                       class="{{ isset($menu['submenu']) ? 'menu-link menu-toggle' : 'menu-link' }}"
                       @isset($menu['target'])) target="{{$menu['target']}}" @endisset>
                        @isset($menu['icon'])
                            <i class="{!! $menu['icon'] !!}"></i>
                        @endisset
                        <div>{{ isset($menu['name']) ? __($menu['name']) : '' }}</div>
                    </a>

                    {{-- submenu --}}
                    @isset($menu['submenu'])
                        <x-sub-menu :data="$menu['submenu']"></x-sub-menu>
                    @endisset
                </li>
            @endforeach
        </ul>
    </div>
</aside>
