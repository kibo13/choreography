@extends('admin.index')
@section('title-admin', __('_section.timetable'))
@section('content-admin')
    <section id="timetable-index" class="overflow-auto">
        <h3>{{ __('_section.timetable') }}</h3>

        <div class="mt-1 mb-2 bk-callout">
            <h5>Цветовые обозначения групп</h5>
            <hr>
            <div class="bk-grid bk-grid--gtc-150">
            @foreach($titles as $title)
                <div class="bk-grid bk-grid--gtr-30">
                    <h6>{{ $title->name }}</h6>
                    @foreach($title->groups as $group)
                    <div class="py-1 px-2 text-white rounded" style="background: {{ $group->color }};">
                        {{ $group->category->name }}
                    </div>
                    @endforeach
                </div>
            @endforeach
            </div>
        </div>

        @if($is_director)
        <div class="bk-tabs">
            <input class="bk-tabs__input bk-tab-1"
                   id="tab-1"
                   type="radio"
                   name="tab"
                   checked>
            <label class="bk-tabs__label" for="tab-1">
                Расписание
            </label>
            <input class="bk-tabs__input bk-tab-2"
                   id="tab-2"
                   type="radio"
                   name="tab">
            <label class="bk-tabs__label" for="tab-2">
                Замены
            </label>
            <div class="bk-tabs__content bk-tab-content-1">
                @include('admin.pages.timetable.schedule')
            </div>
            <div class="bk-tabs__content bk-tab-content-2">
                @include('admin.pages.timetable.replace')
            </div>
        </div>
        @else
        @include('admin.pages.timetable.schedule')
        @endif
    </section>
@endsection
