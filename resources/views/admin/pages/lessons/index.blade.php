@extends('admin.index')
@section('title-admin', __('_section.lessons'))
@section('content-admin')
    <section id="lessons-index" class="overflow-auto">
        <h3>{{ __('_section.lessons') }}</h3>

        <div class="my-2 btn-group">
            @if(@is_access('lesson_full'))
            <a class="btn btn-primary" href="{{ route('admin.lessons.create') }}">
                {{ __('_record.new') }}
            </a>
            @endif
            @if(@is_access('group_read'))
            <a class="btn btn-secondary" href="{{ route('admin.groups.index') }}">
                {{ __('_section.groups') }}
            </a>
            @endif
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
                <th class="w-25 bk-min-w-150">{{ __('_field.name') }}</th>
                <th class="w-25 bk-min-w-150">{{ __('_field.sign') }}</th>
                <th class="w-50 bk-min-w-200 no-sort">{{ __('_field.note') }}</th>
                @if(@is_access('lesson_full'))
                <th class="no-sort">{{ __('_action.this') }}</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($lessons as $index => $lesson)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ $lesson->name }}</td>
                    <td>{{ $lesson->sign }}</td>
                    <td>{{ $lesson->note }}</td>
                    @if(@is_access('lesson_full'))
                    <td>
                        <div class="bk-btn-actions">
                            <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
                               href="{{ route('admin.lessons.edit', $lesson) }}"
                               data-tip="{{ __('_action.edit') }}" ></a>
                            <a class="bk-btn-action bk-btn-action--delete btn btn-danger"
                               href="javascript:void(0)"
                               data-id="{{ $lesson->id }}"
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
