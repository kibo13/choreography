<div class="bk-modal" id="bk-timetable-modal">
    <div class="bk-modal-wrapper">
        <form action="{{ route('admin.timetable.edit') }}" method="POST">
            @csrf

            <h6 class="bk-modal-header">
                {{ __('_record.editing') }}
            </h6>

            <div class="bk-modal-content is-validation">

                <!-- timetable_id -->
                <input type="hidden" data-field="timetable-id" name="timetable_id">

                <!-- group -->
                <div class="mb-2">
                    <label class="m-0 font-weight-bold" for="group">
                        {{ __('_field.group') }}
                    </label>
                    <input class="form-control form-control-sm"
                           id="group"
                           type="text"
                           data-field="group"
                           disabled>
                </div>

                <!-- category -->
                <div class="mb-2">
                    <label class="m-0 font-weight-bold" for="category">
                        {{ __('_field.category') }}
                    </label>
                    <input class="form-control form-control-sm"
                           id="category"
                           type="text"
                           data-field="category"
                           disabled>
                </div>

                <!-- room -->
                <div class="mb-2">
                    <label class="m-0 font-weight-bold" for="room">
                        {{ __('_field.room') }}
                    </label>
                    <input class="form-control form-control-sm"
                           id="room"
                           type="text"
                           data-field="room"
                           disabled>
                </div>

                <!-- time_lesson -->
                <div class="mb-2">
                    <label class="m-0 font-weight-bold" for="time_lesson">
                        {{ __('_field.time_lesson') }}
                    </label>
                    <input class="form-control form-control-sm"
                           id="time_lesson"
                           type="text"
                           data-field="time_lesson"
                           disabled>
                </div>

                <!-- worker_id -->
                <div>
                    <label class="m-0 font-weight-bold" for="worker_id">
                        {{ __('_field.teacher') }} {{ @mandatory() }}
                    </label>
                    <select class="form-control form-control-sm"
                            id="teacher_id"
                            data-field="teacher-id"
                            name="worker_id"
                            required>
                        <option value="" disabled selected>{{ __('_select.teacher') }}</option>
                        @foreach(@getTeachersBySpec() as $teacher)
                        <option value="{{ $teacher->id }}">
                            {{ @command_master($teacher) }}
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
