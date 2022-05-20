<div class="bk-modal" id="bk-event-modal">
    <div class="bk-modal-wrapper">
        <form action="{{ route('admin.events.store') }}" method="POST">
            @csrf

            <h6 class="bk-modal-header">Новое событие</h6>

            <div class="bk-modal-content">

                <!-- created_from -->
                <input type="hidden" name="created_from" value="modal">

                <!-- type -->
                <div class="mb-2">
                    <label class="m-0 font-weight-bold" for="">
                        {{ __('_field.type') }} {{ @mandatory() }}
                    </label>
                    <select class="form-control form-control-sm" name="type" required>
                        <option value="" disabled selected>{{ __('_select.type') }}</option>
                        <option value="0">{{ __('_field.town') }}</option>
                        <option value="1">{{ __('_field.international') }}</option>
                    </select>
                </div>

                <!-- name -->
                <div class="mb-2">
                    <label class="m-0 font-weight-bold" for="">
                        {{ __('_field.name') }} {{ @mandatory() }}
                    </label>
                    <input class="form-control form-control-sm"
                           type="text"
                           name="name"
                           value=""
                           required
                           autocomplete="off">
                </div>

                <!-- from -->
                <div class="mb-2">
                    <label class="m-0 font-weight-bold" for="">
                        {{ __('_field.date_from') }} {{ @mandatory() }}
                    </label>
                    <input class="form-control form-control-sm"
                           type="date"
                           name="from"
                           data-modal="from"
                           value=""
                           required>
                </div>

                <!-- till -->
                <div class="mb-2" id="field-end">
                    <label class="m-0 font-weight-bold" for="">
                        {{ __('_field.date_till') }}
                    </label>
                    <input class="form-control form-control-sm"
                           type="date"
                           name="till"
                           data-modal="till"
                           value="">
                </div>

                <!-- place -->
                <div class="mb-2">
                    <label class="m-0 font-weight-bold" for="">
                        {{ __('_field.place') }} {{ @mandatory() }}
                    </label>
                    <input class="form-control form-control-sm"
                           type="text"
                           name="place"
                           value=""
                           required>
                </div>

                <!-- description -->
                <div class="mb-2">
                    <label class="m-0 font-weight-bold" for="">
                        {{ __('_field.desc') }}
                    </label>
                    <textarea class="form-control" name="description"></textarea>
                </div>

                <!-- group -->
                <div class="">
                    <label class="m-0 font-weight-bold" for="">
                        {{ __('_field.group') }} {{ @mandatory() }}
                    </label>
                    <select class="form-control form-control-sm" name="group_id" required>
                        <option value="" disabled selected>{{ __('_select.group') }}</option>
                        @foreach(@getGroupsByDirector() as $group)
                        <option value="{{ $group->id }}">
                            {{ $group->title->name }}
                            {{ $group->category_id == 4 ? null : ' / ' .  $group->category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="bk-modal-footer">
                <button class="btn btn-sm btn-outline-success"
                        type="submit"
                        data-modal="submit">
                    {{ __('_action.save') }}
                </button>
                <button class="btn btn-sm btn-outline-secondary"
                        type="button"
                        data-modal="close">
                    {{ __('_action.cancel') }}
                </button>
            </div>
        </form>
    </div>
</div>
