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
            <a class="sidebar-list__link"
               href="{{ route('admin.home') }}"
               title="{{ __('section.home') }}">
                {{ @fa('fa-home sidebar-list__icon') }}
                <span class="sidebar-list__text">
                    {{ __('section.home') }}
                </span>
            </a>
        </li>
        <li class="sidebar-list__item {{ @is_active('admin.profile*', 'sidebar-list__item--active') }}">
            <a class="sidebar-list__link"
               href="{{ route('admin.profile.index') }}"
               title="{{ __('section.profile') }}">
                {{ @fa('fa-user sidebar-list__icon') }}
                <span class="sidebar-list__text">
                    {{ __('section.profile') }}
                </span>
            </a>
        </li>
        <li class="sidebar-list__item {{ @is_active('admin.customer*', 'sidebar-list__item--active') }}">
            <a class="sidebar-list__link"
               href="{{ route('admin.customers.index') }}"
               title="{{ __('section.customers') }}">
                {{ @fa('fa-users sidebar-list__icon') }}
                <span class="sidebar-list__text">
                    {{ __('section.customers') }}
                </span>
            </a>
        </li>
    </ul>
</nav>
