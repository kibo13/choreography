@extends('admin.index')
@section('title-admin', __('_section.profile'))
@section('content-admin')
    <section id="profile-form" class="overflow-auto">
        <h3>{{ __('_section.profile') }}</h3>

        @if(@is_access('help_read'))
        <div class="my-2 bk-callout">
            {{ __('_dialog.support') }}
            <a class="text-primary" href="{{ route('admin.support.index') }}">
                "{{ __('_section.support') }}"
            </a>
        </div>
        @endif

        @if(session()->has('success'))
        <div class="my-2 alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
        @endif

        @if(session()->has('warning'))
        <div class="my-2 alert alert-warning" role="alert">
            {{ session()->get('warning') }}
        </div>
        @endif

        <form class="bk-form"
              action="{{ route('admin.profile.update', $user) }}"
              method="POST">
            <div class="bk-form__wrapper">
                @csrf
                @method('PUT')

                <!-- username -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_person.username') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $user->username }}
                    </div>
                </div>

                <!-- fio -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_person.fio') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $user->last_name . ' ' . $user->first_name . ' ' . $user->middle_name }}
                    </div>
                </div>

                <!-- birthday -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_person.birthday') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @no_record(@getDMY($user->birthday), __('_record.no')) }}
                    </div>
                </div>

                <!-- phone -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_person.phone') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @no_record($user->phone, __('_record.no')) }}
                    </div>
                </div>

                <!-- email -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_person.email') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @no_record($user->email, __('_record.no')) }}
                    </div>
                </div>

                <!-- address_fact -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_person.address_fact') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @no_record($user->address_fact, __('_record.no')) }}
                    </div>
                </div>

                <!-- password -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="">
                        {{ __('_person.password') }}
                        {{ @tip('мин.длина пароля 8 символов') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 @error('password') border border-danger @enderror"
                           type="password"
                           name="password"
                           placeholder="Новый пароль"
                           autocomplete="off"/>
                    <input class="bk-form__input bk-max-w-300 @error('password') border border-danger @enderror"
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
                        {{ __('_action.save') }}
                    </button>
                </div>
            </div>
        </form>
    </section>
@endsection
