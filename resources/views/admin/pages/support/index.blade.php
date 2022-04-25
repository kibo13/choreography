@extends('admin.index')
@section('title-admin', __('_section.support'))
@section('content-admin')
    <section id="support-index" class="overflow-auto">
        <h3>{{ __('_section.support') }}</h3>

        @if(@is_access('help_full'))
        <div class="my-2 btn-group">
            <a class="btn btn-primary" href="{{ route('admin.support.create') }}">
                {{ __('_record.new') }}
            </a>
        </div>
        @endif

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
                    <th class="w-25 bk-min-w-200">{{ __('_app.topic') }}</th>
                    <th class="w-25 bk-min-w-150">{{ __('_date.create') }}</th>
                    <th class="w-25 bk-min-w-150">{{ __('_app.id') }}</th>
                    <th class="w-25 bk-min-w-150">{{ __('_state.this') }}</th>
                    <th class="no-sort">{{ __('_action.this') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach($applications as $index => $application)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ $application->topic }}</td>
                    <td>{{ @getDMY($application->created_at) }}</td>
                    <td>{{ $application->num }}</td>
                    <td>{{ @status($application->status) }}</td>
                    <td>
                        <div class="bk-btn-actions">
                            <a class="bk-btn-action bk-btn-action--info btn btn-info"
                               href="{{ route('admin.support.show', $application) }}"
                               data-tip="{{ __('_action.show') }}" ></a>
                            @if(@is_access('help_full') && $application->status == 0)
                            <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
                               href="{{ route('admin.support.edit', $application) }}"
                               data-tip="{{ __('_action.edit') }}"></a>
                            <a class="bk-btn-action bk-btn-action--delete btn btn-danger"
                               href="javascript:void(0)"
                               data-id="{{ $application->id }}"
                               data-toggle="modal"
                               data-target="#bk-delete-modal"
                               data-tip="{{ __('_action.delete') }}"></a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection
