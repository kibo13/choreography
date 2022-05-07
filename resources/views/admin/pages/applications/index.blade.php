@extends('admin.index')
@section('title-admin', __('_section.applications'))
@section('content-admin')
    <section id="applications-index" class="overflow-auto">
        <h3>{{ __('_section.applications') }}</h3>

        <div class="my-2 bk-callout">
            <h5>Контроль заявок {{ @tip(@getToday()) }}</h5>
            <hr>
            <ul>
                <li>
                    <strong class="text-muted">Общее количество</strong>
                    {{ @tip($total) }}
                </li>
                <li>
                    <strong class="text-info">{{ __('_action.pending') }}</strong>
                    {{ @tip($pending) }}
                </li>
                <li>
                    <strong class="text-success">{{ __('_action.completed') }}</strong>
                    {{ @tip($complete) }}
                </li>
            </ul>
        </div>

        @if(session()->has('success'))
        <div class="my-2 alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
        @endif

        <table id="is-datatable"
               class="dataTables table table-bordered table-hover table-responsive">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th class="w-25 bk-min-w-150">{{ __('_field.num') }}</th>
                    <th class="w-25 bk-min-w-150">{{ __('_field.created_at') }}</th>
                    <th class="w-25 bk-min-w-150">{{ __('_field.author') }}</th>
                    <th class="w-25 bk-min-w-150">{{ __('_field.executor') }}</th>
                    <th class="bk-min-w-150">{{ __('_field.status') }}</th>
                    <th class="no-sort">{{ __('_action.this') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach($applications as $index => $app)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ $app->num }}</td>
                    <td>{{ @getDMY($app->created_at) }}</td>
                    <td>{{ @full_fio('member', $app->member_id) }}</td>
                    <td>{{ $app->status ? @full_fio('worker', $app->worker_id) : '-' }}</td>
                    <td>{{ @status($app->status) }}</td>
                    <td>
                        <div class="bk-btn-actions">
                            <a class="bk-btn-action bk-btn-action--info btn btn-info"
                               href="{{ route('admin.applications.show', $app) }}"
                               data-tip="{{ __('_action.look') }}" ></a>
                            @if(@is_access('app_full') && $app->status == 0 && Auth::user()->role_id == 3)
                            <a class="bk-btn-action bk-btn-action--check btn btn-success"
                               href="javascript:void(0)"
                               data-id="{{ $app->id }}"
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
