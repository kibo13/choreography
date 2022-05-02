@extends('admin.index')
@section('title-admin', __('_section.specialties'))
@section('content-admin')
    <section id="specialties-index" class="overflow-auto">
        <h3>{{ __('_section.specialties') }}</h3>

        @if(@is_access('specialty_full'))
        <div class="my-2 btn-group">
            <a class="btn btn-primary" href="{{ route('admin.specialties.create') }}">
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
                    <th class="w-25 bk-min-w-150">{{ __('_field.name') }}</th>
                    <th class="w-25 bk-min-w-150">{{ __('_field.sign') }}</th>
                    <th class="w-50 bk-min-w-200 no-sort">{{ __('_field.note') }}</th>
                    @if(@is_access('specialty_full'))
                    <th class="no-sort">{{ __('_action.this') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @foreach($specialties as $index => $specialty)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ $specialty->name }}</td>
                    <td>{{ $specialty->sign }}</td>
                    <td>{{ $specialty->note }}</td>
                    @if(@is_access('specialty_full'))
                    <td>
                        <div class="bk-btn-actions">
                            <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
                               href="{{ route('admin.specialties.edit', $specialty) }}"
                               data-tip="{{ __('_action.edit') }}" ></a>
                            <a class="bk-btn-action bk-btn-action--delete btn btn-danger"
                               href="javascript:void(0)"
                               data-id="{{ $specialty->id }}"
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
