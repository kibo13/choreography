@foreach($groups as $index => $group)
    <tr>
        <td>{{ ++$index }}</td>
        <td>
            <p class="m-0 text-uppercase">
                <strong>
                    {{ $group->title->name }}
                </strong>
            </p>
            <p class="m-0 text-info">
                {{ $group->title->is_paid ? __('_field.paid_group') : __('_field.free_group')  }}
            </p>
        </td>
        <td class="align-middle text-center">
            {{ $group->category->name }}
        </td>
        <td class="align-middle text-center">
            {{ $group->basic_seats ? $group->basic_seats : '-' }}
        </td>
        <td class="align-middle text-center">
            {{ $group->extra_seats ? $group->extra_seats : '-' }}
        </td>
        <td class="align-middle text-center">
            {{ $group->age_from }}
        </td>
        <td class="align-middle text-center">
            {{ $group->age_till > 50 ? '-' : $group->age_till }}
        </td>
        <td class="align-middle text-center">
            {{ $group->price ? @double($group->price, 0) . ' ₽' : '-' }}
        </td>
        <td class="align-middle text-center">
            {{ $group->lessons ? $group->lessons : '-' }}
        </td>
        @if(@is_access('group_full'))
        <td class="align-middle">
            <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
               href="{{ route('admin.groups.edit', $group) }}"
               data-tip="{{ __('_action.edit') }}" ></a>
        </td>
        @endif
    </tr>
@endforeach
