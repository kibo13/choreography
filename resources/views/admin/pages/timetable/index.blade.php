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

        @if(@is_access('timetable_full') && $is_director)
        <form class="my-2 bk-form"
              action="{{ route('admin.timetable.generate') }}"
              method="GET">
            <div class="bk-form__wrapper">
                <div class="bk-grid bk-grid--gtc-150">
                    <select class="form-control" name="month_id" required>
                        <option value="" disabled selected>{{ __('_select.month') }}</option>
                        @foreach($months as $month)
                        <option value="{{ $month['id'] }}" @if($month['id'] < $nowMonthID) disabled @endif>
                            {{ $month['fullname'] }}
                        </option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm btn-primary">
                        {{ __('_action.generate') }}
                    </button>
                </div>
            </div>
        </form>
        @endif

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

        <input type="hidden" id="is_director" value="{{ $is_director }}">
        <div id="timetable-calendar"></div>
    </section>
@endsection
