@props(['active' => false])

<li class="sidebar-item {{ $active ? 'active' : '' }}">
    <a {{ $attributes->merge(['class' => 'sidebar-link']) }}>
        {{ $slot }}
    </a>
</li>
