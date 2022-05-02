@extends('admin.index')
@section('title-admin', __('_section.workers'))
@section('content-admin')
    <section id="workers-form" class="overflow-auto is-validation">
        <h3>{{ @form_title($worker) }}</h3>
        <form class="bk-form"
              action="{{ @is_update($worker, 'admin.workers') }}"
              method="POST">
            <div class="bk-form__wrapper">
                @csrf
                @isset($worker) @method('PUT') @endisset

                <!-- last_name -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="last_name">
                        {{ __('_field.last_name') }} {{ @mandatory() }}
                    </label>
                    <input class="bk-form__input bk-max-w-300 is-string"
                           id="last_name"
                           type="text"
                           name="last_name"
                           value="{{ isset($worker) ? $worker->last_name : null }}"
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
                           value="{{ isset($worker) ? $worker->first_name : null }}"
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
                           value="{{ isset($worker) ? $worker->middle_name : null }}"
                           autocomplete="off"/>
                </div>

                <!-- position -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="role">
                        {{ __('_field.position') }} {{ @mandatory() }}
                    </label>
                    @isset($worker)
                    <div class="bk-form__text">
                        {{ $worker->user->role->name }}
                    </div>
                    @else
                    <select class="bk-form__select bk-max-w-300" id="role" name="role_id" required>
                        <option value="" disabled selected>{{ __('_select.position') }}</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}"
                                @isset($worker) @if($worker->user->role_id == $role->id)
                                selected
                                @endif @endisset>
                            {{ $role->name }}
                        </option>
                        @endforeach
                    </select>
                    @endisset
                </div>

                <!-- groups -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="">
                        {{ __('_field.groups') }}
                    </label>
                    <div class="bk-form__list">
                        @foreach($groups as $index => $group)
                        <div class="bk-form__list-item">
                            <input class="bk-form__list-checkbox"
                                   id="{{ $group->id }}"
                                   type="checkbox"
                                   name="groups[]"
                                   value="{{ $group->id }}"
                                   @isset($worker) @if($worker->groups->where('id', $group->id)->count())
                                   checked
                                   @endif @endisset>
                            <label class="bk-form__list-label" for="{{ $group->id }}">
                                {{ $group->title->name }}
                                {{ $group->category_id == 4 ? null : @tip($group->category->name) }}
                            </label>
                        </div>
                        @endforeach
                    </div>
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
                           value="{{ isset($worker) ? $worker->birthday : null }}"
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
                           value="{{ isset($worker) ? $worker->phone : null }}"
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
                           value="{{ isset($worker) ? $worker->email : null }}"
                           autocomplete="off"/>
                </div>

                <!-- address -->
                <div class="bk-form__field">
                    <label class="bk-form__label" for="address">
                        {{ __('_field.address') }}
                    </label>
                    <input class="bk-form__input bk-max-w-300"
                           id="address"
                           type="text"
                           name="address"
                           value="{{ isset($worker) ? $worker->address : null }}"/>
                </div>

                <div class="mt-1 mb-0 form-group">
                    <button class="btn btn-outline-success">
                        {{ __('_action.save') }}
                    </button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.workers.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </form>
    </section>
@endsection
