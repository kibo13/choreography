@extends('admin.index')
@section('title-admin', __('_section.passes'))
@section('content-admin')
    <section id="passes-index" class="overflow-auto">
        <h3>{{ __('_section.passes') }}</h3>

        @if(@is_access('pass_full'))
        <div class="my-2 btn-group">
            <a class="btn btn-primary" href="{{ route('admin.passes.create') }}">
                {{ __('_record.new') }}
            </a>
        </div>
        @endif

        <div class="bk-tabs">
            <input class="bk-tabs__input bk-tab-1"
                   id="tab-1"
                   type="radio"
                   name="tab"
                   checked>
            <label class="bk-tabs__label" for="tab-1">
                Все
            </label>
            <input class="bk-tabs__input bk-tab-2"
                   id="tab-2"
                   type="radio"
                   name="tab">
            <label class="bk-tabs__label" for="tab-2">
                Архив
            </label>
            <input class="bk-tabs__input bk-tab-3"
                   id="tab-3"
                   type="radio"
                   name="tab">
            <label class="bk-tabs__label" for="tab-3">
                Бланки
            </label>
            <div class="bk-tabs__content bk-tab-content-1">
                @include('admin.pages.passes.active')
            </div>
            <div class="bk-tabs__content bk-tab-content-2">
                @include('admin.pages.passes.deactive')
            </div>
            <div class="bk-tabs__content bk-tab-content-3">
                @include('admin.pages.passes.blanks')
            </div>
        </div>
    </section>
@endsection
