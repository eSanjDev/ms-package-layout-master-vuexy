<ul class="menu-sub">
    @foreach ($menu as $submenu)
        <li class="menu-item {{$currentRouteName == $submenu['slug'] ? 'active' : ''}}">
            <a href="{{ isset($submenu['url']) ? url($submenu['url']) : 'javascript:void(0)' }}"
               class="{{ isset($submenu['submenu']) ? 'menu-link menu-toggle' : 'menu-link' }}"
               @if (isset($submenu['target']) and !empty($submenu['target'])) target="_blank" @endif>
                @if (isset($submenu['icon']))
                    <i class="{{ $submenu['icon'] }}"></i>
                @endif
                <div>{{ isset($submenu['name']) ? __($submenu['name']) : '' }}</div>
                @isset($submenu['badge'])
                    <div class="badge bg-{{ $submenu['badge'][0] }} rounded-pill ms-auto">{{ $submenu['badge'][1] }}</div>
                @endisset
            </a>

            {{-- submenu --}}
            @if (isset($submenu['submenu']))
                <x-sub-menu :data="$menu['submenu']"></x-sub-menu>
            @endif
        </li>
    @endforeach
</ul>
