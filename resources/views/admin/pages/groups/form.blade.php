@extends('admin.index')
@section('title-admin', __('_section.groups'))
@section('content-admin')
    <section id="groups-form" class="overflow-auto is-validation">
        <h3>{{ @form_title($group) }}</h3>
        <form class="bk-form"
              action="{{ @is_update($group, 'admin.groups') }}"
              method="POST">
            <div class="bk-form__wrapper">
                @csrf
                @isset($group) @method('PUT') @endisset

                <!-- title_id -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="title_id">
                        {{ __('_field.group') }} {{ @mandatory() }}
                    </label>
                    <select class="bk-form__select bk-max-w-300"
                            id="title_id"
                            name="title_id"
                            required>
                        <option value="" disabled selected>{{ __('_select.group') }}</option>
                        @foreach($titles as $title)
                        <option value="{{ $title->id }}"
                                @isset($group) @if($group->title_id == $title->id)
                                selected
                                @endif @endisset>
                            {{ $title->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- category_id -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="category_id">
                        {{ __('_field.category') }} {{ @mandatory() }}
                    </label>
                    <select class="bk-form__select bk-max-w-300"
                            id="category_id"
                            name="category_id"
                            required>
                        <option value="" disabled selected>{{ __('_select.category') }}</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                                @isset($group) @if($group->category_id == $category->id)
                                selected
                                @endif @endisset>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- basic_seats -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="basic_seats">
                        {{ __('_field.basic_seats') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-100 is-count"
                           id="basic_seats"
                           type="text"
                           name="basic_seats"
                           maxlength="2"
                           value="{{ isset($group) ? $group->basic_seats : null }}"
                           required
                           autocomplete="off"/>
                </div>

                <!-- extra_seats -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="extra_seats">
                        {{ __('_field.extra_seats') }}
                    </label>
                    <input class="bk-form__input bk-max-w-100 is-count"
                           id="extra_seats"
                           type="text"
                           name="extra_seats"
                           maxlength="2"
                           value="{{ isset($group) ? $group->extra_seats : null }}"
                           autocomplete="off"/>
                </div>

                <!-- age_from -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="age_from">
                        {{ __('_field.age_from') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-100 is-count"
                           id="age_from"
                           type="text"
                           name="age_from"
                           maxlength="2"
                           value="{{ isset($group) ? $group->age_from : null }}"
                           required
                           autocomplete="off"/>
                </div>

                <!-- age_till -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="age_till">
                        {{ __('_field.age_till') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-100 is-count"
                           id="age_till"
                           type="text"
                           name="age_till"
                           maxlength="2"
                           value="{{ isset($group) ? $group->age_till : null }}"
                           required
                           autocomplete="off"/>
                </div>

                <!-- price -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="price">
                        {{ __('_field.price') }} {{ @tip('₽') }}
                    </label>
                    <input class="bk-form__input bk-max-w-100 is-count"
                           id="price"
                           type="text"
                           name="price"
                           maxlength="4"
                           value="{{ isset($group) ? $group->price : null }}"
                           autocomplete="off"/>
                </div>

                <!-- lessons -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="lessons">
                        {{ __('_field.lessons') }}
                    </label>
                    <input class="bk-form__input bk-max-w-100 is-count"
                           id="lessons"
                           type="text"
                           name="lessons"
                           maxlength="2"
                           value="{{ isset($group) ? $group->lessons : null }}"
                           autocomplete="off"/>
                </div>

                <div class="mt-1 mb-0 form-group">
                    <button class="btn btn-outline-success">
                        {{ __('_action.save') }}
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.groups.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
