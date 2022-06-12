<div class="bk-modal" id="bk-topic-modal">
    <div class="bk-modal-wrapper">
        <form action="{{ route('admin.visits.topic') }}" method="POST">
            @csrf

            <h6 class="bk-modal-header">Тема занятия</h6>

            <div class="bk-modal-content">

                <!-- timetable_id -->
                <input type="hidden" id="timetable_id" name="timetable_id" value="">

                <!-- method_id -->
                <div class="mb-2">
                    <label class="m-0 font-weight-bold" for="method_id">
                        {{ __('_field.topic') }} {{ @mandatory() }}
                    </label>
                    <select class="form-control form-control-sm"
                            id="method_id"
                            name="method_id"
                            required>
                        <option value="" disabled selected>{{ __('_select.topic') }}</option>
                        @foreach(@getMethodsByParams($group, $numMonth) as $method)
                        <option value="{{ $method->id }}">
                            {{ $method->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <!-- note -->
                <div class="mb-2">
                    <label class="m-0 font-weight-bold" for="note">
                        {{ __('_field.note') }}
                    </label>
                    <input class="form-control form-control-sm"
                           type="text"
                           id="note"
                           name="note">
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
