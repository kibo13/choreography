@extends('admin.index')
@section('title-admin', __('_section.titles'))
@section('content-admin')
    <section id="titles-index" class="overflow-auto">
        <h3>{{ __('_section.titles') }}</h3>

        @if(@is_access('name_full') || @is_access('group_read'))
        <div class="my-2 btn-group">
            @if(@is_access('name_full'))
            <a class="btn btn-primary" href="{{ route('admin.titles.create') }}">
                {{ __('_record.new') }}
            </a>
            @endif
            @if(@is_access('group_read'))
            <a class="btn btn-secondary" href="{{ route('admin.groups.index') }}">
                {{ __('_section.groups') }}
            </a>
            @endif
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
                    <th class="w-25 bk-min-w-150">{{ __('_field.study') }}</th>
                    <th class="w-25 bk-min-w-200">{{ __('_field.specialty') }}</th>
                    <th class="w-25 bk-min-w-200 no-sort">{{ __('_field.note') }}</th>
                    @if(@is_access('name_full'))
                    <th class="no-sort">{{ __('_action.this') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @foreach($titles as $index => $title)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ $title->name }}</td>
                    <td>{{ $title->is_paid == 1 ? __('_field.paid') : __('_field.free') }}</td>
                    <td>{{ $title->specialty->name }}</td>
                    <td>
                        <div class="bk-btn-info">
                            {{ $title->note }}
                            <button class="bk-btn-info--down"></button>
                        </div>
                    </td>
                    @if(@is_access('name_full'))
                    <td>
                        <div class="bk-btn-actions">
                            <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
                               href="{{ route('admin.titles.edit', $title) }}"
                               data-tip="{{ __('_action.edit') }}" ></a>
                            <a class="bk-btn-action bk-btn-action--delete btn btn-danger"
                               href="javascript:void(0)"
                               data-id="{{ $title->id }}"
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
