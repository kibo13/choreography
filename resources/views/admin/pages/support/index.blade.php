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
                    <th class="w-25 bk-min-w-200">{{ __('_field.topic') }}</th>
                    <th class="w-25 bk-min-w-150">{{ __('_field.created_at') }}</th>
                    <th class="w-25 bk-min-w-150">{{ __('_field.num') }}</th>
                    <th class="w-25 bk-min-w-150 no-sort">{{ __('_field.comment') }}</th>
                    <th class="w-00 bk-min-w-150">{{ __('_field.status') }}</th>
                    @if(@is_access('help_full'))
                    <th class="no-sort">{{ __('_action.this') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @foreach($applications as $index => $application)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ $tops[$application->topic] }}</td>
                    <td>{{ @getDMY($application->created_at) }}</td>
                    <td>{{ $application->num }}</td>
                    <td>
                        @if($application->note)
                        <div class="bk-btn-info" title="{{ $application->note }}">
                            {{ $application->note }}
                        </div>
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        @if($application->status == 0)
                        <strong class="text-info">{{ $states[$application->status] }}</strong>
                        @elseif($application->status == 1)
                        <strong class="text-success">{{ $states[$application->status] }}</strong>
                        @else
                        <strong class="text-danger">{{ $states[$application->status] }}</strong>
                        @endif
                    </td>
                    @if(@is_access('help_full'))
                    <td>
                        <div class="bk-btn-actions">
                            @if($application->status == 0)
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
                            @if($application->status == 1 && $application->member->form_study == 1)
                            <a class="bk-btn-action bk-btn-action--bill btn btn-primary"
                               href="{{ asset('orders/' . $application->voucher) }}"
                               title="Расходный кассовый ордер"></a>
                            @endif
                        </div>
                    </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection
