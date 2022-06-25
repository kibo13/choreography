<div class="my-2 bk-callout">
    <h5>Обозначение мест</h5>
    <hr>
    <p class="my-1 font-weight-bold">Бюджетные места</p>
    <div class="bk-places-mark">
        <div class="bk-places-cell bk-places-cell--free"></div>
        <div>Место свободно</div>
    </div>
    <div class="bk-places-mark">
        <div class="bk-places-cell bk-places-cell--free-fill"></div>
        <div>Место занято</div>
    </div>
    <p class="my-1 font-weight-bold">Платные места</p>
    <div class="bk-places-mark">
        <div class="bk-places-cell bk-places-cell--paid"></div>
        <div>Место свободно</div>
    </div>
    <div class="bk-places-mark">
        <div class="bk-places-cell bk-places-cell--paid-fill"></div>
        <div>Место занято</div>
    </div>
</div>

@foreach($groups as $group)
<h5 class="bk-places-group">
    @if(@is_access('member_full') && Auth::user()->role_id == 3)
    <button class="text-primary" data-toggle="dropdown">
        [Добавить участника]
    </button>
    <div class="p-0 dropdown-menu">
        @if($group->age_till > 18)
        <button class="py-1 px-2 dropdown-item"
                data-group-id="{{ $group->id }}"
                data-group-name="{{ $group->title->name }}"
                data-group-category="{{ $group->category->name }}"
                data-age-from="{{ $group->age_from }}"
                data-age-till="{{ $group->age_till }}"
                data-basic-places-limit="{{ $group->basic_seats }}"
                data-basic-places-exist="{{ $group->members->where('form_study', 0)->count() }}"
                data-extra-places-limit="{{ $group->extra_seats }}"
                data-extra-places-exist="{{ $group->members->where('form_study', 1)->count() }}"
                data-total-extra-places-exist="{{ @getTotalExtraPlacesByTitle($group->title->id) }}"
                data-modal="legal"
                data-legal="{{ $modals[1]['code'] }}">
            {{ $modals[1]['name'] }}
        </button>
        @else
        @foreach($modals as $modal)
        <button class="py-1 px-2 dropdown-item"
                data-group-id="{{ $group->id }}"
                data-group-name="{{ $group->title->name }}"
                data-group-category="{{ $group->category->name }}"
                data-age-from="{{ $group->age_from }}"
                data-age-till="{{ $group->age_till }}"
                data-basic-places-limit="{{ $group->basic_seats }}"
                data-basic-places-exist="{{ $group->members->where('form_study', 0)->count() }}"
                data-extra-places-limit="{{ $group->extra_seats }}"
                data-extra-places-exist="{{ $group->members->where('form_study', 1)->count() }}"
                data-total-extra-places-exist="{{ @getTotalExtraPlacesByTitle($group->title->id) }}"
                data-modal="legal"
                data-legal="{{ $modal['code'] }}">
            {{ $modal['name'] }}
        </button>
        @endforeach
        @endif
    </div>
    @endif
    {{ $group->title->name }}
    {{ @tip($group->category->name) }}
</h5>
<hr class="my-2">
<ul class="bk-places-row">
@for($i = 1; $i <= $group->basic_seats; $i++)
    @if($i <= $group->members->where('form_study', 0)->count())
    <li class="bk-places-cell bk-places-cell--free-fill">
        {{ $i }}
    </li>
    @else
    <li class="bk-places-cell bk-places-cell--free">
        {{ $i }}
    </li>
    @endif
@endfor
@for($i = 1; $i <= $group->extra_seats; $i++)
    @if($i <= $group->members->where('form_study', 1)->count())
    <li class="bk-places-cell bk-places-cell--paid-fill">
        {{ $i }}
    </li>
    @else
    <li class="bk-places-cell bk-places-cell--paid">
        {{ $i }}
    </li>
    @endif
@endfor
</ul>
@endforeach
