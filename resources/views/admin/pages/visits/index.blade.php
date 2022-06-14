@extends('admin.index')
@section('title-admin', __('_section.visits'))
@section('content-admin')
    <section id="visits-index" class="overflow-auto">
        <h3>{{ __('_section.visits') }}</h3>

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

        <ul class="bk-visits-list">
            @foreach(@getGroupsByRole() as $team)
            <li class="bk-visits-list__item">
                <a class="bk-visits-list__link {{ $team->id == $group->id ? 'bk-visits--active' : '' }}"
                   href="{{ route('admin.visits.index', $team) }}">
                    <strong>{{ $team->title->name }}</strong>
                    @if($team->category_id != 4)
                    <span>{{ $team->category->name }}</span>
                    @endif
                </a>
            </li>
            @endforeach
        </ul>

        <form class="my-2 bk-form"
              action="{{ route('admin.visits.index', $group) }}"
              method="GET">
            <div class="bk-form__wrapper">
                <div class="bk-grid bk-grid--gtc-150">
                    <input type="hidden" name="period" value="1">
                    <select class="form-control" name="month_id" required>
                        <option value="" disabled selected>{{ __('_select.month') }}</option>
                        @foreach($months as $month)
                        <option value="{{ $month['id'] }}">
                            {{ $month['fullname'] }}
                        </option>
                        @endforeach
                    </select>
                    <select class="form-control" name="year" required>
                        <option value="" disabled selected>{{ __('_select.year') }}</option>
                        @foreach(@getYearsFromTimetables() as $field)
                        <option value="{{ $field->year }}">
                            {{ $field->year }}
                        </option>
                        @endforeach
                    </select>
                    <button class="btn btn-primary">
                        {{ __('_action.run') }}
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
                Журнал занятий коллектива
            </label>
            <input class="bk-tabs__input bk-tab-2"
                   id="tab-2"
                   type="radio"
                   name="tab">
            <label class="bk-tabs__label" for="tab-2">
                Журнал учёта посещений
            </label>
            <input class="bk-tabs__input bk-tab-3"
                   id="tab-3"
                   type="radio"
                   name="tab">
            <label class="bk-tabs__label" for="tab-3">
                Журнал учёта пропусков
            </label>
            <div class="bk-tabs__content bk-tab-content-1">
                @include('admin.pages.visits.lessons')
            </div>
            <div class="bk-tabs__content bk-tab-content-2">
                @include('admin.pages.visits.attendance')
            </div>
            <div class="bk-tabs__content bk-tab-content-3">
                @include('admin.pages.visits.misses')
            </div>
        </div>
    </section>
@endsection
