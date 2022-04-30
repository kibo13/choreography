@extends('admin.index')
@section('title-admin', __('_section.rooms'))
@section('content-admin')
    <section id="rooms-form" class="overflow-auto is-validation">
        <h3>{{ @form_title($room) }}</h3>
        <form class="bk-form"
              action="{{ @is_update($room, 'admin.rooms') }}"
              method="POST">
            <div class="bk-form__wrapper">
                @csrf
                @isset($room) @method('PUT') @endisset

                <!-- num -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="num">
                        {{ __('_field.num') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-100 @error('num') border border-danger @enderror"
                           id="num"
                           type="text"
                           name="num"
                           value="{{ isset($room) ? $room->num : null }}"
                           required
                           maxlength="5"
                           autocomplete="off"/>
                    @error('num')
                    <div class="bk-validation">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- floor -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="floor">
                        {{ __('_field.floor') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-100 is-number"
                           id="floor"
                           type="text"
                           name="floor"
                           value="{{ isset($room) ? $room->floor : null }}"
                           required
                           maxlength="1"
                           autocomplete="off"/>
                </div>

                <!-- area -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="area">
                        {{ __('_field.area') }}
                    </label>
                    <input class="bk-form__input bk-max-w-100 is-float"
                           id="area"
                           type="text"
                           name="area"
                           value="{{ isset($room) ? $room->area : null }}"
                           maxlength="5"
                           autocomplete="off"/>
                </div>

                <!-- note -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="note">
                        {{ __('_field.note') }}
                    </label>
                    <textarea class="bk-form__textarea"
                              id="note"
                              name="note">{{ isset($room) ? $room->note : null }}</textarea>
                </div>

                <div class="mt-1 mb-0 form-room">
                    <button class="btn btn-outline-success">
                        {{ __('_action.save') }}
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.rooms.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
