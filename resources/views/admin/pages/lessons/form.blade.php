@extends('admin.index')
@section('title-admin', __('_section.lessons'))
@section('content-admin')
    <section id="lessons-form" class="overflow-auto is-validation">
        <h3>{{ @form_title($lesson) }}</h3>
        <form class="bk-form"
              action="{{ @is_update($lesson, 'admin.lessons') }}"
              method="POST">
            <div class="bk-form__wrapper">
                @csrf
                @isset($lesson) @method('PUT') @endisset

                <!-- name -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="name">
                        {{ __('_field.name') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 is-string"
                           id="name"
                           type="text"
                           name="name"
                           value="{{ isset($lesson) ? $lesson->name : null }}"
                           required
                           autocomplete="off"/>
                </div>

                <!-- sign -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="sign">
                        {{ __('_field.sign') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 is-string"
                           id="sign"
                           type="text"
                           name="sign"
                           value="{{ isset($lesson) ? $lesson->sign : null }}"
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
                              name="note">{{ isset($lesson) ? $lesson->note : null }}</textarea>
                </div>

                <div class="mt-1 mb-0 form-lesson">
                    <button class="btn btn-outline-success">
                        {{ __('_action.save') }}
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.lessons.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
