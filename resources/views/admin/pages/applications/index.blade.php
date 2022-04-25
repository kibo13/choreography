@extends('admin.index')
@section('title-admin', __('_section.applications'))
@section('content-admin')
    <section id="applications-index" class="overflow-auto">
        <h3>{{ __('_section.applications') }}</h3>

        @if(session()->has('success'))
        <div class="my-2 alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
        @endif

        <div class="my-2 bk-callout">
            <h5>Контроль заявок {{ @tip(@getToday()) }}</h5>
            <hr>
            <ul>
                <li>
                    <strong class="text-muted">Общее количество</strong>
                    {{ @tip($total) }}
                </li>
                <li>
                    <strong class="text-info">{{ __('_state.pending') }}</strong>
                    {{ @tip($pending) }}
                </li>
                <li>
                    <strong class="text-success">{{ __('_state.completed') }}</strong>
                    {{ @tip($complete) }}
                </li>
            </ul>
        </div>

        <table id="is-datatable"
               class="dataTables table table-bordered table-hover table-responsive">
            <thead class="thead-light">
            <tr>
                <th>#</th>
                <th class="w-25 bk-min-w-150">{{ __('_app.id') }}</th>
                <th class="w-25 bk-min-w-150">{{ __('_date.create') }}</th>
                <th class="w-25 bk-min-w-150">{{ __('_app.topic') }}</th>
                <th class="w-25 bk-min-w-150">{{ __('_state.this') }}</th>
                <th class="bk-min-w-150">{{ __('_app.author') }}</th>
                <th class="no-sort">{{ __('_action.this') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($applications as $index => $application)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ $application->num }}</td>
                    <td>{{ @getDMY($application->created_at) }}</td>
                    <td>{{ $application->topic }}</td>
                    <td>{{ @status($application->status) }}</td>
                    <td>{{ @full_fio($application->user_id) }}</td>
                    <td>
                        <div class="bk-btn-actions">
                            <a class="bk-btn-action bk-btn-action--info btn btn-info"
                               href="{{ route('admin.applications.show', $application) }}"
                               data-tip="{{ __('_action.show') }}" ></a>
                            @if(@is_access('app_full') && $application->status == 0)
                            <a class="bk-btn-action bk-btn-action--check btn btn-success"
                               href="javascript:void(0)"
                               data-id="{{ $application->id }}"
                               data-toggle="modal"
                               data-target="#bk-confirm-modal"
                               data-tip="{{ __('_action.execute') }}"></a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection
