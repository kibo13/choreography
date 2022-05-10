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
              method="POST">
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
                        {{ __('_field.study') }} {{ @mandatory() }}
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
