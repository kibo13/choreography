@extends('admin.index')
@section('title-admin', __('_section.orgkomitets'))
@section('content-admin')
    <section id="orgkomitets-form" class="overflow-auto is-validation">
        <h3>{{ @form_title($orgkomitet) }}</h3>

        <form class="bk-form"
              action="{{ @is_update($orgkomitet, 'admin.orgkomitets') }}"
              method="POST">
            <div class="bk-form__wrapper">
                @csrf
                @isset($orgkomitet) @method('PUT') @endisset

                <!-- name -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="name">
                        {{ __('_field.name') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="name"
                           type="text"
                           name="name"
                           value="{{ old('name', isset($orgkomitet) ? $orgkomitet->name : null) }}"
                           required
                           autocomplete="off"/>
                </div>

                <!-- phone -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="phone">
                        {{ __('_field.phone') }}
                        {{ @mandatory() }}
                        {{ @tip('+7 776 123 45 67') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 is-phone"
                           id="phone"
                           type="tel"
                           name="phone"
                           value="{{ old('phone', isset($orgkomitet) ? $orgkomitet->phone : null) }}"
                           pattern="[+]7 [0-9]{3} [0-9]{3} [0-9]{2} [0-9]{2}"
                           maxlength="16"
                           required
                           autocomplete="off"/>
                </div>

                <!-- email -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="email">
                        {{ __('_field.email') }}
                        {{ @tip('example@dance.ru') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="email"
                           type="email"
                           name="email"
                           value="{{ old('email', isset($orgkomitet) ? $orgkomitet->email : null) }}"
                           autocomplete="off"/>
                </div>

                <!-- site -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="site">
                        {{ __('_field.website') }}
                    </label>
                    <input class="bk-form__input"
                           id="site"
                           type="text"
                           name="site"
                           value="{{ old('site', isset($orgkomitet) ? $orgkomitet->site : null) }}"
                           autocomplete="off"/>
                </div>

                <!-- from -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="from">
                        {{ __('_field.orgtime_from') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-100"
                           id="from"
                           type="time"
                           name="from"
                           value="{{ old('from', isset($orgkomitet) ? $orgkomitet->from : null) }}"
                           required
                           autocomplete="off"/>
                </div>

                <!-- from -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="till">
                        {{ __('_field.orgtime_till') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-100"
                           id="till"
                           type="time"
                           name="till"
                           value="{{ old('till', isset($orgkomitet) ? $orgkomitet->till : null) }}"
                           required
                           autocomplete="off"/>
                </div>

                <!-- note -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="note">
                        {{ __('_field.note') }}
                    </label>
                    <textarea class="bk-form__textarea"
                              id="note"
                              name="note">{{ old('note', isset($orgkomitet) ? $orgkomitet->note : null) }}</textarea>
                </div>

                <div class="mt-1 mb-0 form-event">
                    <button class="btn btn-outline-success">
                        {{ __('_action.save') }}
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.orgkomitets.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
