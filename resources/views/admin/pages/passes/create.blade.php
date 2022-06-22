@extends('admin.index')
@section('title-admin', __('_section.passes'))
@section('content-admin')
    <section id="passes-create" class="overflow-auto">
        <h3>{{ __('_record.new') }}</h3>

        @if(session()->has('warning'))
        <div class="my-2 alert alert-warning" role="alert">
            {{ session()->get('warning') }}
        </div>
        @endif

        <form class="bk-form" action="{{ route('admin.passes.store') }}" method="POST">
            <div class="bk-form__wrapper">
                @csrf

                <!-- member_id -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="member_id">
                        {{ __('_field.member') }} {{ @mandatory() }}
                    </label>
                    <select class="bk-form__select bk-max-w-300" id="member_id" name="member_id" required>
                        <option value="" disabled selected>{{ __('_select.member') }}</option>
                        @foreach($members as $member)
                        <option value="{{ $member->id }}">
                            {{ @full_fio('member', $member->id) }}
                            @if($member->discount)
                            {{ '/ скидка' . $member->discount->size . '%' }}
                            @endif
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- from -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="from">
                        {{ __('_field.month') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           type="month"
                           name="month"
                           required>
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
