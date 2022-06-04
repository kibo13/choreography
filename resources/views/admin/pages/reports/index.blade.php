@extends('admin.index')
@section('title-admin', __('_section.reports'))
@section('content-admin')
    <section id="reports-index" class="overflow-auto">
        <h3>{{ __('_section.reports') }}</h3>

        <div class="my-2 bk-callout">
            <h5 class="m-0">
                Выходные отчеты
            </h5>
        </div>

        @if(session()->has('warning'))
        <div class="my-2 alert alert-warning" role="alert">
            {{ session()->get('warning') }}
        </div>
        @endif

        <div class="bk-form">
            <div class="bk-form__wrapper">
                @foreach($reports as $report)
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ $report['name'] }}
                    </label>
                    <div class="bk-form__text">
                        <a class="text-primary"
                           href="{{ route('admin.reports.' . $report['href'], $report['type']) }}">
                            {{ __('_action.print') }}
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
