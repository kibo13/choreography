<div class="bk-chart">
    <button class="btn btn-sm btn-outline-primary"
            data-chart="years"
            data-years="{{ $years }}"
            data-total="{{ $total }}">
        {{ __('_action.reset') }}
    </button>
    @foreach($years as $year)
    <button class="btn btn-sm btn-outline-primary"
            data-chart="year"
            data-year="{{ $year }}"
            data-months="{{ @getAchievementsByMonths($year, $worker) }}">
        {{ $year . ' год'}}
    </button>
    @endforeach
</div>

<canvas id="achievements-chart"></canvas>
