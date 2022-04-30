@extends('admin.index')
@section('title-admin', __('_section.support'))
@section('content-admin')
    <section id="support-show" class="overflow-auto">
        <h3>{{ __('_action.show') }}</h3>

        <div class="bk-form">
            <div class="bk-form__wrapper">
                <!-- num -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.num') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $application->num }}
                    </div>
                </div>

                <!-- created_at -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.created_at') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @getDMY($application->created_at) }}
                    </div>
                </div>

                <!-- status -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.status') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @status($application->status) }}
                    </div>
                </div>

                <!-- topic -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.topic') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $application->topic }}
                    </div>
                </div>

                <!-- description -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.desc') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $application->desc }}
                    </div>
                </div>

                <!-- attachment -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.attachment') }}
                    </label>
                    <div class="bk-form__text">
                        @if($application->file)
                        <a class="text-lowercase text-primary"
                           href="{{ asset('assets/' . $application->file ) }}"
                           target="_blank">
                            {{ __('_action.look') }}
                        </a>
                        @else
                        <span class="text-info">
                            {{ __('_record.no') }}
                        </span>
                        @endif
                    </div>
                </div>

                <div class="mt-1 mb-0 form-group">
                    <a class="btn btn-outline-secondary" href="{{ route('admin.support.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
