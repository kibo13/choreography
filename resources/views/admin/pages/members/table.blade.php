<table id="is-datatable" class="dataTables table table-bordered table-hover table-responsive">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th class="w-25 bk-min-w-150">{{ __('_field.member') }}</th>
            <th class="w-25 bk-min-w-200">{{ __('_field.group') }}</th>
            <th class="w-25 bk-min-w-100">{{ __('_field.age') }}</th>
            <th class="w-25 no-sort bk-min-w-250">{{ __('_field.contacts') }}</th>
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
            <td>{{ $member->age }}</td>
            <td>
                <ul class="bk-btn-info">
                    <li>
                        <strong>Телефон</strong>
                        {{ $member->phone }}
                    </li>
                    <li>
                        <strong>E-mail</strong>
                        {{ $member->email ? $member->email : '…' }}
                    </li>
                    <li>
                        <strong>Адрес</strong>
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
            <td>{{ $member->age }}</td>
            <td>
                <ul class="bk-btn-info">
                    <li>
                        <strong>Телефон</strong>
                        {{ $member->phone }}
                    </li>
                    <li>
                        <strong>E-mail</strong>
                        {{ $member->email ? $member->email : '…' }}
                    </li>
                    <li>
                        <strong>Адрес</strong>
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
