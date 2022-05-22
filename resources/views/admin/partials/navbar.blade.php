<nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="m-0 p-0 container-fluid">
        <button class="sidebar-toggle navbar-toggle--sidebar"
                id="sidebar-toggle">
            @include('components.icons.toggle')
        </button>

        <button class="navbar-toggler navbar-toggle--navbar"
                id="navbar-toggle"
                data-toggle="collapse"
                data-target="#navbar-content">
            @include('components.icons.toggle')
        </button>

        <div class="collapse navbar-collapse" id="navbar-content">
            <ul class="navbar-nav d-flex justify-content-end w-100">
                @if(@is_access('user_read'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.users.index') }}">
                        {{ __('_section.users') }}
                    </a>
                </li>
                @endif

                @if(@is_setting('1'))
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" data-toggle="dropdown">
                        {{ __('_section.settings') }}
                    </a>
                    <div class="navbar-dropdown-menu dropdown-menu">
                        @if(@is_access('worker_read'))
                        <a class="dropdown-item" href="{{ route('admin.workers.index') }}">
                            {{ __('_section.workers') }}
                        </a>
                        @endif
                        @if(@is_access('group_read'))
                        <a class="dropdown-item" href="{{ route('admin.groups.index') }}">
                            {{ __('_section.groups') }}
                        </a>
                        @endif
                        @if(@is_access('specialty_read'))
                        <a class="dropdown-item" href="{{ route('admin.specialties.index') }}">
                            {{ __('_section.specialties') }}
                        </a>
                        @endif
                        @if(@is_access('room_read'))
                        <a class="dropdown-item" href="{{ route('admin.rooms.index') }}">
                            {{ __('_section.rooms') }}
                        </a>
                        @endif
                        @if(@is_access('discount_read'))
                        <a class="dropdown-item" href="{{ route('admin.discounts.index') }}">
                            {{ __('_section.privileges') }}
                        </a>
                        @endif
                        @if(@is_access('orgkomitet_read'))
                        <a class="dropdown-item" href="{{ route('admin.orgkomitets.index') }}">
                            {{ __('_section.orgkomitets') }}
                        </a>
                        @endif
                    </div>
                </li>
                @endif

                <li class="nav-item dropdown">
                    <a class="nav-link pr-3" href="#" data-toggle="dropdown">
                        {{ Auth::user()->username }}
                    </a>
                    <form class="navbar-dropdown-menu dropdown-menu"
                          action="{{ route('logout') }}"
                          method="POST">
                        @csrf
                        <button class="dropdown-item">
                            {{ __('_action.exit') }}
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
