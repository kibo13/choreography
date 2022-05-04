@foreach($titles as $index => $title)
    <tr>
        <td rowspan="4">{{ ++$index }}</td>
        <td rowspan="4">
            <h5 class="text-uppercase">
                {{ $title->name }}
            </h5>
            <p class="m-0 font-weight-bold">
                {{ $title->specialty->name }}
            </p>
            <p class="m-0 text-info">
                {{ $title->is_paid ? __('_field.paid') : __('_field.free')  }}
            </p>
        </td>
    </tr>
    @foreach($title->groups as $group)
    <tr>
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
            <a class="bk-btn-action bk-btn-action--delete btn btn-danger"
               href="javascript:void(0)"
               data-id="{{ $group->id }}"
               data-toggle="modal"
               data-target="#bk-delete-modal"
               data-tip="{{ __('_action.delete') }}" ></a>
        </td>
        @endif
    </tr>
    @endforeach
@endforeach
