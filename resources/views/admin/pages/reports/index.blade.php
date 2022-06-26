@extends('admin.index')
@section('title-admin', __('_section.reports'))
@section('content-admin')
    <section id="reports-index" class="overflow-auto">
        <h3>Выходные отчеты</h3>

        @if(session()->has('warning'))
        <div class="my-2 alert alert-warning" role="alert">
            {{ session()->get('warning') }}
        </div>
        @endif

        <select class="form-control" id="report-menu">
            <option disabled selected>
                {{ __('_select.report') }}
            </option>
            @foreach($reports as $report)
            <option value="{{ $report['id'] }}">
                @if($report['id'] == 7)
                    @if(Auth::user()->role_id == 3)
                    {{ $report['name'] . 'по сформированной группе' }}
                    @else
                    {{ $report['name'] . 'по сформированным группам' }}
                    @endif
                @elseif($report['id'] == 8)
                    @if(Auth::user()->role_id == 3)
                    {{ $report['name'] . 'руководителю клубного формирования' }}
                    @else
                    {{ $report['name'] . 'руководителям клубных формировании' }}
                    @endif
                @else
                    {{ $report['name'] }}
                @endif
            </option>
            @endforeach
        </select>

        @include('admin.pages.reports.privileges')
        @include('admin.pages.reports.passes-nodiscount')
        @include('admin.pages.reports.passes-discount')
        @include('admin.pages.reports.amounts')
        @include('admin.pages.reports.ages')
        @include('admin.pages.reports.awards')
        @include('admin.pages.reports.collectives')
        @include('admin.pages.reports.teachers')
        @include('admin.pages.reports.sales')
        @include('admin.pages.reports.cashback')
        @include('admin.pages.reports.remains')
        @include('admin.pages.reports.misses')
        @include('admin.pages.reports.workloads')
        @include('admin.pages.reports.rooms')
        @include('admin.pages.reports.schedule')
    </section>
@endsection
