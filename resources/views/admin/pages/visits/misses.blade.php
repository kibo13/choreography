<table class="dataTables table table-bordered table-hover table-responsive">
    <thead class="thead-light">
        <tr class="text-center">
            <th colspan="4">Журнал учёта пропусков</th>
        </tr>
        <tr>
            <th>#</th>
            <th class="w-50 bk-min-w-200 text-left">{{ __('_field.member') }}</th>
            <th class="w-25 bk-min-w-100 text-center">{{ $nameMonth }}</th>
            <th class="w-25 bk-min-w-100 text-center">{{ __('_field.expulsion') }}</th>
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
                @if(@getVisitsByType($member, $numMonth, $year, [0]))
                {{ @getVisitsByType($member, $numMonth, $year, [0]) }}
                @else
                -
                @endif
            </td>
            <td class="text-center">
                @if($lessons->count() == @getVisitsByType($member, $numMonth, $year, [0]))
                <a class="text-primary" href="{{ route('admin.visits.expulsion', ['year' => $year, 'month' => $numMonth, 'member' => $member]) }}">
                    {{ __('_field.command') }}
                </a>
                @else
                -
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
