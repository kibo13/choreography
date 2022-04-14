@extends('auth.index')
@section('content-auth')
    <login-form title="{{ __('Login') }}"
                href="{{ route('login') }}"
                home="{{ route('admin.home') }}"/>
@endsection
