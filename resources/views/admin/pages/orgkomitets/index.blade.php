@extends('admin.index')
@section('title-admin', __('_section.orgkomitets'))
@section('content-admin')
    <section id="orgkomitets-index" class="overflow-auto">
        <h3>{{ __('_section.orgkomitets') }}</h3>

        @if(@is_access('orgkomitet_full'))
        <div class="my-2 btn-group">
            <a class="btn btn-primary" href="{{ route('admin.orgkomitets.create') }}">
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
                    <th class="bk-min-w-250 w-25">{{ __('_field.orgkomitet') }}</th>
                    <th class="bk-min-w-150 w-25 no-sort">{{ __('_field.office_hours') }}</th>
                    <th class="bk-min-w-150 w-25 no-sort">{{ __('_field.phone') }}</th>
                    <th class="bk-min-w-150 w-25 no-sort">{{ __('_field.email') }}</th>
                    <th class="bk-min-w-150 no-sort">{{ __('_field.website') }}</th>
                    @if(@is_access('orgkomitet_full'))
                    <th class=" text-center no-sort">{{ __('_action.this') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @foreach($orgkomitets as $index => $orgkomitet)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ $orgkomitet->name }}</td>
                    <td>
                        {{ getHI($orgkomitet->from) }}
                        {{ '-' }}
                        {{ getHI($orgkomitet->till) }}
                    </td>
                    <td>
                        <a class="text-primary"
                           href="tel:{{ str_replace(" ", "", $orgkomitet->phone) }}">
                            {{ $orgkomitet->phone }}
                        </a>
                    </td>
                    <td>
                        <a class="text-primary"
                           href="mailto:{{ $orgkomitet->email }}">
                            {{ $orgkomitet->email }}
                        </a>
                    </td>
                    <td>
                        @if($orgkomitet->site)
                        <a class="text-primary"
                           href="{{ $orgkomitet->site }}"
                           target="_blank">
                            {{ __('_action.look') }}
                        </a>
                        @else
                        <span class="text-info">
                            {{ __('_record.no') }}
                        </span>
                        @endif
                    </td>
                    @if(@is_access('orgkomitet_full'))
                    <td>
                        <div class="bk-btn-actions">
                            <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
                               href="{{ route('admin.orgkomitets.edit', $orgkomitet) }}"
                               data-tip="{{ __('_action.edit') }}" ></a>
                            <a class="bk-btn-action bk-btn-action--delete btn btn-danger"
                               href="javascript:void(0)"
                               data-id="{{ $orgkomitet->id }}"
                               data-toggle="modal"
                               data-target="#bk-delete-modal"
                               data-tip="{{ __('_action.delete') }}" ></a>
                        </div>
                    </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection
