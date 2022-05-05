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
    {{ $group->title->name }}
    {{ @tip($group->category->name) }}
</h5>
<hr class="my-2">
<ul class="bk-places-row">
@for($i = 1; $i <= $group->basic_seats + $group->extra_seats; $i++)
    @if($i <= $group->members->count())
    <li class="bk-places-cell bk-places-cell--free-fill">
        {{ $i }}
    </li>
    @elseif($i <= $group->basic_seats)
    <li class="bk-places-cell bk-places-cell--free">
        {{ $i }}
    </li>
    @elseif($i > $group->basic_seats)
    @if($group->members->count() - $i >= 0)
    <li class="bk-places-cell bk-places-cell--paid-fill">
        {{ $i }}
    </li>
    @else
    <li class="bk-places-cell bk-places-cell--paid">
        {{ $i }}
    </li>
    @endif
    @endif
@endfor
</ul>
@endforeach
