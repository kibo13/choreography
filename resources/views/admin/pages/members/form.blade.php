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

                <!-- last_name -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="last_name">
                        {{ __('_field.last_name') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 is-string"
                           id="last_name"
                           type="text"
                           name="last_name"
                           value="{{ isset($member) ? $member->last_name : null }}"
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
                           value="{{ isset($member) ? $member->first_name : null }}"
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
                           value="{{ isset($member) ? $member->middle_name : null }}"
                           autocomplete="off"/>
                </div>

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
                                data-from="{{ $group->age_from }}"
                                data-till="{{ $group->age_till }}"
                                @isset($member) @if($member->group_id == $group->id)
                                selected
                                @endif @endisset>
                            {{ $group->title->name }}
                            {{ $group->category->name }}
                            {{ $group->age_from . '-' . $group->age_till . ' лет' }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- form_study -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="form_study">
                        {{ __('_field.study') }} {{ @mandatory() }}
                    </label>
                    <select class="bk-form__select bk-max-w-300"
                            id="form_study"
                            name="form_study"
                            required>
                        <option value="" disabled selected>{{ __('_select.study') }}</option>
                        @foreach($studies as $index => $study)
                        <option value="{{ $index }}"
                                @isset($member) @if($member->form_study == $index)
                                selected
                                @endif @endisset>
                            {{ $study }}
                        </option>
                        @endforeach
                    </select>
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
                           value="{{ isset($member) ? $member->doc_num : null }}"
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
                           value="{{ isset($member) ? $member->doc_date : null }}"
                           required/>
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
                           value="{{ isset($member) ? $member->birthday : null }}"
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
                           value="{{ isset($member) ? $member->phone : null }}"
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
                           value="{{ isset($member) ? $member->email : null }}"
                           autocomplete="off"/>
                </div>

                <!-- discount_id -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="discount_id">
                        {{ __('_field.discount_person') }}
                    </label>
                    <select class="bk-form__select bk-max-w-300"
                            id="discount_id"
                            name="discount_id">
                        <option value="" disabled selected>{{ __('_select.discount') }}</option>
                        @foreach($discounts as $discount)
                        <option value="{{ $discount->id }}"
                                @isset($member) @if($member->discount_id == $discount->id)
                                selected
                                @endif @endisset>
                            @if($discount->size)
                            {{ $discount->name . ', '}}
                            {{ $discount->size . '%' }}
                            @else
                            {{ __('_field.discount_no') }}
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
                           id="upload-file"
                           type="text"
                           value="{{ isset($member->discount_doc) ? $member->discount_note : null }}"
                           placeholder="{{ __('_field.file_not') }}"
                           disabled/>
                    <input class="bk-form__file bk-max-w-300"
                           id="upload-btn"
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
                           value="{{ isset($member) ? $member->address_fact : null }}"/>
                </div>

                <!-- address_doc -->
                <div class="bk-form__field position-relative">
                    <label class="bk-form__label" for="address_doc">
                        {{ __('_field.address_doc') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="upload-file"
                           type="text"
                           value="{{ isset($member->address_doc) ? $member->address_note : null }}"
                           placeholder="{{ __('_field.file_not') }}"
                           disabled/>
                    <input class="bk-form__file bk-max-w-300"
                           id="upload-btn"
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
                           value="{{ isset($member) ? $member->activity : null }}"/>
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
