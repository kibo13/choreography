@extends('admin.index')
@section('title-admin', __('_section.passes'))
@section('content-admin')
    <section id="passes-form" class="overflow-auto">
        <h3>{{ @form_title($pass) }}</h3>

        @if(session()->has('warning'))
        <div class="my-2 alert alert-warning" role="alert">
            {{ session()->get('warning') }}
        </div>
        @endif

        <form class="bk-form"
              action="{{ @is_update($pass, 'admin.passes') }}"
              method="POST"
              enctype="multipart/form-data">
            <div class="bk-form__wrapper">
                @csrf
                @isset($pass) @method('PUT') @endisset

                <!-- member_id -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="member_id">
                        {{ __('_field.member') }} {{ @mandatory() }}
                    </label>
                    @isset($pass)
                    <div class="bk-form__text">
                        {{ @full_fio('member', $pass->member->id) }}
                    </div>
                    @else
                    <select class="bk-form__select bk-max-w-300"
                            id="member_id"
                            name="member_id"
                            required>
                        <option value="" disabled selected>{{ __('_select.member') }}</option>
                        @foreach($members as $member)
                        <option value="{{ $member->id }}">
                            {{ @full_fio('member', $member->id) }}
                            @if($member->discount)
                            / скидка
                            {{ $member->discount->size . '%' }}
                            @endif
                        </option>
                        @endforeach
                    </select>
                    @endisset
                </div>

                <!-- from -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="from">
                        {{ __('_field.action_from') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="from"
                           type="date"
                           name="from"
                           value="{{ isset($pass) ? $pass->from : null }}"
                           required/>
                </div>

                <!-- till -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="till">
                        {{ __('_field.action_till') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="till"
                           type="date"
                           name="till"
                           value="{{ isset($pass) ? $pass->till : null }}"
                           required/>
                </div>

                <!-- discount -->
                @isset($pass)
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.discount') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $pass->member->discount->size > 0 ? $pass->member->discount->size . '%' : '-' }}
                    </div>
                </div>
                @endif

                <!-- price -->
                @isset($pass)
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.price') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $pass->member->group->price . ' ₽' }}
                    </div>
                </div>
                @endif

                <!-- cost -->
                @isset($pass)
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.total') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $pass->cost . ' ₽' }}
                    </div>
                </div>
                @endif

                <!-- status -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="status">
                        {{ __('_field.pay_status') }} {{ @mandatory() }}
                    </label>
                    <select class="bk-form__select bk-max-w-300"
                            id="status"
                            name="status"
                            required>
                        <option value="" disabled selected>{{ __('_select.payment') }}</option>
                        @foreach($payments as $index => $payment)
                        <option value="{{ $index }}"
                                @isset($pass) @if($pass->status == $index)
                                selected
                                @endif @endisset>
                            {{ $payment }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- pay_date -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="pay_date">
                        {{ __('_field.pay_date') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="pay_date"
                           type="date"
                           name="pay_date"
                           value="{{ isset($pass) ? $pass->pay_date : null }}"/>
                </div>

                <!-- pay_file -->
                <div class="bk-form__field position-relative">
                    <label class="bk-form__label" for="pay_file">
                        {{ __('_field.pay_file') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           type="text"
                           value="{{ isset($pass->pay_file) ? $pass->pay_note : null }}"
                           placeholder="{{ __('_field.file_not') }}"
                           disabled/>
                    <input class="bk-form__file bk-max-w-300"
                           data-file="upload"
                           type="file"
                           name="pay_file"
                           value="{{ isset($pass->pay_file) ? $pass->pay_file : null }}"
                           accept="image/*"/>
                </div>

                <div class="mt-1 mb-0 form-title">
                    <button class="btn btn-outline-success">
                        {{ __('_action.save') }}
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.passes.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
