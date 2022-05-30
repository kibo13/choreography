<table class="dataTables table table-bordered table-hover table-responsive">
    <thead class="thead-light">
        <tr class="text-center">
            <th class="bk-min-w-250 w-100">{{ __('_field.labels') }}</th>
            <th class="bk-min-w-100">{{ __('_field.time') }}</th>
            @foreach($daysOfWeek as $day)
            <th class="text-center bk-min-w-100">{{ $day['shortname'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        <tr>
            <td rowspan="17">
                @foreach($titles as $title)
                <div class="mb-3">
                    <h5 class="text-uppercase">
                        {{ $title->name }}
                    </h5>
                    <p class="m-0 font-weight-bold">
                        {{ $title->specialty->name }}
                    </p>
                    <p class="m-0 text-info">
                        {{ $title->is_paid ? __('_field.paid_group') : __('_field.free_group')  }}
                    </p>
                    <ul style="display: grid; grid-gap: 5px;">
                        @foreach($title->groups as $group)
                        <li class="py-1 px-2 text-white rounded" style="background: {{ $group->color }};">
                            {{ $group->category->name }}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </td>
        </tr>
        @foreach($dayByHours as $index => $hour)
        @if($index > 5 && $index < 22)
        <tr class="text-center">
            <td>
                <strong>{{ $hour }}</strong>
            </td>
            @foreach($daysOfWeek as $day)
            <td class="align-middle">
                <ul>
                    @foreach(@getLoadsByDayOfWeek($day['id']) as $load)
                    @if(@fillHours($hour, $load->start, $load->duration))
                    <li class="text-white"
                        style="background: {{ $load->group->color }}; cursor: pointer;"
                        title="{{ $load->group->title->name . ' / ' . $load->group->category->name }}">
                        {{ $load->room->num }}
                    </li>
                    @endif
                    @endforeach
                </ul>
            </td>
            @endforeach
        </tr>
        @endif
        @endforeach
    </tbody>
</table>
