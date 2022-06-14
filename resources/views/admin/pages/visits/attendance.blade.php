<table class="dataTables table table-bordered table-hover table-responsive">
    <thead class="thead-light">
        <tr class="text-center">
            <th colspan="2">Журнал учёта посещений</th>
            <th colspan="{{ $lessonCount }}">{{ $nameMonth }}</th>
        </tr>
        <tr>
            <th>#</th>
            <th class="w-100 bk-min-w-200">{{ __('_field.member') }}</th>
            @foreach($lessonDays as $day)
            <th class="text-center bk-min-w-100">{{ $day->day_lesson }}</th>
            @endforeach
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
            @foreach($lessonDays as $day)
            <td class="text-center">
                <ul>
                    @foreach($lessons as $lesson)
                    @if($lesson->day_lesson == $day->day_lesson)
                    @if(@is_access('visit_full'))
                    @if(@checkVisit($member, $lesson))
                    <li>
                        <button data-type="visit"
                                data-action="update"
                                data-id="{{ @checkVisit($member, $lesson)->timetable_id }}"
                                data-member="{{ @checkVisit($member, $lesson)->member_id }}"
                                data-status="{{ @checkVisit($member, $lesson)->status }}"
                                data-reason="{{ @checkVisit($member, $lesson)->reason }}">
                            @if(@checkVisit($member, $lesson)->status > 0)
                            <span class="text-success" title="{{ __('_action.present') }}">
                                {{ @fa('fa-check') }}
                            </span>
                            @else
                            <span class="text-danger" title="{{ __('_action.miss') }}">
                                {{ @fa('fa-times') }}
                            </span>
                            @endif
                        </button>
                    </li>
                    @else
                    <li>
                        <input type="checkbox"
                               style="width: 16px; height: 16px; cursor: pointer;"
                               data-type="visit"
                               data-action="create"
                               data-id="{{ $lesson->id }}"
                               data-member="{{ $member->id }}"
                               title="{{ __('_action.check') }}">
                    </li>
                    @endif
                    @else
                    @if(@checkVisit($member, $lesson))
                    <li>
                        @if(@checkVisit($member, $lesson)->status > 0)
                        <span class="text-success" title="{{ __('_action.present') }}">
                            {{ @fa('fa-check') }}
                        </span>
                        @else
                        <span class="text-danger" title="{{ __('_action.miss') }}">
                            {{ @fa('fa-times') }}
                        </span>
                        @endif
                    </li>
                    @else
                    <li>
                        -
                    </li>
                    @endif
                    @endif
                    @endif
                    @endforeach
                </ul>
            </td>
            @endforeach
        </tr>
        @endforeach
    </tbody>
</table>
