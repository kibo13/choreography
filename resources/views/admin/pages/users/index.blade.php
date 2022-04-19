@extends('admin.index')
@section('title-admin', __('section.users'))
@section('content-admin')
    <section id="users-index" class="overflow-auto">
        <h3>{{ __('section.users') }}</h3>

        <div class="my-2 bk-btn-group">
            <a class="btn btn-primary" href="{{ route('admin.users.create') }}">
                {{ __('crud.new_record') }}
            </a>
        </div>

        <table id="is-datatable"
               class="dataTables table table-bordered table-hover table-responsive">
            <thead class="thead-light">
            <tr>
                <th>#</th>
                <th class="bk-min-w-150">{{ __('users.username') }}</th>
                <th class="bk-min-w-150">{{ __('users.role') }}</th>
                <th class="bk-min-w-200 w-100 no-sort">{{ __('users.permissions') }}</th>
                <th class="no-sort">{{ __('crud.action') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $key => $user)
                <tr>
                    <td>{{ $key+=1 }}</td>
                    <td>{{ $user->first_name . ' ' . $user->last_name }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td>{{ null }}</td>
                    <td>
                        <div class="bk-btn-actions">
                            <a class="bk-btn-actions__link bk-btn-actions__link--info btn btn-info"
                               href="{{ route('admin.users.show', $user) }}"
                               data-tip="{{ __('crud.info') }}" ></a>
                            <a class="bk-btn-actions__link bk-btn-actions__link--edit btn btn-warning"
                               href="{{ route('admin.users.edit', $user) }}"
                               data-tip="{{ __('crud.edit') }}" ></a>
                            <a class="bk-btn-actions__link bk-btn-actions__link--delete btn btn-danger"
                               href="javascript:void(0)"
                               data-id="{{ $user->id }}"
                               data-table-name="user"
                               data-toggle="modal"
                               data-target="#bk-delete-modal"
                               data-tip="{{ __('crud.delete') }}" ></a>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection
