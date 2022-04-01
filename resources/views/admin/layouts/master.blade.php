<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NSK.KG - @yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/icons/logo.png') }}">
{{--    <link rel="stylesheet" href="{{ mix('css/admin.css') }}">--}}
</head>
<body class="app">

<h1>Welcome to page</h1>
<div class="dropdown-menu">
    <a id="logout-link" class="dropdown-item" href="{{ route('logout') }}">
        {{ __('main.exit') }}
    </a>

{{--    <form id="logout-form" action="{{ route('logout') }}" method="POST">--}}
{{--        @csrf--}}
{{--    </form>--}}
</div>

{{--@include('admin.partials.sidebar')--}}
{{--<main class="main">--}}
{{--    <div class="content">--}}
{{--        @include('admin.partials.navbar')--}}
{{--        @yield('content')--}}
{{--    </div>--}}
{{--</main>--}}

{{--@include('admin.components.modals.destroy')--}}

{{--<script src="{{ mix('js/admin.js') }}"></script>--}}
</body>
</html>


