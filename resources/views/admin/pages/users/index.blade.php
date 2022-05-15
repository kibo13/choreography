@extends('admin.index')
@section('title-admin', __('_section.users'))
@section('content-admin')
    <section id="users-index" class="overflow-auto">
        <h3>{{ __('_section.users') }}</h3>

        @if(@is_access('user_full'))
        <div class="my-2 btn-group">
            <a class="btn btn-primary" href="{{ route('admin.users.create') }}">
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
                    <th class="w-25 bk-min-w-150">{{ __('_field.username') }}</th>
                    <th class="w-25 bk-min-w-150">{{ __('_field.role') }}</th>
                    <th class="w-50 bk-min-w-300 no-sort">{{ __('_field.permissions') }}</th>
                    @if(@is_access('user_full'))
                    <th class="no-sort">{{ __('_action.this') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @foreach($users as $index => $user)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ $user->role->name }}</td>
                    <td>
                        <ul class="bk-btn-info">
                            @foreach($sections as $section)
                            <li>
                                @if($user->permissions->where('name', $section->name)->count())
                                <strong>{{ $section->name }}</strong>
                                @endif
                                @foreach($user->permissions as $permission)
                                @if($permission->name == $section->name)
                                {{ @tip($permission->note) }}
                                @endif
                                @endforeach
                            </li>
                            @endforeach
                            {{ $user->permissions->count() ? @fa('fa fa-eye bk-btn-info--fa') : null }}
                        </ul>
                    </td>
                    @if(@is_access('user_full'))
                    <td>
                        <div class="bk-btn-actions">
                            <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
                               href="{{ route('admin.users.edit', $user) }}"
                               data-tip="{{ __('_action.edit') }}" ></a>
                            <a class="bk-btn-action bk-btn-action--delete btn btn-danger"
                               href="javascript:void(0)"
                               data-id="{{ $user->id }}"
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
