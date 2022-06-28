<form class="my-2 bk-report bk-form rounded d-none"
      id="{{ 'report-' . $reports[14]['href'] }}"
      data-id="{{ $reports[14]['id'] }}"
      action="{{ route('admin.reports.' . $reports[14]['href']) }}"
      method="GET">

    <div class="bk-form__wrapper">

        <!-- group -->
        @if(Auth::user()->role_id < 3 || Auth::user()->role_id == 4)
        <div class="bk-form__field">
            <label class="bk-form__label" for="">
                {{ __('_field.group') }} {{ @mandatory() }}
            </label>
            <select class="bk-form__select bk-max-w-300" name="title_id" required>
                <option value="" disabled selected>
                    {{ __('_select.group') }}
                </option>
                @foreach(@getTitles() as $title)
                <option value="{{ $title->id }}">
                    {{ $title->name }}
                </option>
                @endforeach
            </select>
        </div>
        @endif

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
            <button class="btn btn-primary" id="{{ 'report-' . $reports[14]['id'] . '-run' }}">
                {{ __('_action.generate') }}
            </button>
        </div>

    </div>
</form>
