@extends('layouts.master')
@section('content-head')
    <title>@yield('title-admin') | {{ config('app.name') }} </title>

    <!-- vendors -->
    <link rel="stylesheet" href="{{ asset('css/fullcalendar.min.css') }}">
    <script src="{{ asset('js/vendors/jquery.min.js') }}" defer></script>
    <script src="{{ asset('js/vendors/popper.min.js') }}" defer></script>
    <script src="{{ asset('js/vendors/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('js/vendors/jquery.dataTables.min.js') }}" defer></script>
    <script src="{{ asset('js/vendors/moment.min.js') }}" defer></script>
    <script src="{{ asset('js/vendors/fullcalendar.min.js') }}" defer></script>

    <!-- custom -->
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
    @include('components.modals.delete')
    @include('components.modals.confirm')
    @include('components.modals.event')
@endsection
