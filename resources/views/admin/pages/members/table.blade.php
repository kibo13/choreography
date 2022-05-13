<table id="is-datatable" class="dataTables table table-bordered table-hover table-responsive">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th class="w-25 bk-min-w-150">{{ __('_field.member') }}</th>
            <th class="w-25 bk-min-w-200">{{ __('_field.group') }}</th>
            <th class="w-25 bk-min-w-150">{{ __('_field.study') }}</th>
            <th class="w-25 no-sort bk-min-w-250">{{ __('_field.info') }}</th>
            <th class="no-sort">{{ __('_action.this') }}</th>
        </tr>
    </thead>
    <tbody>
        @if($groups)
        @foreach($groups as $group)
        @foreach($group->members as $index => $member)
        <tr>
            <td>{{ ++$index }}</td>
            <td>
                {{ @full_fio('member', $member->id) }}
            </td>
            <td>
                <strong>{{ $member->group->title->name }}</strong>
                {{ @tip($member->group->category->name) }}
            </td>
            <td>{{ $member->form_study ? __('_field.paid') : __('_field.free') }}</td>
            <td>
                <ul class="bk-btn-info">
                    <li>
                        <strong>{{ __('_field.phone') }}</strong>
                        {{ $member->phone }}
                    </li>
                    <li>
                        <strong>{{ __('_field.email') }}</strong>
                        {{ $member->email ? $member->email : '…' }}
                    </li>
                    <li>
                        <strong>{{ __('_field.age') }}</strong>
                        {{ $member->age . ' лет' }}
                    </li>
                    <li>
                        <strong>{{ __('_field.address') }}</strong>
                        {{ $member->address_fact }}
                    </li>
                    {{ @fa('fa fa-eye bk-btn-info--fa') }}
                </ul>
            </td>
            <td>
                <div class="bk-btn-actions">
                    <a class="bk-btn-action bk-btn-action--info btn btn-info"
                       href="{{ route('admin.members.show', $member) }}"
                       data-tip="{{ __('_action.show') }}" ></a>
                    @if(@is_access('member_full'))
                    <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
                       href="{{ route('admin.members.edit', $member) }}"
                       data-tip="{{ __('_action.edit') }}" ></a>
                    <a class="bk-btn-action bk-btn-action--delete btn btn-danger"
                       href="javascript:void(0)"
                       data-id="{{ $member->id }}"
                       data-toggle="modal"
                       data-target="#bk-delete-modal"
                       data-tip="{{ __('_action.delete') }}" ></a>
                    @endif
                </div>
            </td>
        </tr>
        @endforeach
        @endforeach
        @else
        @foreach($members as $index => $member)
        <tr>
            <td>{{ ++$index }}</td>
            <td>
                {{ @full_fio('member', $member->id) }}
            </td>
            <td>
                <strong>{{ $member->group->title->name }}</strong>
                {{ @tip($member->group->category->name) }}
            </td>
            <td>{{ $member->form_study ? __('_field.paid') : __('_field.free') }}</td>
            <td>
                <ul class="bk-btn-info">
                    <li>
                        <strong>{{ __('_field.phone') }}</strong>
                        {{ $member->phone }}
                    </li>
                    <li>
                        <strong>{{ __('_field.email') }}</strong>
                        {{ $member->email ? $member->email : '…' }}
                    </li>
                    <li>
                        <strong>{{ __('_field.age') }}</strong>
                        {{ $member->age . ' лет' }}
                    </li>
                    <li>
                        <strong>{{ __('_field.address') }}</strong>
                        {{ $member->address_fact }}
                    </li>
                    {{ @fa('fa fa-eye bk-btn-info--fa') }}
                </ul>
            </td>
            <td>
                <div class="bk-btn-actions">
                    <a class="bk-btn-action bk-btn-action--info btn btn-info"
                       href="{{ route('admin.members.show', $member) }}"
                       data-tip="{{ __('_action.show') }}" ></a>
                    @if(@is_access('member_full'))
                    <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
                       href="{{ route('admin.members.edit', $member) }}"
                       data-tip="{{ __('_action.edit') }}" ></a>
                    <a class="bk-btn-action bk-btn-action--delete btn btn-danger"
                       href="javascript:void(0)"
                       data-id="{{ $member->id }}"
                       data-toggle="modal"
                       data-target="#bk-delete-modal"
                       data-tip="{{ __('_action.delete') }}" ></a>
                    @endif
                </div>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
