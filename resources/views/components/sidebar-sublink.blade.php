@props(['href', 'active'])

<li class="submenu-item {{ $active ? 'active' : '' }}">
    <a href="{{ $href }}" class="submenu-link">{{ $slot }}</a>
</li>
