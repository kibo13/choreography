<nav id="sidebar" class="sidebar ">
    <div class="sidebar-header">
        <div class="sidebar-logo">
            <a class="sidebar-logo__link" href="{{ route('admin.home') }}">
                <img class="sidebar-logo__icon"
                     src="{{ asset('assets/icons/logo.png') }}"
                     alt="{{ __('logotype') }}"
                     title="{{ __('_section.cabinet') }}">
                <span class="sidebar-logo__text">
                    {{ __('_section.cabinet') }}
                </span>
            </a>
        </div>
    </div>

    <ul class="sidebar-list">
        @if(@is_access('home'))
        <li class="sidebar-list__item {{ @is_active('admin.home', 'sidebar-list__item--active') }}">
            <a class="sidebar-list__link"
               href="{{ route('admin.home') }}"
               title="{{ __('_section.home') }}">
                {{ @fa('fa-home sidebar-list__icon') }}
                <span class="sidebar-list__text">
                    {{ __('_section.home') }}
                </span>
            </a>
        </li>
        @endif
        @if(@is_access('profile'))
        <li class="sidebar-list__item {{ @is_active('admin.profile*', 'sidebar-list__item--active') }}">
            <a class="sidebar-list__link"
               href="{{ route('admin.profile.index') }}"
               title="{{ __('_section.profile') }}">
                {{ @fa('fa-user-circle-o sidebar-list__icon') }}
                <span class="sidebar-list__text">
                    {{ __('_section.profile') }}
                </span>
            </a>
        </li>
        @endif
        @if(@is_access('app_read'))
        <li class="sidebar-list__item {{ @is_active('admin.application*', 'sidebar-list__item--active') }}">
            <a class="sidebar-list__link"
               href="{{ route('admin.applications.index') }}"
               title="{{ __('section.applications') }}">
                {{ @fa('fa-file-o sidebar-list__icon') }}
                <span class="sidebar-list__text">
                    {{ __('section.applications') }}
                </span>
            </a>
        </li>
        @endif
        @if(Auth::user()->permissions()->pluck('slug')->contains('app_read'))
        <li class="sidebar-list__item {{ @is_active('admin.application*', 'sidebar-list__item--active') }}">
            <a class="sidebar-list__link"
               href="{{ route('admin.applications.index') }}"
               title="{{ __('section.incoming') }}">
                {{ @fa('fa-inbox sidebar-list__icon') }}
                <span class="sidebar-list__text">
                    {{ __('section.incoming') }}
                </span>
            </a>
        </li>
        @endif
        @if(@is_access('member_read'))
        <li class="sidebar-list__item {{ @is_active('admin.customer*', 'sidebar-list__item--active') }}">
            <a class="sidebar-list__link"
               href="{{ route('admin.customers.index') }}"
               title="{{ __('_section.customers') }}">
                {{ @fa('fa-users sidebar-list__icon') }}
                <span class="sidebar-list__text">
                    {{ __('_section.customers') }}
                </span>
            </a>
        </li>
        @endif
    </ul>
</nav>
