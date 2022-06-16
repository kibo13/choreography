@extends('admin.index')
@section('title-admin', __('_section.passes'))
@section('content-admin')
    <section id="passes-index" class="overflow-auto">
        <h3>{{ __('_section.passes') }}</h3>

        <div class="bk-tabs">
            <input class="bk-tabs__input bk-tab-1"
                   id="tab-1"
                   type="radio"
                   name="tab"
                   checked>
            <label class="bk-tabs__label" for="tab-1">
                Активные
            </label>
            <input class="bk-tabs__input bk-tab-2"
                   id="tab-2"
                   type="radio"
                   name="tab">
            <label class="bk-tabs__label" for="tab-2">
                Неактивные
            </label>
            <div class="bk-tabs__content bk-tab-content-1">
                @include('admin.pages.passes.active')
            </div>
            <div class="bk-tabs__content bk-tab-content-2">
                @include('admin.pages.passes.deactive')
            </div>
        </div>
    </section>
@endsection
