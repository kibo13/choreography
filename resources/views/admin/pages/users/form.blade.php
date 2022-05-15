@extends('admin.index')
@section('title-admin', __('_section.users'))
@section('content-admin')
    <section id="users-form" class="overflow-auto">
        <h3>{{ @form_title($user) }}</h3>
        <form class="bk-form"
              action="{{ @is_update($user, 'admin.users') }}"
              method="POST">
            <div class="bk-form__wrapper">
                @csrf
                @isset($user) @method('PUT') @endisset

                <!-- username -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="username">
                        {{ __('_field.username') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="username"
                           type="text"
                           name="username"
                           value="{{ isset($user) ? $user->username : null }}"
                           required
                           autocomplete="off"/>
                </div>

                <!-- role -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="role">
                        {{ __('_field.role') }} {{ @mandatory() }}
                    </label>
                    <select class="bk-form__select bk-max-w-300" id="role" name="role_id" required>
                        <option value="" disabled selected>{{ __('_select.role') }}</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}"
                                data-slug="{{ $role->slug }}"
                                @isset($user) @if($user->role_id == $role->id)
                                selected
                                @endif @endisset>
                            {{ $role->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- permissions -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="">
                        {{ __('_field.permissions') }} {{ @mandatory() }}
                    </label>
                    <table class="dataTables table table-bordered table-hover table-responsive">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th class="w-50 text-left bk-min-w-200">{{ __('_section.sections') }}</th>
                                <th class="w-25 text-center bk-min-w-150">{{ __('_action.looking') }}</th>
                                <th class="w-25 text-center bk-min-w-150">{{ __('_action.editing') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($sections as $index => $section)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ $section->name }}</td>
                                @if($permissions->where('name', $section->name)->count() == 2)
                                @foreach($permissions as $permission)
                                @if($permission->name == $section->name)
                                <td class="text-center">
                                    <input class="bk-form__checkbox {{$permission->slug}}"
                                           name="permissions[]"
                                           type="checkbox"
                                           value="{{ $permission->id }}"
                                           @isset($user) @if($user->permissions->where('id', $permission->id)->count())
                                           checked="checked"
                                           @endif @endisset>
                                </td>
                                @endif
                                @endforeach
                                @else
                                @foreach($permissions as $permission)
                                @if($permission->name == $section->name)
                                <td class="text-center">
                                    <input class="bk-form__checkbox {{$permission->slug}}"
                                           name="permissions[]"
                                           type="checkbox"
                                           value="{{ $permission->id }}"
                                           @isset($user) @if($user->permissions->where('id', $permission->id)->count())
                                           checked="checked"
                                           @endif @endisset>
                                </td>
                                <td class="text-center font-weight-bold">-</td>
                                @endif
                                @endforeach
                                @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-1 mb-0 form-group">
                    <button class="btn btn-outline-success">
                        {{ __('_action.save') }}
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.users.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
