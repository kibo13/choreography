@extends('admin.index')
@section('title-admin', __('_section.discounts'))
@section('content-admin')
    <section id="discounts-form" class="overflow-auto is-validation">
        <h3>{{ @form_title($discount) }}</h3>
        <form class="bk-form"
              action="{{ @is_update($discount, 'admin.discounts') }}"
              method="POST">
            <div class="bk-form__wrapper">
                @csrf
                @isset($discount) @method('PUT') @endisset

                <!-- name -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="name">
                        {{ __('_field.name') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input is-string"
                           id="name"
                           type="text"
                           name="name"
                           value="{{ isset($discount) ? $discount->name : null }}"
                           required
                           autocomplete="off"/>
                </div>

                <!-- size -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="size">
                        {{ __('_field.size') }}
                        {{ @mandatory() }}
                        {{ @tip('%') }}
                    </label>
                    <input class="bk-form__input bk-max-w-100 is-number"
                           id="size"
                           type="text"
                           name="size"
                           value="{{ isset($discount) ? $discount->size : null }}"
                           required
                           maxlength="2"
                           autocomplete="off"/>
                </div>

                <!-- note -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="note">
                        {{ __('_field.note') }}
                    </label>
                    <textarea class="bk-form__textarea"
                              id="note"
                              name="note">{{ isset($discount) ? $discount->note : null }}</textarea>
                </div>

                <div class="mt-1 mb-0 form-discount">
                    <button class="btn btn-outline-success">
                        {{ __('_action.save') }}
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.discounts.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
