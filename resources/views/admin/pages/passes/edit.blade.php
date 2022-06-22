@extends('admin.index')
@section('title-admin', __('_section.passes'))
@section('content-admin')
    <section id="passes-edit" class="overflow-auto">
        <h3>{{ __('_record.edit') }}</h3>

        @if(session()->has('success'))
        <div class="my-2 alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
        @endif

        <form class="bk-form"
              action="{{ route('admin.passes.update', $pass) }}"
              method="POST"
              enctype="multipart/form-data">
            <div class="bk-form__wrapper">
                @csrf
                @method('PUT')

                <!-- member_id -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="">
                        {{ __('_field.member') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @full_fio('member', $pass->member->id) }}
                    </div>
                </div>

                <!-- period -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="">
                        {{ __('_field.period_action') }}
                    </label>
                    <div class="bk-form__text">
                        {{ @getDMY($pass->from) . ' - ' . @getDMY($pass->till) }}
                    </div>
                </div>

                <!-- lessons -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.lessons') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $pass->lessons }}
                    </div>
                </div>

                <!-- cost -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.cost') }} {{ @tip('250 ₽ = 1 занятие') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $pass->lessons * 250 . ' ₽' }}
                    </div>
                </div>

                <!-- cost with discount -->
                @if($pass->member->discount_id && $pass->member->discount_id < 5)
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        Размер скидки
                    </label>
                    <div class="bk-form__text">
                        {{ $pass->member->discount->size . '%' }}
                    </div>
                </div>

                <div class="bk-form__field">
                    <label class="bk-form__label">
                        Стоимость c учетом скидки
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
                    @if($pass->status == 0)
                    <select class="bk-form__select bk-max-w-300" id="status" name="status" required>
                        <option value="" disabled selected>{{ __('_select.payment') }}</option>
                        @foreach($payments as $index => $payment)
                        <option value="{{ $index }}" @if($pass->status == $index) selected @endif>
                            {{ $payment }}
                        </option>
                        @endforeach
                    </select>
                    @else
                    <div class="bk-form__text">
                        <span class="text-success">
                            {{ $payments[$pass->status] }}
                        </span>
                    </div>
                    @endif
                </div>

                <!-- pay_date -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="pay_date">
                        {{ __('_field.pay_date') }} {{ @mandatory() }}
                    </label>
                    @if($pass->status == 0)
                    <input class="bk-form__input bk-max-w-300"
                           id="pay_date"
                           type="date"
                           name="pay_date"
                           value="{{ $pass->pay_date }}"
                           required/>
                    @else
                    <div class="bk-form__text">
                        {{ @getDMY($pass->pay_date) }}
                    </div>
                    @endif
                </div>

                <!-- pay_file -->
                <div class="bk-form__field position-relative">
                    <label class="bk-form__label" for="pay_file">
                        {{ __('_field.pay_file') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           type="text"
                           value="{{ $pass->pay_note }}"
                           placeholder="{{ __('_field.file_not') }}"
                           disabled/>
                    <input class="bk-form__file bk-max-w-300"
                           data-file="upload"
                           type="file"
                           name="pay_file"
                           value="{{ $pass->pay_file }}"
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
