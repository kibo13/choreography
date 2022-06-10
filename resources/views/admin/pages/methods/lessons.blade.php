<table id="is-datatable" class="dataTables table table-bordered table-hover table-responsive">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th class="w-25 bk-min-w-150">{{ __('_field.group') }}</th>
            <th class="w-25 bk-min-w-150">{{ __('_field.month') }}</th>
            <th class="w-25 bk-min-w-150">{{ __('_field.type_lesson') }}</th>
            <th class="w-25 bk-min-w-150">{{ __('_field.topic') }}</th>
            @if(@is_access('method_full'))
            <th class="no-sort">{{ __('_action.this') }}</th>
            @endif
        </tr>
    </thead>
    <tbody>
    @foreach($methods as $index => $method)
        <tr>
            <td>{{ ++$index }}</td>
            <td>
                <strong>{{ $method->group->title->name }}</strong>
                @if($method->group->category_id != 4)
                <span>{{ $method->group->category->name }}</span>
                @endif
            </td>
            <td>
                {{ $nameMonth[$method->month_id - 1] }}
            </td>
            <td>
                {{ $method->lesson->name }}
            </td>
            <td>
                <div class="bk-btn-info">
                    {{ $method->name }}
                    {{ @fa('fa fa-eye bk-btn-info--fa') }}
                </div>
            </td>
            @if(@is_access('method_full'))
            <td>
                <div class="bk-btn-actions">
                    <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
                       href="{{ route('admin.methods.edit', $method) }}"
                       data-tip="{{ __('_action.edit') }}" ></a>
                    <a class="bk-btn-action bk-btn-action--delete btn btn-danger"
                       href="javascript:void(0)"
                       data-id="{{ $method->id }}"
                       data-toggle="modal"
                       data-target="#bk-delete-modal"
                       data-tip="{{ __('_action.delete') }}" ></a>
                </div>
            </td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
