<form class="my-2 bk-report bk-form rounded d-none"
      id="{{ 'report-' . $reports[3]['href'] }}"
      data-id="{{ $reports[3]['id'] }}"
      action="{{ route('admin.reports.' . $reports[3]['href']) }}"
      method="GET">

    <div class="bk-form__wrapper">

        <!-- period -->
        <div class="bk-form__field">
            <label class="bk-form__label">
                {{ __('_field.period') }}
            </label>
            <div class="bk-grid bk-grid--gtc-150">
                <input class="bk-form__input"
                       id="report-from"
                       type="date"
                       name="from"
                       value="{{ request()->from ? request()->from : null }}"
                       required/>
                <input class="bk-form__input"
                       id="report-till"
                       type="date"
                       name="till"
                       value="{{ request()->till ? request()->till : null }}"
                       required/>
            </div>
        </div>

        <div class="mt-1 mb-0">
            <button class="btn btn-primary" id="{{ 'report-' . $reports[3]['id'] . '-run' }}">
                {{ __('_action.generate') }}
            </button>
        </div>

    </div>
</form>
