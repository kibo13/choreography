@extends('admin.index')
@section('title-admin', __('_section.specialties'))
@section('content-admin')
    <section id="specialties-form" class="overflow-auto">
        <h3>{{ @form_title($specialty) }}</h3>
        <form class="bk-form"
              action="{{ @is_update($specialty, 'admin.specialties') }}"
              method="POST">
            <div class="bk-form__wrapper">
                @csrf
                @isset($specialty) @method('PUT') @endisset

                <!-- name -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="name">
                        {{ __('_field.name') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="name"
                           type="text"
                           name="name"
                           value="{{ isset($specialty) ? $specialty->name : null }}"
                           required
                           autocomplete="off"/>
                </div>

                <!-- sign -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="sign">
                        {{ __('_field.sign') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="sign"
                           type="text"
                           name="sign"
                           value="{{ isset($specialty) ? $specialty->sign : null }}"
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
                              name="note">{{ isset($specialty) ? $specialty->note : null }}</textarea>
                </div>

                <div class="mt-1 mb-0 form-specialty">
                    <button class="btn btn-outline-success">
                        {{ __('_action.save') }}
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.specialties.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
