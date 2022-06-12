<table class="dataTables table table-bordered table-hover table-responsive">
    <thead class="thead-light">
        <tr class="text-center">
            <th colspan="5">
                Журнал занятий коллектива
            </th>
        </tr>
        <tr>
            <th>#</th>
            <th class="w-25 bk-min-w-150">{{ __('_field.date') }}</th>
            <th class="w-25 bk-min-w-150">{{ __('_field.time_lesson') }}</th>
            <th class="w-25 bk-min-w-150">{{ __('_field.topic') }}</th>
            <th class="w-25 bk-min-w-150">{{ __('_field.hours_per') }}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($lessonDays as $index => $day)
        <tr>
            <td>{{ ++$index }}</td>
            <td>{{ @getDMY($day->date_lesson) }}</td>
            <td>
                <ul>
                    @foreach($lessons as $lesson)
                    @if($lesson->day_lesson == $day->day_lesson)
                    <li>
                        {{ @getHI($lesson->from) . '-' . @getHI($lesson->till) }}
                    </li>
                    @endif
                    @endforeach
                </ul>
            </td>
            <td>
                <ul>
                    @foreach($lessons as $lesson)
                    @if($lesson->day_lesson == $day->day_lesson)
                    @if(@is_access('visit_full'))
                    @if($lesson->method_id)
                    <li>
                        <button class="bk-btn-info text-muted text-left"
                                data-type="topic"
                                data-id="{{ $lesson->id }}"
                                data-method="{{ $lesson->method_id }}"
                                data-note="{{ $lesson->note }}"
                                title="{{ @getTopicByMethod($lesson->method_id)->name }}">
                            {{ @getTopicByMethod($lesson->method_id)->name }}
                        </button>
                    </li>
                    @else
                    <li>
                        <button class="text-primary"
                                data-type="topic"
                                data-id="{{ $lesson->id }}"
                                data-method="0">
                            {{ __('_action.set') }}
                        </button>
                    </li>
                    @endif
                    @else
                    <li>
                        {{ $lesson->method_id ? $lesson->method->name : '-' }}
                    </li>
                    @endif
                    @endif
                    @endforeach
                </ul>
            </td>
            <td>
                <ul>
                    @foreach($lessons as $lesson)
                    @if($lesson->day_lesson == $day->day_lesson)
                    @if($lesson->method_id)
                    <li>
                        {{ '1ч / ' . @getTopicByMethod($lesson->method_id)->lesson->sign }}
                    </li>
                    @else
                    <li>-</li>
                    @endif
                    @endif
                    @endforeach
                </ul>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

