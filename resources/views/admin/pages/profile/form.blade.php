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
                        {{ __('_field.username') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $user->username }}
                    </div>
                </div>

                <!-- fio -->
                @if($user->role_id > 2)
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.fio') }}
                    </label>
                    <div class="bk-form__text">
                        @if($user->role_id == 5)
                        {{ $user->member->last_name }}
                        {{ $user->member->first_name }}
                        {{ $user->member->middle_name }}
                        @else
                        {{ $user->worker->last_name }}
                        {{ $user->worker->first_name }}
                        {{ $user->worker->middle_name }}
                        @endif
                    </div>
                </div>

                <!-- group -->
                @if($user->role_id == 5)
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.group') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $user->member->group->title->name }}
                        {{ @tip($user->member->group->category->name) }}
                    </div>
                </div>
                @endif

                <!-- birthday -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.birthday') }}
                    </label>
                    <div class="bk-form__text">
                        @if($user->role_id == 5)
                        {{ @no_record(@getDMY($user->member->birthday), __('_record.no')) }}
                        @else
                        {{ @no_record(@getDMY($user->worker->birthday), __('_record.no')) }}
                        @endif
                    </div>
                </div>

                <!-- phone -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.phone') }}
                    </label>
                    <div class="bk-form__text">
                        @if($user->role_id == 5)
                        {{ @no_record($user->member->phone, __('_record.no')) }}
                        @else
                        {{ @no_record($user->worker->phone, __('_record.no')) }}
                        @endif
                    </div>
                </div>

                <!-- email -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.email') }}
                    </label>
                    <div class="bk-form__text">
                        @if($user->role_id == 5)
                        {{ @no_record($user->member->email, __('_record.no')) }}
                        @else
                        {{ @no_record($user->worker->email, __('_record.no')) }}
                        @endif
                    </div>
                </div>

                <!-- address_fact -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.address_fact') }}
                    </label>
                    <div class="bk-form__text">
                        @if($user->role_id == 5)
                        {{ @no_record($user->member->address_fact, __('_record.no')) }}
                        @else
                        {{ @no_record($user->worker->address_fact, __('_record.no')) }}
                        @endif
                    </div>
                </div>
                @endif

                <!-- password -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="">
                        {{ __('_field.password') }}
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
