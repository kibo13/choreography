<nav class="navbar navbar-expand-sm navbar-light bg-light">
    <div class="container-fluid px-1">
        <button id="sidebarToggler" class="navbar-btn">
            @include('components.icons.toggle')
        </button>

        <button class="navbar-toggler"
                id="navbarToggler"
                data-toggle="collapse"
                data-target="#navbarSupportedContent">
            <span></span>
            <span></span>
            <span></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav d-flex justify-content-end w-100">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        Пользователи
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle pr-3"
                       href="#"
                       data-toggle="dropdown">
                        Информация
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">
                            Категории
                        </a>
                        <a class="dropdown-item" href="#">
                            Клиенты
                        </a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle pr-3"
                       href="#"
                       data-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu">
                        <form id="logout-form" action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button id="logout-link" class="dropdown-item">
                                {{ __('base.exit') }}
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
