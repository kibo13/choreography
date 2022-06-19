@extends('admin.index')
@section('title-admin', __('_section.members'))
@section('content-admin')
    <section id="members-show" class="overflow-auto">
        <h3>{{ __('_section.info') }}</h3>
        <div class="bk-form">
            <div class="bk-form__wrapper">
                <!-- group_id -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.group') }}
                        {{ @tip($member->group->category->name) }}
                    </label>
                    <div class="bk-form__text">
                        {{ $member->group->title->name }}
                    </div>
                </div>

                <!-- form_study -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.study') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $member->form_study == 1 ? __('_field.paid') : __('_field.free') }}
                    </div>
                </div>

                <!-- rep -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        Родитель / Законный представитель
                    </label>
                    <div class="bk-form__text">
                        @if($member->rep_id)
                        {{ $member->rep->last_name . ' ' . $member->rep->first_name . ' ' . $member->rep->middle_name }}
                        @else
                        запись отсутствует
                        @endif
                    </div>
                </div>

                <!-- member -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.member') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $member->last_name . ' ' . $member->first_name . ' ' . $member->middle_name }}
                    </div>
                </div>

                <!-- address_fact -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.address_fact') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @no_record($member->address_fact, __('_record.no')) }}
                    </div>
                </div>

                <!-- phone -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.phone') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $member->phone }}
                    </div>
                </div>

                <!-- email -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.email') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $member->email ? $member->email : 'запись отсутствует' }}
                    </div>
                </div>

                <!-- docs -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.docs') }}
                    </label>
                    <ul class="bk-form__text">
                        <li>
                            1.
                            <a class="text-primary"
                               href="{{ $member->doc_file ? asset('assets/' . $member->doc_file) : asset('assets/404.png') }}"
                               target="_blank">
                                {{ $member->doc->name . ' №' . $member->doc_num . ' от ' . @getDMY($member->doc_date) }}
                            </a>
                        </li>
                        <li>
                            2.
                            <a class="text-primary"
                               href="{{ $member->app_file ? asset('assets/' . $member->app_file) : asset('assets/404.png') }}"
                               target="_blank">
                                Заявление о приеме участника
                            </a>
                        </li>
                        <li>
                            3.
                            <a class="text-primary"
                               href="{{ $member->consent_file ? asset('assets/' . $member->consent_file) : asset('assets/404.png') }}"
                               target="_blank">
                                Соглашение на сбор и обработку персональных данных
                            </a>
                        </li>
                        <li>
                            4.
                            <a class="text-primary"
                               href="{{ $member->address_doc ? asset('assets/' . $member->address_doc) : asset('assets/404.png') }}"
                               target="_blank">
                                Адресная справка
                            </a>
                        </li>
                        @if($member->discount_id && $member->discount_id != 5)
                            <li>
                                5.
                                <a class="text-primary"
                                   href="{{ $member->discount_doc ? asset('assets/' . $member->discount_doc) : asset('assets/404.png') }}"
                                   target="_blank">
                                    {{ $member->discount->name }}
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="mt-1 mb-0 form-group">
                    <a class="btn btn-outline-secondary" href="{{ route('admin.members.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
