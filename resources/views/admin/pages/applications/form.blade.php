@extends('admin.index')
@section('title-admin', __('_section.applications'))
@section('content-admin')
    <section id="applications-show" class="overflow-auto">
        <h3>{{ __('_field.info') }}</h3>
        <form class="bk-form"
              action="{{ route('admin.applications.update', $application) }}"
              method="POST">
            <div class="bk-form__wrapper">
                @csrf
                @method('PUT')

                <!-- num -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        Заявка {{ @tip(@getDMY($application->created_at)) }}
                    </label>
                    <div class="bk-form__text">
                        {{ '№' . $application->num }}
                    </div>
                </div>

                <!-- topic -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.topic') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $tops[$application->topic] }}
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
                        Вложения
                    </label>
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
                </div>

                <!-- author -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.author') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @full_fio('member', $application->member_id) }}
                    </div>
                </div>

                <!-- commment -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="note">
                        {{ __('_field.comment') }}
                    </label>
                    <textarea class="bk-form__textarea"
                              id="note"
                              name="note">{{ isset($application) ? $application->note : null }}</textarea>
                </div>

                <!-- status -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="status">
                        {{ __('_field.status') }} {{ @mandatory() }}
                    </label>
                    <select class="bk-form__select bk-max-w-300" id="status" name="status" required>
                        <option value="" disabled selected>{{ __('_select.status') }}</option>
                        @foreach($states as $index => $state)
                        <option value="{{ $index }}"
                                @isset($application) @if($application->status == $index)
                                selected
                                @endif @endisset>
                            {{ $state }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-1 mb-0 form-group">
                    @if($application->status == 0 && Auth::user()->role_id == 3)
                    <button class="btn btn-outline-success">
                        {{ __('_action.save') }}
                    </button>
                    @endif
                    <a class="btn btn-outline-secondary" href="{{ route('admin.applications.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
