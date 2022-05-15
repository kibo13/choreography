@extends('admin.index')
@section('title-admin', __('_section.achievements'))
@section('content-admin')
    <section id="achievements-form" class="overflow-auto">
        <h3>{{ @form_title($achievement) }}</h3>
        <form class="bk-form"
              action="{{ @is_update($achievement, 'admin.achievements') }}"
              method="POST">
            <div class="bk-form__wrapper">
                @csrf
                @isset($achievement) @method('PUT') @endisset

                <!-- event_id -->
                <input type="hidden"
                       name="event_id"
                       value="{{ isset($achievement) ? $achievement->event_id : $event->id }}"
                />

                <!-- name -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="name">
                        {{ __('_field.name') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="name"
                           type="text"
                           name="name"
                           value="{{ old('name', isset($achievement) ? $achievement->name : null) }}"
                           required
                           autocomplete="off"/>
                </div>

                <!-- num -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="num">
                        {{ __('_field.num') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="num"
                           type="text"
                           name="num"
                           value="{{ old('num', isset($achievement) ? $achievement->num : null) }}"
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
                              name="note">{{ old('note', isset($achievement) ? $achievement->note : null) }}</textarea>
                </div>

                <div class="mt-1 mb-0 form-discount">
                    <button class="btn btn-outline-success">
                        {{ __('_action.save') }}
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.achievements.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
