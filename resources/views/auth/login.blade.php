@extends('auth.index')
@section('title-auth', __('Login'))
@section('content-auth')
    <login-form title="{{ __('Login') }}"
                href="{{ route('login') }}"
                home="{{ route('admin.home') }}"/>
@endsection
