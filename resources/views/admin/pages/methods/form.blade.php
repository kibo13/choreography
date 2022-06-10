@extends('admin.index')
@section('title-admin', __('_section.methods'))
@section('content-admin')
    <section id="methods-form" class="overflow-auto is-validation">
        <h3>{{ @form_title($method) }}</h3>
        <form class="bk-form"
              action="{{ @is_update($method, 'admin.methods') }}"
              method="POST">
            <div class="bk-form__wrapper">
                @csrf
                @isset($method) @method('PUT') @endisset

                <!-- group_id -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="group_id">
                        {{ __('_field.group') }} {{ @mandatory() }}
                    </label>
                    <select class="bk-form__select bk-max-w-300"
                            id="group_id"
                            name="group_id"
                            required>
                        <option value="" disabled selected>{{ __('_select.group') }}</option>
                        @foreach($groups as $group)
                        <option value="{{ $group->id }}"
                                @isset($method) @if($method->group_id == $group->id)
                                selected
                                @endif @endisset>
                            {{ $group->title->name }}
                            @if($group->category_id != 4)
                            {{ $group->category->name }}
                            @endif
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- month_id -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="month_id">
                        {{ __('_field.month') }} {{ @mandatory() }}
                    </label>
                    <select class="bk-form__select bk-max-w-300"
                            id="month_id"
                            name="month_id"
                            required>
                        <option value="" disabled selected>{{ __('_select.month') }}</option>
                        @foreach($months as $month)
                        <option value="{{ $month['id'] }}"
                                @isset($method) @if($method->month_id == $month['id'])
                                selected
                                @endif @endisset>
                            {{ $month['fullname'] }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- lesson_id -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="lesson_id">
                        {{ __('_field.type_lesson') }} {{ @mandatory() }}
                    </label>
                    <select class="bk-form__select bk-max-w-300"
                            id="lesson_id"
                            name="lesson_id"
                            required>
                        <option value="" disabled selected>{{ __('_select.lesson') }}</option>
                        @foreach($lessons as $lesson)
                        <option value="{{ $lesson->id }}"
                                @isset($method) @if($method->lesson_id == $lesson->id)
                                selected
                                @endif @endisset>
                            {{ $lesson->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- name -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="name">
                        {{ __('_field.topic') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input"
                           id="name"
                           type="text"
                           name="name"
                           value="{{ old('name', isset($method) ? $method->name : null) }}"
                           required/>
                </div>

                <!-- hours -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="hours">
                        {{ __('_field.hours_per') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-100 is-float"
                           id="hours"
                           type="text"
                           name="hours"
                           value="{{ old('hours', isset($method) ? $method->hours : null) }}"
                           maxlength="3"
                           required/>
                </div>

                <!-- note -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="note">
                        {{ __('_field.note') }}
                    </label>
                    <textarea class="bk-form__textarea"
                              id="note"
                              name="note">{{ isset($method) ? $method->note : null }}</textarea>
                </div>

                <div class="mt-1 mb-0 form-method">
                    <button class="btn btn-outline-success">
                        {{ __('_action.save') }}
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.methods.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
