@if(@is_access('timetable_full') && $is_director)
<form class="my-2 bk-form" action="{{ route('admin.timetable.generate') }}" method="GET">
    <div class="bk-form__wrapper">
        <div class="bk-grid bk-grid--gtc-150">
            <input class="form-control" type="month" name="month" required>
            <button class="btn btn-sm btn-primary">
                {{ __('_action.generate') }}
            </button>
        </div>
    </div>
</form>
@endif

@if(session()->has('success'))
<div class="my-2 alert alert-success" role="alert">
    {{ session()->get('success') }}
</div>
@endif

@if(session()->has('warning'))
<div class="my-2 alert alert-warning" role="alert">
    {{ session()->get('warning') }}
</div>
@endif

<input type="hidden" id="is_director" value="{{ $is_director }}">
<div id="timetable-calendar"></div>
