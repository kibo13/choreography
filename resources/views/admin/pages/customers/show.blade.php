@extends('admin.index')
@section('title-admin', __('_section.customers'))
@section('content-admin')
    <section id="customers-show" class="overflow-auto">
        <h3>{{ __('_action.show') }}</h3>

        <div class="bk-form">
            <div class="bk-form__wrapper">
                <!-- nickname -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.username') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $user->username }}
                    </div>
                </div>

                <!-- fio -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.fio') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $user->last_name . ' ' . $user->first_name . ' ' . $user->middle_name }}
                    </div>
                </div>

                <!-- phone -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.phone') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $user->phone }}
                    </div>
                </div>

                <!-- email -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.email') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @no_record($user->email, __('_record.no')) }}
                    </div>
                </div>

                <!-- birthday -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.birthday') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @getDMY($user->birthday) }}
                    </div>
                </div>

                <!-- age -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.age') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $user->age }}
                    </div>
                </div>

                <!-- passport -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.docs') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $user->doc_type == 1 ? __('_field.passport') : __('_field.id_card') }}
                        {{ $user->doc_num }}
                        {{ ' от ' . @getDMY($user->doc_date) }}
                    </div>
                </div>

                <!-- address_doc -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.address_doc') }}
                    </label>
                    <div class="bk-form__text">
                        @if($user->address_doc)
                        <a class="text-lowercase text-primary"
                           href="{{ asset('assets/' . $user->address_doc ) }}"
                           target="_blank">
                            {{ __('_action.look') }}
                        </a>
                        @else
                        <span class="text-info">
                            {{ __('_record.no') }}
                        </span>
                        @endif
                    </div>
                </div>

                <!-- address_fact -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.address_fact') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @no_record($user->address_fact, __('_record.no')) }}
                    </div>
                </div>

                <!-- activity -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.activity') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @no_record($user->activity, __('_record.no')) }}
                    </div>
                </div>

                <div class="mt-1 mb-0 form-group">
                    <a class="btn btn-outline-secondary" href="{{ route('admin.customers.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
