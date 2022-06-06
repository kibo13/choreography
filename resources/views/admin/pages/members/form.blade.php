@extends('admin.index')
@section('title-admin', __('_section.members'))
@section('content-admin')
    <section id="members-form" class="overflow-auto is-validation">
        <h3>{{ @form_title($member) }}</h3>

        @if(session()->has('warning'))
        <div class="my-2 alert alert-warning" role="alert">
            {{ session()->get('warning') }}
        </div>
        @endif

        <form class="bk-form"
              action="{{ @is_update($member, 'admin.members') }}"
              method="POST"
              enctype="multipart/form-data">
            <div class="bk-form__wrapper">
                @csrf
                @isset($member) @method('PUT') @endisset

                <!-- group_id -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="">
                        {{ __('_field.group') }}
                    </label>
                    <div class="bk-form__text">
                        @isset($member)
                        {{ $member->group->title->name }}
                        {{ $member->group->category->name }}
                        @else
                        <input type="hidden"
                               id="group_id"
                               name="group_id"
                               value="{{ old('group_id', $group->id) }}"
                               data-from="{{ $group->from }}"
                               data-till="{{ $group->till }}">
                        {{ $group->title->name }}
                        {{ $group->category->name }}
                        {{ $group->age_from . '-' . $group->age_till . ' лет' }}
                        @endisset
                    </div>
                </div>

                <!-- form_study -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="">
                        {{ __('_field.study') }}
                    </label>
                    <div class="bk-form__text">
                        @isset($member)
                        {{ $member->form_study == 1 ? __('_field.paid') : __('_field.free') }}
                        @else
                        <input type="hidden"
                               id="form_study"
                               name="form_study"
                               value="{{ old('form_study', $form_study['id']) }}">
                        {{ $form_study['id'] == 1 ? __('_field.paid') : __('_field.free') }}
                        @endisset
                    </div>
                </div>

                <!-- last_name -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="last_name">
                        {{ __('_field.last_name') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 is-string"
                           id="last_name"
                           type="text"
                           name="last_name"
                           value="{{ old('last_name', isset($member) ? $member->last_name : null) }}"
                           required
                           autocomplete="off"/>
                </div>

                <!-- first_name -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="first_name">
                        {{ __('_field.first_name') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 is-string"
                           id="first_name"
                           type="text"
                           name="first_name"
                           value="{{ old('first_name', isset($member) ? $member->first_name : null) }}"
                           required
                           autocomplete="off"/>
                </div>

                <!-- middle_name -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="middle_name">
                        {{ __('_field.middle_name') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 is-string"
                           id="middle_name"
                           type="text"
                           name="middle_name"
                           value="{{ old('middle_name', isset($member) ? $member->middle_name : null) }}"
                           autocomplete="off"/>
                </div>

                <!-- doc_id -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="doc_id">
                        {{ __('_field.doc_type') }} {{ @mandatory() }}
                    </label>
                    <select class="bk-form__select bk-max-w-300"
                            id="doc_id"
                            name="doc_id"
                            required>
                        <option value="" disabled selected>{{ __('_select.doc') }}</option>
                        @foreach($docs as $doc)
                        <option value="{{ $doc->id }}"
                                @isset($member) @if($member->doc_id == $doc->id)
                                selected
                                @endif @endisset>
                            {{ $doc->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- doc_num -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="doc_num">
                        {{ __('_field.doc_num') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 is-number"
                           id="doc_num"
                           type="text"
                           name="doc_num"
                           value="{{ old('doc_num', isset($member) ? $member->doc_num : null) }}"
                           maxlength="10"
                           required
                           autocomplete="off"/>
                </div>

                <!-- doc_date -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="doc_date">
                        {{ __('_field.doc_date') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="doc_date"
                           type="date"
                           name="doc_date"
                           value="{{ old('doc_date', isset($member) ? $member->doc_date : null) }}"
                           required/>
                </div>

                <!-- doc_scan -->
                <div class="bk-form__field position-relative">
                    <label class="bk-form__label" for="doc_file">
                        {{ __('_field.doc_scan') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           type="text"
                           value="{{ isset($member->doc_file) ? $member->doc_note : null }}"
                           placeholder="{{ __('_field.file_not') }}"
                           disabled/>
                    <input class="bk-form__file bk-max-w-300"
                           data-file="upload"
                           type="file"
                           name="doc_file"
                           accept="image/*"/>
                </div>

                <!-- app_scan -->
                <div class="bk-form__field position-relative">
                    <label class="bk-form__label" for="app_file">
                        {{ __('_field.app_scan') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           type="text"
                           value="{{ isset($member->app_file) ? $member->app_note : null }}"
                           placeholder="{{ __('_field.file_not') }}"
                           disabled/>
                    <input class="bk-form__file bk-max-w-300"
                           data-file="upload"
                           type="file"
                           name="app_file"
                           accept="image/*"/>
                </div>

                <!-- consent -->
                <div class="bk-form__field position-relative">
                    <label class="bk-form__label" for="consent_file">
                        {{ __('_field.consent') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           type="text"
                           value="{{ isset($member->consent_file) ? $member->consent_note : null }}"
                           placeholder="{{ __('_field.file_not') }}"
                           disabled/>
                    <input class="bk-form__file bk-max-w-300"
                           data-file="upload"
                           type="file"
                           name="consent_file"
                           accept="image/*"/>
                </div>

                <!-- birthday -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="birthday">
                        {{ __('_field.birthday') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="birthday"
                           type="date"
                           name="birthday"
                           value="{{ old('birthday', isset($member) ? $member->birthday : null) }}"
                           required/>
                </div>

                <!-- phone -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="phone">
                        {{ __('_field.phone') }}
                        {{ @mandatory() }}
                        {{ @tip('+7 776 123 45 67') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 is-phone"
                           id="phone"
                           type="tel"
                           name="phone"
                           value="{{ old('phone', isset($member) ? $member->phone : null) }}"
                           pattern="[+]7 [0-9]{3} [0-9]{3} [0-9]{2} [0-9]{2}"
                           maxlength="16"
                           required
                           autocomplete="off"/>
                </div>

                <!-- email -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="email">
                        {{ __('_field.email') }}
                        {{ @tip('example@dance.ru') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="email"
                           type="email"
                           name="email"
                           value="{{ old('email', isset($member) ? $member->email : null) }}"
                           autocomplete="off"/>
                </div>

                <!-- discount_id -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="discount_id">
                        {{ __('_field.cat_privileges') }}
                    </label>
                    <select class="bk-form__select bk-max-w-300"
                            id="discount_id"
                            name="discount_id">
                        <option value="" disabled selected>{{ __('_select.privileges') }}</option>
                        @foreach($discounts as $discount)
                        <option value="{{ $discount->id }}"
                                @isset($member) @if($member->discount_id == $discount->id)
                                selected
                                @endif @endisset>
                            @if($discount->size)
                            {{ $discount->name . ', '}}
                            {{ $discount->size . '%' }}
                            @else
                            {{ __('_field.no_privileges') }}
                            @endif
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- discount_doc -->
                <div class="bk-form__field position-relative">
                    <label class="bk-form__label" for="discount_doc">
                        {{ __('_field.discount_doc') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           type="text"
                           value="{{ isset($member->discount_doc) ? $member->discount_note : null }}"
                           placeholder="{{ __('_field.file_not') }}"
                           disabled/>
                    <input class="bk-form__file bk-max-w-300"
                           data-file="upload"
                           type="file"
                           name="discount_doc"
                           accept="image/*"/>
                </div>

                <!-- address_fact -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="address_fact">
                        {{ __('_field.address_fact') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="address_fact"
                           type="text"
                           name="address_fact"
                           value="{{ old('address_fact', isset($member) ? $member->address_fact : null) }}"/>
                </div>

                <!-- address_doc -->
                <div class="bk-form__field position-relative">
                    <label class="bk-form__label" for="address_doc">
                        {{ __('_field.address_doc') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           type="text"
                           value="{{ isset($member->address_doc) ? $member->address_note : null }}"
                           placeholder="{{ __('_field.file_not') }}"
                           disabled/>
                    <input class="bk-form__file bk-max-w-300"
                           data-file="upload"
                           type="file"
                           name="address_doc"
                           accept="image/*"/>
                </div>

                <!-- activity -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="activity">
                        {{ __('_field.activity') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="activity"
                           type="text"
                           name="activity"
                           value="{{ old('activity', isset($member) ? $member->activity : null) }}"/>
                </div>

                <div class="mt-1 mb-0 form-group">
                    <button class="btn btn-outline-success">
                        {{ __('_action.save') }}
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.members.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
