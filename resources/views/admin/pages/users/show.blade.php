@extends('admin.index')
@section('title-admin', __('section.users'))
@section('content-admin')
    <section id="users-form" class="bk-section">
        <h3>{{ __('crud.info') }}</h3>

        <div class="bk-form" data-info="{{ __('base.data') }}">
            <div class="bk-form__wrapper">
                <div class="bk-form__field">
                    <label class="bk-form__label">{{ __('users.fio') }}</label>
                    <div class="bk-form__text">
                        {{ $user->last_name . ' ' . $user->first_name . ' ' . $user->middle_name }}
                    </div>
                </div>

                <div class="bk-form__field">
                    <label class="bk-form__label">{{ __('users.address') }}</label>
                    <div class="bk-form__text">{{ $user->address ? $user->address : __('crud.no_data') }}</div>
                </div>

                <div class="bk-form__field">
                    <label class="bk-form__label">{{ __('users.email') }}</label>
                    <div class="bk-form__text">{{ $user->email ? $user->email : __('crud.no_data') }}</div>
                </div>

                <div class="bk-form__field">
                    <label class="bk-form__label">{{ __('users.phone') }}</label>
                    <div class="bk-form__text">{{ $user->phone ? $user->phone : __('crud.no_data') }}</div>
                </div>

                <div class="bk-form__field">
                    <label class="bk-form__label">{{ __('users.activity') }}</label>
                    <div class="bk-form__text">{{ $user->activity ? $user->activity : __('crud.no_data') }}</div>
                </div>

                <div class="mt-1 mb-0 form-group">
                    <a class="btn btn-outline-secondary" href="{{ route('admin.users.index') }}">
                        {{ __('crud.back') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
