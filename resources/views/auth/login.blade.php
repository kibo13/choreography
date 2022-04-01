<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>NSK.KG - AUTH</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/icons/logo.png') }}">
    <link rel="stylesheet" href="{{ mix('css/auth.css') }}">
</head>
<body>
<main class="auth">
    <div class="auth-logo">
        <img class="auth-logo__icon" src="{{ asset('assets/icons/logo.png') }}">
        <h3 class="auth-logo__title">
            Автоматизированная информационная система <br>
            руководителей клубных формирований хореографических коллективов ГДК
        </h3>
    </div>
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
    @error('name')
    <div class="auth-alert">
        {{ $message }}
    </div>
    @enderror
</main>
</body>
</html>


