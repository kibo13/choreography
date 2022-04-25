@extends('admin.index')
@section('title-admin', __('_section.customers'))
@section('content-admin')
    <section id="customers-form" class="overflow-auto is-validation">
        <h3>{{ @form_title($user) }}</h3>
        <form class="bk-form"
              action="{{ @is_update($user, 'admin.customers') }}"
              method="POST"
              enctype="multipart/form-data">
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

                <!-- doc_type -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="doc_type">
                        {{ __('_person.doc_type') }} {{ @mandatory() }}
                    </label>
                    <select class="bk-form__select bk-max-w-300" name="doc_type" required>
                        <option value="" disabled selected>{{ __('_select.doc') }}</option>
                        @foreach($docs as $index => $doc)
                        <option value="{{ $index }}"
                                @isset($user) @if($user->doc_type == $index)
                                selected
                                @endif @endisset>
                            {{ $doc }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- doc_num -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="doc_num">
                        {{ __('_person.doc_num') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 is-number"
                           id="doc_num"
                           type="text"
                           name="doc_num"
                           value="{{ isset($user) ? $user->doc_num : null }}"
                           maxlength="10"
                           required
                           autocomplete="off"/>
                </div>

                <!-- doc_date -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="doc_date">
                        {{ __('_person.doc_date') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="doc_date"
                           type="date"
                           name="doc_date"
                           value="{{ isset($user) ? $user->doc_date : null }}"
                           required/>
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

                <!-- address_doc -->
                <div class="bk-form__field position-relative">
                    <label class="bk-form__label" for="address_doc">
                        {{ __('_person.address_doc') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="upload-file"
                           type="text"
                           value="{{ isset($user->address_doc) ? $user->address_note : null }}"
                           placeholder="{{ __('_file.no_select') }}"
                           disabled/>
                    <input class="bk-form__file bk-max-w-300"
                           id="upload-btn"
                           type="file"
                           name="address_doc"
                           accept="image/*"/>
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

                <!-- activity -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="activity">
                        {{ __('_person.activity') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="activity"
                           type="text"
                           name="activity"
                           value="{{ isset($user) ? $user->activity : null }}"/>
                </div>

                <div class="mt-1 mb-0 form-group">
                    <button class="btn btn-outline-success">
                        {{ __('_action.save') }}
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.customers.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
