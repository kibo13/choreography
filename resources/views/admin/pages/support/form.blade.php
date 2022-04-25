@extends('admin.index')
@section('title-admin', __('_section.customers'))
@section('content-admin')
    <section id="support-form" class="overflow-auto">
        <h3>{{ @form_title($application) }}</h3>
        <form class="bk-form"
              action="{{ @is_update($application, 'admin.support') }}"
              method="POST"
              enctype="multipart/form-data">
            <div class="bk-form__wrapper">
                @csrf
                @isset($application) @method('PUT') @endisset

                <!-- topic -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="topic">
                        {{ __('_app.topic') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input"
                           id="topic"
                           type="text"
                           name="topic"
                           value="{{ isset($application) ? $application->topic : null }}"
                           required
                           autocomplete="off"/>
                </div>

                <!-- description -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="desc">
                        {{ __('_app.desc') }} {{ @mandatory() }}
                    </label>
                    <textarea class="bk-form__textarea"
                              id="desc"
                              name="desc"
                              required>{{ isset($application) ? $application->desc : null }}</textarea>
                </div>

                <!-- file -->
                <div class="bk-form__field position-relative">
                    <label class="bk-form__label" for="file">
                        {{ __('_file.attach') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300  @error('file') border border-danger @enderror"
                           id="upload-file"
                           type="text"
                           value="{{ isset($application->file) ? $application->note : null }}"
                           placeholder="{{ __('_file.no_select') }}"
                           disabled/>
                    <input class="bk-form__file bk-max-w-300"
                           id="upload-btn"
                           type="file"
                           name="file"
                           accept="image/*"/>
                    @error('file')
                    <div class="bk-validation">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mt-1 mb-0 form-group">
                    <button class="btn btn-outline-success">
                        {{ __('_action.save') }}
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.support.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
