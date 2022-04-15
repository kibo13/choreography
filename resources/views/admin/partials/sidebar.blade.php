<nav id="sidebar" class="sidebar ">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <a class="sidebar-logo__link" href="{{ route('admin.home') }}">
                <img class="sidebar-logo__icon"
                     src="{{ asset('assets/icons/logo.png') }}"
                     alt="{{ __('base.logo') }}"
                     title="{{ __('base.admin') }}">
                <span class="sidebar-logo__text">
                    {{ __('base.admin') }}
                </span>
            </a>
        </div>
    </div>

    <ul class="sidebar-list">
        <li class="sidebar-list__item {{ @is_active('admin.home', 'sidebar-list__item--active') }}">
            <a class="sidebar-list__link" href="{{ route('admin.home') }}" title="{{ __('section.home') }}">
                {{ @fa('fa-home sidebar-list__icon') }}
                <span class="sidebar-list__text">{{ __('section.home') }}</span>
            </a>
        </li>
        <li class="sidebar-list__item {{ @is_active('admin.user*', 'sidebar-list__item--active') }}">
            <a class="sidebar-list__link" href="{{ route('admin.users.index') }}" title="{{ __('section.users') }}">
                {{ @fa('fa-copy sidebar-list__icon') }}
                <span class="sidebar-list__text">{{ __('section.users') }}</span>
            </a>
        </li>
    </ul>
</nav>
