<nav id="sidebar" class="sidebar">
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
        @if(@is_access('app_read'))
        <li class="sidebar-list__item {{ @is_active('admin.application*', 'sidebar-list__item--active') }}">
            <a class="sidebar-list__link"
               href="{{ route('admin.applications.index') }}"
               title="{{ __('_section.applications') }}">
                {{ @fa('fa-inbox sidebar-list__icon') }}
                <span class="sidebar-list__text">
                    {{ __('_section.applications') }}
                </span>
            </a>
        </li>
        @endif
        @if(@is_access('timetable_read'))
        <li class="sidebar-list__item {{ @is_active('admin.timetable*', 'sidebar-list__item--active') }}">
            <a class="sidebar-list__link"
               href="{{ route('admin.timetable.index') }}"
               title="{{ __('_section.timetable') }}">
                {{ @fa('fa-calendar sidebar-list__icon') }}
                <span class="sidebar-list__text">
                    {{ __('_section.timetable') }}
                </span>
            </a>
        </li>
        @endif
        @if(@is_access('event_read'))
        <li class="sidebar-list__item {{ @is_active('admin.event*', 'sidebar-list__item--active') }}">
            <a class="sidebar-list__link"
               href="{{ route('admin.events.index') }}"
               title="{{ __('_section.events') }}">
                {{ @fa('fa-eercast sidebar-list__icon') }}
                <span class="sidebar-list__text">
                    {{ __('_section.events') }}
                </span>
            </a>
        </li>
        @endif
        @if(@is_access('achievement_read'))
        <li class="sidebar-list__item {{ @is_active('admin.achievement*', 'sidebar-list__item--active') }}">
            <a class="sidebar-list__link"
               href="{{ route('admin.achievements.index') }}"
               title="{{ __('_section.achievements') }}">
                {{ @fa('fa-trophy sidebar-list__icon') }}
                <span class="sidebar-list__text">
                    {{ __('_section.achievements') }}
                </span>
            </a>
        </li>
        @endif
        @if(@is_access('member_read'))
        <li class="sidebar-list__item {{ @is_active('admin.member*', 'sidebar-list__item--active') }}">
            <a class="sidebar-list__link"
               href="{{ route('admin.members.index') }}"
               title="{{ __('_section.members') }}">
                {{ @fa('fa-users sidebar-list__icon') }}
                <span class="sidebar-list__text">
                    {{ __('_section.members') }}
                </span>
            </a>
        </li>
        @endif
        @if(@is_access('pass_read'))
        <li class="sidebar-list__item {{ @is_active('admin.pass*', 'sidebar-list__item--active') }}">
            <a class="sidebar-list__link"
               href="{{ route('admin.passes.index') }}"
               title="{{ __('_section.passes') }}">
                {{ @fa('fa-wpforms sidebar-list__icon') }}
                <span class="sidebar-list__text">
                    {{ __('_section.passes') }}
                </span>
            </a>
        </li>
        @endif
        @if(@is_access('report_read'))
        <li class="sidebar-list__item {{ @is_active('admin.report*', 'sidebar-list__item--active') }}">
            <a class="sidebar-list__link"
               href="{{ route('admin.reports.index') }}"
               title="{{ __('_section.reports') }}">
                {{ @fa('fa-file-text-o sidebar-list__icon') }}
                <span class="sidebar-list__text">
                {{ __('_section.reports') }}
            </span>
            </a>
        </li>
        @endif
        @if(@is_access('help_read'))
        <li class="sidebar-list__item {{ @is_active('admin.support*', 'sidebar-list__item--active') }}">
            <a class="sidebar-list__link"
               href="{{ route('admin.support.index') }}"
               title="{{ __('_section.support') }}">
                {{ @fa('fa-pencil-square-o sidebar-list__icon') }}
                <span class="sidebar-list__text">
                    {{ __('_section.support') }}
                </span>
            </a>
        </li>
        @endif
    </ul>
</nav>
