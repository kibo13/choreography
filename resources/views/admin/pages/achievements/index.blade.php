@extends('admin.index')
@section('title-admin', __('_section.achievements'))
@section('content-admin')
    <section id="achievements-index" class="overflow-auto">
        <h3>{{ __('_section.achievements') }}</h3>

        @if(session()->has('success'))
        <div class="my-2 alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
        @endif

        <div class="bk-tabs">
            <input class="bk-tabs__input bk-tab-1"
                   id="tab-1"
                   type="radio"
                   name="tab"
                   checked>
            <label class="bk-tabs__label" for="tab-1">
                {{ __('_field.table') }}
            </label>
            <input class="bk-tabs__input bk-tab-2"
                   id="tab-2"
                   type="radio"
                   name="tab">
            <label class="bk-tabs__label" for="tab-2">
                {{ __('_field.graph') }}
            </label>
            <input class="bk-tabs__input bk-tab-3"
                   id="tab-3"
                   type="radio"
                   name="tab">
            <label class="bk-tabs__label" for="tab-3">
                {{ __('_field.reports') }}
            </label>
            <div class="bk-tabs__content bk-tab-content-1">
                @include('admin.pages.achievements.table')
            </div>
            <div class="bk-tabs__content bk-tab-content-2">
                @include('admin.pages.achievements.graph')
            </div>
            <div class="bk-tabs__content bk-tab-content-3">
                @include('admin.pages.achievements.reports')
            </div>
        </div>
    </section>
@endsection
