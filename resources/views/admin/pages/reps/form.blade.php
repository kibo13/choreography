@extends('admin.index')
@section('title-admin', __('_section.reps'))
@section('content-admin')
    <section id="reps-form" class="overflow-auto is-validation">
        <h3>{{ @form_title($rep) }}</h3>
        <form class="bk-form"
              action="{{ @is_update($rep, 'admin.reps') }}"
              method="POST"
              enctype="multipart/form-data">
            <div class="bk-form__wrapper">
                @csrf
                @isset($rep) @method('PUT') @endisset

                <!-- last_name -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="last_name">
                        {{ __('_field.last_name') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 is-string"
                           id="last_name"
                           type="text"
                           name="last_name"
                           value="{{ old('last_name', isset($rep) ? $rep->last_name : null) }}"
                           required
                           autocomplete="off"/>
                </div>

                <!-- first_name -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="first_name">
                        {{ __('_field.first_name') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 is-string"
                           id="first_name"
                           type="text"
                           name="first_name"
                           value="{{ old('first_name', isset($rep) ? $rep->first_name : null) }}"
                           required
                           autocomplete="off"/>
                </div>

                <!-- middle_name -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="middle_name">
                        {{ __('_field.middle_name') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 is-string"
                           id="middle_name"
                           type="text"
                           name="middle_name"
                           value="{{ old('middle_name', isset($rep) ? $rep->middle_name : null) }}"
                           autocomplete="off"/>
                </div>

                <!-- doc_id -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="doc_id">
                        {{ __('_field.doc_type') }} {{ @mandatory() }}
                    </label>
                    <select class="bk-form__select bk-max-w-300"
                            id="doc_id"
                            name="doc_id"
                            required>
                        <option value="" disabled selected>{{ __('_select.doc') }}</option>
                        @foreach($docs as $doc)
                        <option value="{{ $doc->id }}"
                                @isset($rep) @if($rep->doc_id == $doc->id)
                                selected
                                @endif @endisset>
                            {{ $doc->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- doc_num -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="doc_num">
                        {{ __('_field.doc_num') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 is-number"
                           id="doc_num"
                           type="text"
                           name="doc_num"
                           value="{{ old('doc_num', isset($rep) ? $rep->doc_num : null) }}"
                           maxlength="10"
                           required
                           autocomplete="off"/>
                </div>

                <!-- doc_date -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="doc_date">
                        {{ __('_field.doc_date') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="doc_date"
                           type="date"
                           name="doc_date"
                           value="{{ old('doc_date', isset($rep) ? $rep->doc_date : null) }}"
                           required/>
                </div>

                <!-- doc_scan -->
                <div class="bk-form__field position-relative">
                    <label class="bk-form__label" for="doc_file">
                        {{ __('_field.doc_scan') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           type="text"
                           value="{{ isset($rep->doc_file) ? $rep->doc_note : null }}"
                           placeholder="{{ __('_field.file_not') }}"
                           disabled/>
                    <input class="bk-form__file bk-max-w-300"
                           data-file="upload"
                           type="file"
                           name="doc_file"
                           accept="image/*"/>
                </div>

                <!-- note -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="note">
                        {{ __('_field.note') }}
                    </label>
                    <textarea class="bk-form__textarea"
                              id="note"
                              name="note">{{ isset($rep) ? $rep->note : null }}</textarea>
                </div>

                <div class="mt-1 mb-0 form-rep">
                    <button class="btn btn-outline-success">
                        {{ __('_action.save') }}
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.reps.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
