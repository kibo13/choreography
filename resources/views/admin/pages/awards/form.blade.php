@extends('admin.index')
@section('title-admin', __('_section.awards'))
@section('content-admin')
    <section id="awards-form" class="overflow-auto is-validation">
        <h3>{{ @form_title($award) }}</h3>
        <form class="bk-form"
              action="{{ @is_update($award, 'admin.awards') }}"
              method="POST">
            <div class="bk-form__wrapper">
                @csrf
                @isset($award) @method('PUT') @endisset

                <!-- num -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="num">
                        Номер регистрации {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-200 @error('num') border border-danger @enderror"
                           id="num"
                           type="text"
                           name="num"
                           value="{{ old('num', isset($award) ? $award->num : null) }}"
                           required
                           autocomplete="off"/>
                    @error('num')
                    <div class="bk-validation">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- date_reg -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="date_reg">
                        Дата регистрации {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-200"
                           id="date_reg"
                           type="date"
                           name="date_reg"
                           value="{{ old('date_reg', isset($award) ? $award->date_reg : null) }}"
                           required/>
                </div>

                <!-- date_doc -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="date_doc">
                        Дата выдачи документа {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-200"
                           id="date_doc"
                           type="date"
                           name="date_doc"
                           value="{{ old('date_doc', isset($award) ? $award->date_doc : null) }}"
                           required/>
                </div>

                <!-- name_doc -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="name_doc">
                        Название документа {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input"
                           id="name_doc"
                           type="text"
                           name="name_doc"
                           value="{{ old('name_doc', isset($award) ? $award->name_doc : null) }}"
                           required
                           autocomplete="off"/>
                </div>

                <!-- group_id -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="group_id">
                        {{ __('_field.group') }} {{ @mandatory() }}
                    </label>
                    <select class="bk-form__select bk-max-w-250"
                            id="group_id"
                            name="group_id"
                            required>
                        <option value="" disabled selected>{{ __('_select.group') }}</option>
                        @foreach($groups as $group)
                        <option value="{{ $group->id }}"
                                @isset($award) @if($award->group_id == $group->id)
                                selected
                                @endif @endisset>
                            {{ $group->title->name }}
                            {{ $group->category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- orgkomitet_id -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="orgkomitet_id">
                        {{ __('_field.organizer') }} {{ @mandatory() }}
                    </label>
                    <select class="bk-form__select bk-max-w-250"
                            id="orgkomitet_id"
                            name="orgkomitet_id"
                            required>
                        <option value="" disabled selected>{{ __('_select.organizer') }}</option>
                        @foreach($organizers as $organizer)
                        <option value="{{ $organizer->id }}"
                                @isset($award) @if($award->orgkomitet_id == $organizer->id)
                                selected
                                @endif @endisset>
                            {{ $organizer->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- note -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="note">
                        {{ __('_field.note') }}
                    </label>
                    <textarea class="bk-form__textarea"
                              id="note"
                              name="note">{{ old('note', isset($award) ? $award->note : null) }}</textarea>
                </div>

                <div class="mt-1 mb-0 form-room">
                    <button class="btn btn-outline-success">
                        {{ __('_action.save') }}
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.awards.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
