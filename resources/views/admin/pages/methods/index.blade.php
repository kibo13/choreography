@extends('admin.index')
@section('title-admin', __('_section.methods'))
@section('content-admin')
    <section id="methods-index" class="overflow-auto">
        <h3>{{ __('_section.methods') }}</h3>

        @if(@is_access('method_full'))
        <div class="my-2 btn-group">
            <a class="btn btn-primary" href="{{ route('admin.methods.create') }}">
                {{ __('_record.new') }}
            </a>
        </div>
        @endif

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
                {{ __('_section.lessons') }}
            </label>
            <input class="bk-tabs__input bk-tab-2"
                   id="tab-2"
                   type="radio"
                   name="tab">
            <label class="bk-tabs__label" for="tab-2">
                {{ __('_section.methods') }}
            </label>
            <div class="bk-tabs__content bk-tab-content-1">
                @include('admin.pages.methods.lessons')
            </div>
            <div class="bk-tabs__content bk-tab-content-2">
                @include('admin.pages.methods.docs')
            </div>
        </div>

    </section>
@endsection
