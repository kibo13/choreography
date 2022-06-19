<table class="dataTables table table-bordered table-hover table-responsive">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th class="bk-min-w-250 w-100">{{ __('_field.group') }}</th>
            <th class="text-center bk-min-w-100">{{ __('_field.category') }}</th>
            <th class="text-center bk-min-w-100" title="{{ __('_field.hours_per_month') }}">
                {{ __('_field.month') }} {{ @fa('fa-info-circle') }}
            </th>
            <th class="text-center bk-min-w-100" title="{{ __('_field.hours_per_week') }}">
                {{ __('_field.week') }} {{ @fa('fa-info-circle') }}
            </th>
            @foreach($daysOfWeek as $day)
            <th class="text-center bk-min-w-100">{{ $day['shortname'] }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
    @foreach($titles as $index => $title)
        @foreach($title->groups as $group)
        <tr class="text-center">
            <td>{{ ++$index }}</td>
            <td class="text-left">
                <ul>
                    <li class="text-uppercase font-weight-bold">
                        {{ $title->name }}
                    </li>
                    <li>
                        {{ $title->specialty->name }}
                    </li>
                    <li class="text-info">
                        {{ $title->is_paid ? __('_field.paid_group') : __('_field.free_group')  }}
                    </li>
                </ul>
            </td>
            <td class="align-middle">
                {{ $group->category->name }}
            </td>
            <td class="align-middle">
                @if($group->workload)
                {{ $group->workload }}
                {{ @tip('ч') }}
                @else
                {{ @tip('-') }}
                @endif
            </td>
            <td class="align-middle">
                @if($group->workload)
                {{ $group->workload / 4 }}
                {{ @tip('ч') }}
                @else
                {{ @tip('-') }}
                @endif
            </td>
            @foreach($daysOfWeek as $day)
            <td class="align-middle">
                @if(@is_access('load_full'))
                @if(@load($group, $day['id']))
                <button class="text-secondary font-weight-bold"
                        data-load="set"
                        data-action="update"
                        data-group="{{ $group->id }}"
                        data-dow="{{ $day['id'] }}"
                        data-room-id="{{ $group->room_id }}"
                        data-room-num="{{ $group->room->num }}"
                        data-start="{{ @load($group, $day['id'], 'start') }}"
                        data-duration="{{ @load($group, $day['id'], 'duration') }}"
                        title="{{ __('_action.edit') }}">
                    {{ @load($group, $day['id'], 'duration') . ' ч' }}
                </button>
                {{ '/' }}
                <button class="bk-btn-action--delete text-danger"
                        data-id="{{ @load($group, $day['id'], 'id') }}"
                        data-toggle="modal"
                        data-target="#bk-delete-modal"
                        title="{{ __('_action.reset') }}">
                    ✖
                </button>
                @else
                <button class="text-primary"
                        data-load="set"
                        data-action="create"
                        data-group="{{ $group->id }}"
                        data-dow="{{ $day['id'] }}"
                        data-room-id="{{ $group->room_id }}"
                        data-room-num="{{ $group->room->num }}">
                    {{ __('_action.set') }}
                </button>
                @endif
                @else
                @if(@load($group, $day['id']))
                <span class="text-secondary font-weight-bold">
                    {{ @load($group, $day['id'], 'duration') . ' ч' }}
                </span>
                @else
                {{ @tip('-') }}
                @endif
                @endif
            </td>
            @endforeach
        </tr>
        @endforeach
    @endforeach
    </tbody>
</table>
