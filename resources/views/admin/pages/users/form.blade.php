@extends('admin.index')
@section('title-admin', __('_section.users'))
@section('content-admin')
    <section id="users-form" class="overflow-auto is-validation">
        <h3>{{ @form_title($user) }}</h3>
        <form class="bk-form"
              action="{{ @is_update($user, 'admin.users') }}"
              method="POST">
            <div class="bk-form__wrapper">
                @csrf
                @isset($user) @method('PUT') @endisset

                <!-- last_name -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="last_name">
                        {{ __('_person.last_name') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 is-string"
                           id="last_name"
                           type="text"
                           name="last_name"
                           value="{{ isset($user) ? $user->last_name : null }}"
                           placeholder="Например: Жолмурзаева"
                           required
                           autocomplete="off"/>
                </div>

                <!-- first_name -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="first_name">
                        {{ __('_person.first_name') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 is-string"
                           id="first_name"
                           type="text"
                           name="first_name"
                           value="{{ isset($user) ? $user->first_name : null }}"
                           placeholder="Например: Карина"
                           required
                           autocomplete="off"/>
                </div>

                <!-- middle_name -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="middle_name">
                        {{ __('_person.middle_name') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 is-string"
                           id="middle_name"
                           type="text"
                           name="middle_name"
                           value="{{ isset($user) ? $user->middle_name : null }}"
                           autocomplete="off"/>
                </div>

                <!-- birthday -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="birthday">
                        {{ __('_person.birthday') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="birthday"
                           type="date"
                           name="birthday"
                           value="{{ isset($user) ? $user->birthday : null }}"
                           required/>
                </div>

                <!-- phone -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="phone">
                        {{ __('_person.phone') }}
                        {{ @mandatory() }}
                        {{ @tip('+7 776 123 45 67') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 is-phone"
                           id="phone"
                           type="tel"
                           name="phone"
                           value="{{ isset($user) ? $user->phone : null }}"
                           pattern="[+]7 [0-9]{3} [0-9]{3} [0-9]{2} [0-9]{2}"
                           maxlength="16"
                           required
                           autocomplete="off"/>
                </div>

                <!-- email -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="email">
                        {{ __('_person.email') }}
                        {{ @tip('example@dance.ru') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="email"
                           type="email"
                           name="email"
                           value="{{ isset($user) ? $user->email : null }}"
                           autocomplete="off"/>
                </div>

                <!-- address_fact -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="address_fact">
                        {{ __('_person.address_fact') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="address_fact"
                           type="text"
                           name="address_fact"
                           value="{{ isset($user) ? $user->address_fact : null }}"/>
                </div>

                <!-- role -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="role">
                        {{ __('_person.role') }} {{ @mandatory() }}
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
                        {{ __('_person.permissions') }} {{ @mandatory() }}
                    </label>
                    <table class="dataTables table table-bordered table-hover table-responsive">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th class="w-50 text-left bk-min-w-200">{{ __('_section.this') }}</th>
                                <th class="w-25 text-center bk-min-w-150">{{ __('_action.looking') }}</th>
                                <th class="w-25 text-center bk-min-w-150">{{ __('_action.editing') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($sections as $index => $section)
                            <tr>
                                <th>{{ ++$index }}</th>
                                <th>{{ $section }}</th>
                                @if($permissions->where('name', $section)->count() == 2)
                                @foreach($permissions as $permission)
                                @if($permission->name == $section)
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
                                @if($permission->name == $section)
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
