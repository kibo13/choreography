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
                <li>
                    <strong class="text-danger">{{ __('_action.declined') }}</strong>
                    {{ @tip($decline) }}
                </li>
            </ul>
        </div>

        @if(session()->has('success'))
        <div class="my-2 alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
        @endif

        <table id="is-datatable" class="dataTables table table-bordered table-hover table-responsive">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th class="w-25 bk-min-w-200">{{ __('_field.topic') }}</th>
                    <th class="w-25 bk-min-w-150">{{ __('_field.num') }}</th>
                    <th class="w-25 bk-min-w-150">{{ __('_field.created_at') }}</th>
                    <th class="w-25 bk-min-w-150">{{ __('_field.author') }}</th>
                    <th class="w-00 bk-min-w-150">{{ __('_field.executor') }}</th>
                    <th class="bk-min-w-150">{{ __('_field.status') }}</th>
                    @if(@is_access('app_full'))
                    <th class="no-sort">{{ __('_action.this') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $index => $app)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ $tops[$app->topic] }}</td>
                    <td>{{ $app->num }}</td>
                    <td>{{ @getDMY($app->created_at) }}</td>
                    <td>{{ @full_fio('member', $app->member_id) }}</td>
                    <td>{{ $app->status ? @full_fio('worker', $app->worker_id) : '-' }}</td>
                    <td>
                        @if($app->status == 0)
                        <strong class="text-info">{{ $states[$app->status] }}</strong>
                        @elseif($app->status == 1)
                        <strong class="text-success">{{ $states[$app->status] }}</strong>
                        @else
                        <strong class="text-danger">{{ $states[$app->status] }}</strong>
                        @endif
                    </td>
                    @if(@is_access('app_full'))
                    <td>
                        <div class="bk-btn-actions">
                            <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
                               href="{{ route('admin.applications.edit', $app) }}"
                               data-tip="{{ __('_action.edit') }}" ></a>
                        </div>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection
