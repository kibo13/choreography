@extends('layouts.master')
@section('content-head')
        <title>{{ __('Login') . ' | ' . config('app.name') }} </title>
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
                Автоматизированная  информационная система учета деятельности руководителей клубных формирований хореографических коллективов ГДК
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
        <div id="auth-modal" class="auth">
            <div class="auth-wrapper">
                <h2 class="auth-title">{{ __('Login') }}</h2>
                <form class="auth-form" action="{{ route('login')  }}" method="POST">
                    @csrf
                    <div class="auth-form__control">
                        <label class="auth-form__label" for="name">
                            {{ __('Login') }}
                        </label>
                        <input class="auth-form__input @error('name') auth-form__input--invalid @enderror"
                               type="text"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               autocomplete="off"
                               required>
                    </div>
                    <div class="auth-form__control">
                        <label class="auth-form__label" for="password">
                            {{ __('Password') }}
                        </label>
                        <input class="auth-form__input @error('name') auth-form__input--invalid @enderror"
                               type="password"
                               id="password"
                               name="password"
                               autocomplete="off"
                               required>
                    </div>
                    <button class="auth-form__button">
                        {{ __('Login') }}
                    </button>
                </form>
            </div>
        </div>
        @error('name')
        <div class="auth-alert">
            {{ $message }}
        </div>
        @enderror
    </div>
@endsection
