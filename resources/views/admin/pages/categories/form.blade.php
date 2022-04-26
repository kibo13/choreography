@extends('admin.index')
@section('title-admin', __('_section.categories'))
@section('content-admin')
    <section id="categories-form" class="overflow-auto is-validation">
        <h3>{{ @form_title($category) }}</h3>
        <form class="bk-form"
              action="{{ @is_update($category, 'admin.categories') }}"
              method="POST">
            <div class="bk-form__wrapper">
                @csrf
                @isset($category) @method('PUT') @endisset

                <!-- name -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="name">
                        {{ __('_field.name') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 is-string"
                           id="name"
                           type="text"
                           name="name"
                           value="{{ isset($category) ? $category->name : null }}"
                           required
                           autocomplete="off"/>
                </div>

                <!-- note -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="note">
                        {{ __('_field.note') }}
                    </label>
                    <textarea class="bk-form__textarea"
                              id="note"
                              name="note">{{ isset($category) ? $category->note : null }}</textarea>
                </div>

                <div class="mt-1 mb-0 form-category">
                    <button class="btn btn-outline-success">
                        {{ __('_action.save') }}
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.categories.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
