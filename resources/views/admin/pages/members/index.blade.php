@extends('admin.index')
@section('title-admin', __('_section.members'))
@section('content-admin')
    <section id="members-index" class="overflow-auto">
        <h3>{{ __('_section.members') }}</h3>

        @if(session()->has('success'))
        <div class="my-2 alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
        @endif

        @if(session()->has('warning'))
        <div class="my-2 alert alert-warning" role="alert">
            {{ session()->get('warning') }}
        </div>
        @endif

        <div class="bk-tabs">
            <input class="bk-tabs__input bk-tab-1"
                   id="tab-1"
                   type="radio"
                   name="tab"
                   checked>
            <label class="bk-tabs__label" for="tab-1">
                {{ __('_field.places') }}
            </label>
            <input class="bk-tabs__input bk-tab-2"
                   id="tab-2"
                   type="radio"
                   name="tab">
            <label class="bk-tabs__label" for="tab-2">
                {{ __('_field.list') }}
            </label>
            <input class="bk-tabs__input bk-tab-3"
                   id="tab-3"
                   type="radio"
                   name="tab">
            <label class="bk-tabs__label" for="tab-3">
                {{ __('_field.blanks') }}
            </label>
            <div class="bk-tabs__content bk-tab-content-1">
                @include('admin.pages.members.places')
            </div>
            <div class="bk-tabs__content bk-tab-content-2">
                @include('admin.pages.members.table')
            </div>
            <div class="bk-tabs__content bk-tab-content-3">
                @include('admin.pages.members.blanks')
            </div>
        </div>
    </section>
@endsection
