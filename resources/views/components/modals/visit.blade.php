<div class="bk-modal" id="bk-visit-modal">
    <div class="bk-modal-wrapper">
        <form action="{{ route('admin.visits.control') }}" method="POST">
            @csrf

            <h6 class="bk-modal-header">Отметка о посещений</h6>

            <div class="bk-modal-content">

                <!-- action -->
                <input type="hidden" id="action_visit" name="action" value="">

                <!-- timetable_id -->
                <input type="hidden" id="lesson_id" name="timetable_id" value="">

                <!-- member_id -->
                <input type="hidden" id="member_id" name="member_id" value="">

                <!-- status -->
                <div class="mb-2">
                    <label class="m-0 font-weight-bold" for="status">
                        {{ __('_field.mark') }} {{ @mandatory() }}
                    </label>
                    <select class="form-control form-control-sm"
                            id="status"
                            name="status"
                            required>
                        <option value="" disabled selected>{{ __('_select.check') }}</option>
                        <option value="0">{{ __('_action.miss') }}</option>
                        <option value="1">{{ __('_action.present') }}</option>
                    </select>
                </div>

                <!-- reason -->
                <div class="mb-2">
                    <label class="m-0 font-weight-bold" for="reason">
                        {{ __('_field.note') }}
                    </label>
                    <input class="form-control form-control-sm"
                           type="text"
                           id="reason"
                           name="reason">
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
