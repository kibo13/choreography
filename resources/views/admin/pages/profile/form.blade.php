@extends('admin.index')
@section('title-admin', __('section.profile'))
@section('content-admin')
    <section id="profile-form" class="overflow-auto">
        <h3>{{ __('section.profile') }}</h3>

        <div class="my-2 bk-callout">
            Для изменения персональных данных создайте запрос в разделе
            <a class="text-primary" href="{{ route('admin.applications.index') }}">
                "{{ __('section.applications') }}"
            </a>
        </div>

        @if(session()->has('success'))
        <div class="my-2 alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
        @endif

        <form class="bk-form"
              action="{{ route('admin.profile.update', $user) }}"
              method="POST"
              enctype="multipart/form-data">
            <div class="bk-form__wrapper">
                @csrf
                @method('PUT')

                <!-- username -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('person.nickname') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $user->username }}
                    </div>
                </div>

                <!-- fio -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('person.fio') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $user->last_name . ' ' . $user->first_name . ' ' . $user->middle_name }}
                    </div>
                </div>

                <!-- birthday -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('person.birthday') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @no_record($user->birthday, __('data.no')) }}
                    </div>
                </div>

                <!-- phone -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('person.phone') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @no_record($user->phone, __('data.no')) }}
                    </div>
                </div>

                <!-- email -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('person.email') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @no_record($user->email, __('data.no')) }}
                    </div>
                </div>

                <!-- address_fact -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('person.address_fact') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @no_record($user->address_fact, __('data.no')) }}
                    </div>
                </div>

                <!-- activity -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('person.activity') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @no_record($user->activity, __('data.no')) }}
                    </div>
                </div>

                <!-- password -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="">
                        {{ __('person.password') }}
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
                        {{ __('operation.save') }}
                    </button>
                </div>
            </div>
        </form>
    </section>
@endsection
