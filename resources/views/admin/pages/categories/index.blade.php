@extends('admin.index')
@section('title-admin', __('_section.categories'))
@section('content-admin')
    <section id="categories-index" class="overflow-auto">
        <h3>{{ __('_section.categories') }}</h3>

        <div class="my-2 btn-group">
            @if(@is_access('cat_full'))
            <a class="btn btn-primary" href="{{ route('admin.categories.create') }}">
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
                    <th class="w-75 bk-min-w-200 no-sort">{{ __('_field.note') }}</th>
                    @if(@is_access('cat_full'))
                    <th class="no-sort">{{ __('_action.this') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @foreach($categories as $index => $category)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->note }}</td>
                    @if(@is_access('cat_full'))
                    <td>
                        <div class="bk-btn-actions">
                            <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
                               href="{{ route('admin.categories.edit', $category) }}"
                               data-tip="{{ __('_action.edit') }}" ></a>
                            <a class="bk-btn-action bk-btn-action--delete btn btn-danger"
                               href="javascript:void(0)"
                               data-id="{{ $category->id }}"
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
