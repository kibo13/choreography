@extends('layouts.master')
@section('content-head')
    <title>@yield('title-admin') | {{ config('app.name') }} </title>
    <link rel="stylesheet" href="{{ mix('css/admin.css') }}">
    <script src="{{ mix('js/admin.js') }}" defer></script>
@endsection
@section('content-body')
    <div class="admin">
        @include('admin.partials.sidebar')
        <div class="admin-wrapper">
            <div class="admin-content">
                @include('admin.partials.navbar')
                @yield('content-admin')
            </div>
        </div>
    </div>
@endsection
