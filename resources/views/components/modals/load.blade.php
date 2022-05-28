<div class="bk-modal" id="bk-load-modal">
    <div class="bk-modal-wrapper">
        <form action="{{ route('admin.loads.action') }}" method="POST">
            @csrf

            <h6 class="bk-modal-header">Настройка</h6>

            <div class="bk-modal-content is-validation">

                <!-- create or update -->
                <input type="hidden" id="action" name="action" value="">

                <!-- group_id -->
                <input type="hidden" id="group_id" name="group_id" value="">

                <!-- day_of_week -->
                <input type="hidden" id="day_of_week" name="day_of_week" value="">

                <!-- start -->
                <div class="mb-2">
                    <label class="m-0 font-weight-bold" for="start">
                        {{ __('_field.start_lesson') }} {{ @mandatory() }}
                    </label>
                    <input class="form-control form-control-sm"
                           id="start"
                           type="time"
                           name="start"
                           value=""
                           required>
                </div>

                <!-- duration -->
                <div class="mb-2">
                    <label class="m-0 font-weight-bold" for="duration">
                        {{ __('_field.hours_per') }} {{ @mandatory() }}
                    </label>
                    <input class="form-control form-control-sm is-number"
                           id="duration"
                           type="text"
                           name="duration"
                           value=""
                           maxlength="1"
                           required>
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
