@extends('admin.index')
@section('title-admin', __('_section.passes'))
@section('content-admin')
    <section id="passes-client" class="overflow-auto">
        <h3>{{ __('_section.passes') }}</h3>

        <div class="bk-tabs">
            <input class="bk-tabs__input bk-tab-1"
                   id="tab-1"
                   type="radio"
                   name="tab"
                   checked>
            <label class="bk-tabs__label" for="tab-1">
                Активный
            </label>
            <input class="bk-tabs__input bk-tab-2"
                   id="tab-2"
                   type="radio"
                   name="tab">
            <label class="bk-tabs__label" for="tab-2">
                Старые
            </label>
            <input class="bk-tabs__input bk-tab-3"
                   id="tab-3"
                   type="radio"
                   name="tab">
            <label class="bk-tabs__label" for="tab-3">
                Бланки
            </label>
            <div class="bk-tabs__content bk-tab-content-1">
                @include('admin.pages.passes.client-active')
            </div>
            <div class="bk-tabs__content bk-tab-content-2">
                @include('admin.pages.passes.client-deactive')
            </div>
            <div class="bk-tabs__content bk-tab-content-3">
                @include('admin.pages.passes.blanks')
            </div>
        </div>
    </section>
@endsection