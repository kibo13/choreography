<table class="dataTables table table-bordered table-hover table-responsive">
    <thead class="thead-light">
        <tr class="text-center">
            <th colspan="3">Журнал учёта пропусков</th>
        </tr>
        <tr>
            <th>#</th>
            <th class="w-75 bk-min-w-200">{{ __('_field.member') }}</th>
            <th class="w-25 text-center">{{ $nameMonth }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($group->members as $index => $member)
        <tr>
            <td>{{ ++$index }}</td>
            <td>
                <strong class="{{ $member->form_study ? 'text-info' : null }}">
                    {{ @full_fio('member', $member->id) }}
                    @if($member->form_study)
                    <span title="{{ __('_field.paid_form') }}">
                        {{ @fa('fa-info-circle') }}
                    </span>
                    @endif
                </strong>
            </td>
            <td class="text-center">
                @if(@getMissesByMember($member->id, $numMonth, $year))
                {{ @getMissesByMember($member->id, $numMonth, $year) }}
                @else
                -
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
