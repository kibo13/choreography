@extends('admin.index')
@section('title-admin', __('_section.titles'))
@section('content-admin')
    <section id="titles-form" class="overflow-auto">
        <h3>{{ @form_title($title) }}</h3>
        <form class="bk-form"
              action="{{ @is_update($title, 'admin.titles') }}"
              method="POST">
            <div class="bk-form__wrapper">
                @csrf
                @isset($title) @method('PUT') @endisset

                <!-- name -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="name">
                        {{ __('_field.name') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="name"
                           type="text"
                           name="name"
                           value="{{ isset($title) ? $title->name : null }}"
                           required
                           autocomplete="off"/>
                </div>

                <!-- specialty_id -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="specialty_id">
                        {{ __('_field.specialty') }} {{ @mandatory() }}
                    </label>
                    <select class="bk-form__select bk-max-w-300"
                            id="specialty_id"
                            name="specialty_id"
                            required>
                        <option value="" disabled selected>{{ __('_select.specialty') }}</option>
                        @foreach($specialties as $specialty)
                        <option value="{{ $specialty->id }}"
                                @isset($title) @if($title->specialty_id == $specialty->id)
                                selected
                                @endif @endisset>
                            {{ $specialty->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- is_paid -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="is_paid">
                        {{ __('_field.study') }} {{ @mandatory() }}
                    </label>
                    <select class="bk-form__select bk-max-w-300"
                            id="is_paid"
                            name="is_paid"
                            required>
                        <option value="" disabled selected>{{ __('_select.study') }}</option>
                        @foreach($studies as $index => $study)
                        <option value="{{ $index }}"
                                @isset($title) @if($title->is_paid == $index)
                                selected
                                @endif @endisset>
                            {{ $study }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- note -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="note">
                        {{ __('_field.note') }}
                    </label>
                    <textarea class="bk-form__textarea"
                              id="note"
                              name="note">{{ isset($title) ? $title->note : null }}</textarea>
                </div>

                <div class="mt-1 mb-0 form-title">
                    <button class="btn btn-outline-success">
                        {{ __('_action.save') }}
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.titles.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
