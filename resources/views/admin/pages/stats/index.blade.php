@extends('admin.index')
@section('title-admin', __('_section.stats'))
@section('content-admin')
    <section id="stats-index" class="overflow-auto">
        <h3>{{ __('_section.stats') }}</h3>

        <form class="my-2 bk-form" action="{{ route('admin.stats.index') }}" method="GET">
            <div class="bk-form__wrapper">
                <div class="bk-grid bk-grid--gtc-150">
                    <input class="form-control"
                           id="stat-from"
                           type="date"
                           name="from"
                           value="{{ request()->from ? request()->from : null }}"
                           required>
                    <input class="form-control"
                           id="stat-till"
                           type="date"
                           name="till"
                           value="{{ request()->till ? request()->till : null }}"
                           required>
                    <button class="btn btn-sm btn-primary" id="stat-run">
                        {{ __('_action.generate') }}
                    </button>
                </div>
            </div>
        </form>

        <div class="bk-tabs">
            <input class="bk-tabs__input bk-tab-1"
                   id="tab-1"
                   type="radio"
                   name="tab"
                   checked>
            <label class="bk-tabs__label" for="tab-1">
                Посещения
            </label>
            <input class="bk-tabs__input bk-tab-2"
                   id="tab-2"
                   type="radio"
                   name="tab">
            <label class="bk-tabs__label" for="tab-2">
                Продажи
            </label>
            <div class="bk-tabs__content bk-tab-content-1">
                @include('admin.pages.stats.visits')
            </div>
            <div class="bk-tabs__content bk-tab-content-2">
                @include('admin.pages.stats.sales')
            </div>
        </div>
    </section>
@endsection
