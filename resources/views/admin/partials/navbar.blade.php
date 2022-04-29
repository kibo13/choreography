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

                @if(@is_info('1'))
                <li class="nav-item dropdown">
                    <a class="nav-link pr-3" href="#" data-toggle="dropdown">
                        {{ __('_section.info') }}
                    </a>
                    <div class="navbar-dropdown-menu dropdown-menu">
                        @if(@is_access('lesson_read'))
                        <a class="dropdown-item" href="{{ route('admin.lessons.index') }}">
                            {{ __('_section.lessons') }}
                        </a>
                        @endif
                        @if(@is_access('sp_read'))
                        <a class="dropdown-item" href="{{ route('admin.specialties.index') }}">
                            {{ __('_section.specialties') }}
                        </a>
                        @endif
                    </div>
                </li>
                @endif

                <li class="nav-item dropdown">
                    <a class="nav-link pr-3" href="#" data-toggle="dropdown">
                        {{ @short_fio(Auth::user()->id) }}
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
