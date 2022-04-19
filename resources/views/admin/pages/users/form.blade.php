@extends('admin.index')
@section('title-admin', __('section.users'))
@section('content-admin')
    <section id="users-form" class="bk-section">
        <h3>{{ @form_title($user) }}</h3>
        <form class="bk-form"
              action="{{ @is_update($user, 'admin.users') }}"
              method="POST"
              data-info="{{ __('base.data') }}">
            <div class="bk-form__wrapper">
                @csrf
                @isset($user) @method('PUT') @endisset

                <div class="bk-form__field">
                    <label class="bk-form__label" for="first_name">
                        {{ __('users.first_name') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 @error('first_name') bk-border-red @enderror"
                           id="first_name"
                           type="text"
                           name="first_name"
                           value="{{ isset($user) ? $user->first_name : null }}"
                           placeholder="Например: Карина"
                           autocomplete="off"/>
                    @error('first_name')
                    <div class="bk-validation">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="bk-form__field">
                    <label class="bk-form__label" for="last_name">
                        {{ __('users.last_name') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 @error('last_name') bk-border-red @enderror"
                           id="last_name"
                           type="text"
                           name="last_name"
                           value="{{ isset($user) ? $user->last_name : null }}"
                           placeholder="Например: Жолмурзаева"
                           autocomplete="off"/>
                    @error('last_name')
                    <div class="bk-validation">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="bk-form__field">
                    <label class="bk-form__label" for="username">
                        {{ __('users.nickname') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 @error('username') bk-border-red @enderror"
                           id="username"
                           type="text"
                           name="username"
                           value="{{ isset($user) ? $user->username : null }}"
                           placeholder="Введите логин"
                           autocomplete="off"/>
                    @error('username')
                    <div class="bk-validation">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="bk-form__field">
                    <label class="bk-form__label" for="">
                        {{ __('users.password') }}
                        {{ @mandatory() }}
                        {{ @tip('мин.длина пароля 8 символов') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 @error('password') bk-border-red @enderror"
                           type="password"
                           name="password"
                           placeholder="Придумайте пароль"
                           autocomplete="off"/>
                    <input class="bk-form__input bk-max-w-300 @error('password') bk-border-red @enderror"
                           type="password"
                           name="password_confirmation"
                           placeholder="Повторите пароль"
                           autocomplete="off"/>
                    @error('password')
                    <div class="bk-validation">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="bk-form__field">
                    <label class="bk-form__label" for="role">
                        {{ __('users.role') }} {{ @mandatory() }}
                    </label>
                    <select class="bk-form__select bk-max-w-300 @error('role_id') bk-border-red @enderror"
                            name="role_id">
                        <option disabled selected>{{ __('select.role') }}</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}"
                                data-slug="{{ $role->slug }}"
                                @isset($user)
                                @if($user->role_id == $role->id)
                                selected
                                @endif
                                @endisset>
                            {{ $role->name }}
                        </option>
                        @endforeach
                    </select>
                    @error('role_id')
                    <div class="bk-validation">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

{{--                <div class="bk-form__field">--}}
{{--                    <label class="bk-form__label" for="permissions">--}}
{{--                        {{ __('users.permissions') }} {{ @mandatory() }}--}}
{{--                    </label>--}}
{{--                    <input class="bk-form__input bk-max-w-300"--}}
{{--                           id="permissions"--}}
{{--                           type="text"--}}
{{--                           name="permissions"--}}
{{--                           autocomplete="off"/>--}}
{{--                </div>--}}

                <div class="mt-1 mb-0 form-group">
                    <button class="btn btn-outline-success">
                        {{ __('crud.save') }}
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.users.index') }}">
                        {{ __('crud.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
