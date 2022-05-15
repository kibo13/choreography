<table id="is-datatable" class="dataTables table table-bordered table-hover table-responsive">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th class="w-25 bk-min-w-250">{{ __('_field.event') }}</th>
            <th class="w-25 bk-min-w-150">{{ __('_field.group') }}</th>
            <th class="w-50 bk-min-w-300 no-sort">{{ __('_field.result') }}</th>
            @if(@is_access('achievement_full'))
            <th class="no-sort">{{ __('_action.this') }}</th>
            @endif
        </tr>
    </thead>
    <tbody>
    @foreach($events as $index => $event)
        <tr>
            <td>{{ ++$index }}</td>
            <td>{{ $event->name }}</td>
            <td>
                <strong>
                    {{ $event->group->title->name }}
                </strong>
                @if($event->group->category_id != 4)
                <small>
                    {{ $event->group->category->name }}
                </small>
                @endif
            </td>
            <td>
                @if($event->achievement)
                <a class="text-primary"
                   href="{{ route('admin.achievements.show', $event) }}">
                    {{ __('_action.look') }}
                </a>
                @else
                @if(@is_access('achievement_full'))
                <a class="text-primary"
                   href="{{ route('admin.achievements.create', $event) }}">
                    {{ __('_record.add') }}
                </a>
                @else
                <span class="text-info">{{ __('_record.no') }}</span>
                @endif
                @endif
            </td>
            @if(@is_access('achievement_full'))
            <td>
                @if($event->achievement)
                <div class="bk-btn-actions">
                    <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
                       href="{{ route('admin.achievements.edit', $event) }}"
                       data-tip="{{ __('_action.edit') }}"></a>
                    <a class="bk-btn-action bk-btn-action--delete btn btn-danger"
                       href="javascript:void(0)"
                       data-id="{{ $event->achievement->id }}"
                       data-toggle="modal"
                       data-target="#bk-delete-modal"
                       data-tip="{{ __('_action.delete') }}"></a>
                </div>
                @endif
            </td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
