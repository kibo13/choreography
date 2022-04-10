<nav id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <a class="sidebar-link" href="{{ route('admin.home') }}">
            <span class="sidebar-link__logo">
                <img class="sidebar-link__icon"
                     src="{{ asset('assets/icons/logo.png') }}"
                     alt="logo">
            </span>
            <span class="sidebar-link__title">{{ __('base.admin') }}</span>
        </a>
    </div>

    <ul class="sidebar-list">
        <li @sbactive('admin.home')>
            <a class="sidebar-link" href="{{ route('admin.home') }}" >
                @include('components.icons.home') Главная
            </a>
        </li>
        <li @sbactive('admin.user*')>
            <a class="sidebar-link" href="{{ route('admin.users') }}">
                @include('components.icons.toggle') Сотрудники
            </a>
        </li>
    </ul>
</nav>
