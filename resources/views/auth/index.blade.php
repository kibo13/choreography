@extends('layouts.master')
@section('content-head')
    <title>@yield('title-auth') | {{ config('app.name') }} </title>
    <link rel="stylesheet" href="{{ mix('css/auth.css') }}">
    <script src="{{ mix('js/auth.js') }}" defer></script>
@endsection
@section('content-body')
    <div class="mai">
        <div class="mai-wrapper">
            <div class="mai-logo">
                <a class="mai-logo__link" href="https://mai.ru/" target="_blank" >
                    <img class="mai-logo__icon"
                         src="{{ asset('assets/icons/mai.svg') }}"
                         alt="Московский Авиационный Институт" >
                </a>
            </div>
            <h3 class="mai-title">
                {{ env('APP_FULLNAME') }}
            </h3>
            <ul class="mai-contributors">
                <li class="mai-contributors__member">
                    <p class="mai-contributors__position">руководитель:</p>
                    <p class="mai-contributors__fio">Н.Н. Кулепетова</p>
                </li>
                <li class="mai-contributors__member">
                    <p class="mai-contributors__position">разработчик:</p>
                    <p class="mai-contributors__fio">К.С. Жолмурзаева</p>
                </li>
            </ul>
            <div class="mai-issue">2022</div>
            <button id="auth-sign" class="auth-sign">
                {{  __('Login') }}
            </button>
        </div>
    </div>
    <div class="auth" id="auth-modal" >
        <div class="auth-wrapper">
            @yield('content-auth')
        </div>
    </div>
@endsection
