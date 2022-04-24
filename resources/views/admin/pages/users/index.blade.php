@extends('admin.index')
@section('title-admin', __('section.users'))
@section('content-admin')
    <section id="users-index" class="overflow-auto">
        <h3>{{ __('section.users') }}</h3>

        @if(@is_access('user_full'))
        <div class="my-2 btn-group">
            <a class="btn btn-primary" href="{{ route('admin.users.create') }}">
                {{ __('record.new') }}
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
                <th class="bk-min-w-150 w-25">{{ __('person.fio') }}</th>
                <th class="bk-min-w-150 w-25">{{ __('person.nickname') }}</th>
                <th class="bk-min-w-150 w-25">{{ __('person.role') }}</th>
                <th class="bk-min-w-300 w-25 no-sort">{{ __('person.permissions') }}</th>
                @if(@is_access('user_full'))
                <th class="no-sort">{{ __('base.action') }}</th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($users as $index => $user)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ @full_fio($user->id) }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td>
                        <ul class="bk-btn-info">
                            @foreach($sections as $section)
                            <li>
                                @if($user->permissions->where('name', $section)->count())
                                <strong>{{ $section }}</strong>
                                @endif
                                @foreach($user->permissions as $permission)
                                @if($permission->name == $section)
                                {{ @tip($permission->desc) }}
                                @endif
                                @endforeach
                            </li>
                            @endforeach
                            <button class="bk-btn-info--down"></button>
                        </ul>
                    </td>
                    @if(@is_access('user_full'))
                    <td>
                        <div class="bk-btn-actions">
                            <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
                               href="{{ route('admin.users.edit', $user) }}"
                               data-tip="{{ __('operation.edit') }}" ></a>
                            <a class="bk-btn-action bk-btn-action--delete btn btn-danger"
                               href="javascript:void(0)"
                               data-id="{{ $user->id }}"
                               data-toggle="modal"
                               data-target="#bk-delete-modal"
                               data-tip="{{ __('operation.delete') }}" ></a>
                        </div>
                    </td>
                    @endif
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection
