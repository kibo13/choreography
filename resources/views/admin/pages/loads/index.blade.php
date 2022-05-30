@extends('admin.index')
@section('title-admin', __('_section.loads'))
@section('content-admin')
    <section id="loads-index" class="overflow-auto">
        <h3>{{ __('_section.loads') }}</h3>

        @if(session()->has('success'))
        <div class="my-2 alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
        @endif

        @if(session()->has('warning'))
        <div class="my-2 alert alert-warning alert-limit" role="alert">
            {{ session()->get('warning') }}
        </div>
        @endif

        <h5>Таблица нагрузок по часам</h5>
        @include('admin.pages.loads.hours')

        <h5>Таблица нагрузок по дням недели</h5>
        @include('admin.pages.loads.week')
    </section>
@endsection


