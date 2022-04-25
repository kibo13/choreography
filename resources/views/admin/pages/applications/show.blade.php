@extends('admin.index')
@section('title-admin', __('_section.applications'))
@section('content-admin')
    <section id="applications-show" class="overflow-auto">
        <h3>{{ __('_action.show') }}</h3>
        <form class="bk-form"
              action="{{ route('admin.applications.update', $application) }}"
              method="POST">
            <div class="bk-form__wrapper">
                @csrf
                @method('PUT')

                <!-- num -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_app.id') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $application->num }}
                    </div>
                </div>

                <!-- created_at -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_date.create') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @getDMY($application->created_at) }}
                    </div>
                </div>

                <!-- author -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_app.author') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @full_fio($application->user_id) }}
                    </div>
                </div>

                <!-- status -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_state.this') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @status($application->status) }}
                    </div>
                </div>

                <!-- topic -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_app.topic') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $application->topic }}
                    </div>
                </div>

                <!-- description -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_app.desc') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $application->desc }}
                    </div>
                </div>

                <!-- attachment -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_file.attach') }}
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
                    <button class="btn btn-outline-success">
                        {{ __('_action.save') }}
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.applications.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
