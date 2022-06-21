@extends('admin.index')
@section('title-admin', __('_section.support'))
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
                        {{ __('_field.topic') }} {{ @mandatory() }}
                    </label>
                    @isset($application)
                    <div class="bk-form__text">
                        {{ $tops[$application->topic] }}
                    </div>
                    @else
                    <select class="bk-form__select bk-max-w-300" id="topic" name="topic" required>
                        <option value="" disabled selected>{{ __('_select.topic') }}</option>
                        @foreach($tops as $index => $top)
                        <option value="{{ $index }}">{{ $top }}</option>
                        @endforeach
                    </select>
                    @endif
                </div>

                <!-- description -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="desc">
                        {{ __('_field.desc') }} {{ @mandatory() }}
                    </label>
                    <textarea class="bk-form__textarea"
                              id="desc"
                              name="desc"
                              required>{{ isset($application) ? $application->desc : null }}</textarea>
                </div>

                <!-- files -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="file">Вложения</label>
                    @isset($application)
                    @if($application->files)
                    <ul>
                        @foreach($application->files as $file)
                        <li>
                            <a class="text-primary" href="{{ asset('assets/' . $file['path'] ) }}" target="_blank">
                                {{ $file['name'] }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                    @else
                    <div class="bk-form__text">
                        Вложения отсутствуют
                    </div>
                    @endif
                    <hr class="my-1">
                    @endisset
                    <input type="file" name="files[]" multiple>
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
