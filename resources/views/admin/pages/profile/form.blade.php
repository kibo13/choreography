@extends('admin.index')
@section('title-admin', __('section.profile'))
@section('content-admin')
    <section id="profile-form" class="overflow-auto">
        <h3>{{ __('crud.edit_profile') }}</h3>

        @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
        @endif

        <form class="bk-form"
              action="{{ route('admin.profile.update', $user) }}"
              method="POST"
              data-info="{{ __('base.data') }}">
            <div class="bk-form__wrapper">
                @csrf
                @method('PUT')

                <div class="bk-form__field">
                    <label class="bk-form__label" for="first_name">
                        {{ __('users.first_name') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="first_name"
                           type="text"
                           name="first_name"
                           value="{{ isset($user) ? $user->first_name : null }}"
                           required
                           autocomplete="off"/>
                </div>

                <div class="bk-form__field">
                    <label class="bk-form__label" for="last_name">
                        {{ __('users.last_name') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="last_name"
                           type="text"
                           name="last_name"
                           value="{{ isset($user) ? $user->last_name : null }}"
                           required
                           autocomplete="off"/>
                </div>

                <div class="bk-form__field">
                    <label class="bk-form__label" for="middle_name">
                        {{ __('users.middle_name') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="middle_name"
                           type="text"
                           name="middle_name"
                           value="{{ isset($user) ? $user->middle_name : null }}"
                           autocomplete="off"/>
                </div>

                <div class="bk-form__field">
                    <label class="bk-form__label" for="birthday">
                        {{ __('users.birthday') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="birthday"
                           type="date"
                           name="birthday"
                           value="{{ isset($user) ? $user->birthday : null }}"/>
                </div>

                <div class="bk-form__field">
                    <label class="bk-form__label" for="address">
                        {{ __('users.address') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="address"
                           type="text"
                           name="address"
                           value="{{ isset($user) ? $user->address : null }}"/>
                </div>

                <div class="bk-form__field">
                    <label class="bk-form__label" for="phone">
                        {{ __('users.phone') }}
                        {{ @tip('+7 776 123 45 67') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="phone"
                           type="tel"
                           name="phone"
                           value="{{ isset($user) ? $user->phone : null }}"
                           pattern="[+]7 [0-9]{3} [0-9]{3} [0-9]{2} [0-9]{2}"/>
                </div>

                <div class="bk-form__field">
                    <label class="bk-form__label" for="email">
                        {{ __('users.email') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="email"
                           type="email"
                           name="email"
                           value="{{ isset($user) ? $user->email : null }}"/>
                </div>

                <div class="bk-form__field">
                    <label class="bk-form__label" for="activity">
                        {{ __('users.activity') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="activity"
                           type="text"
                           name="activity"
                           value="{{ isset($user) ? $user->activity : null }}"/>
                </div>

                <div class="bk-form__field">
                    <label class="bk-form__label" for="">
                        {{ __('users.password') }}
                        {{ @tip('мин.длина пароля 8 символов') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 @error('password') bk-border-red @enderror"
                           type="password"
                           name="password"
                           placeholder="Новый пароль"
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

                <div class="mt-1 mb-0 form-group">
                    <button class="btn btn-outline-success">
                        {{ __('crud.save') }}
                    </button>
                </div>
            </div>
        </form>
    </section>
@endsection
