@extends('layouts.master')
@section('content-head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('base.home') . ' | ' . config('app.name') }} </title>
    <link rel="stylesheet" href="{{ mix('css/admin.css') }}">
    <script src="{{ mix('js/admin.js') }}" defer></script>
@endsection
@section('content-body')
    <div class="admin">
        @include('admin.partials.sidebar')
        <div class="admin-wrapper">
            @include('admin.partials.navbar')
            @yield('content-admin')
        </div>
    </div>
@endsection
