@extends('admin.index')
@section('title-admin', __('_section.events'))
@section('content-admin')
    <section id="events-form" class="overflow-auto">
        <h3>{{ @form_title($event) }}</h3>
        <form class="bk-form"
              action="{{ @is_update($event, 'admin.events') }}"
              method="POST">
            <div class="bk-form__wrapper">
                @csrf
                @isset($event) @method('PUT') @endisset

                <!-- type -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="type">
                        {{ __('_field.type') }} {{ @mandatory() }}
                    </label>
                    <select class="bk-form__select bk-max-w-300"
                            id="type"
                            name="type"
                            required>
                        <option value="" disabled selected>{{ __('_select.event') }}</option>
                        @foreach($types as $index => $type)
                        <option value="{{ $index }}"
                                @isset($event) @if($event->type == $index)
                                selected
                                @endif @endisset>
                            {{ $type }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- name -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="name">
                        {{ __('_field.name') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="name"
                           type="text"
                           name="name"
                           value="{{ isset($event) ? $event->name : null }}"
                           required
                           autocomplete="off"/>
                </div>

                <!-- from -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="from">
                        {{ __('_field.date_from') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="from"
                           type="date"
                           name="from"
                           value="{{ isset($event) ? $event->from : null }}"
                           required/>
                </div>

                <!-- till -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="till">
                        {{ __('_field.date_till') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="till"
                           type="date"
                           name="till"
                           value="{{ isset($event) ? $event->till : null }}"/>
                </div>

                <!-- place -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="place">
                        {{ __('_field.place') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="place"
                           type="text"
                           name="place"
                           value="{{ isset($event) ? $event->place : null }}"
                           required/>
                </div>

                <!-- groups -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="">
                        {{ __('_field.groups') }}
                    </label>
                    <div class="bk-form__list">
                        @foreach($groups as $group)
                        <div class="bk-form__list-item">
                            <input class="bk-form__list-checkbox"
                                   id="{{ $group->id }}"
                                   type="checkbox"
                                   name="groups[]"
                                   value="{{ $group->id }}"
                                   @isset($event) @if($event->groups->where('id', $group->id)->count())
                                   checked
                                   @endif @endisset>
                            <label class="bk-form__list-label" for="{{ $group->id }}">
                                {{ $group->title->name }}
                                {{ $group->category_id == 4 ? null : @tip($group->category->name) }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mt-1 mb-0 form-event">
                    <button class="btn btn-outline-success">
                        {{ __('_action.save') }}
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.events.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
