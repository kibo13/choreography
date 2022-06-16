<table class="dataTables table table-bordered table-hover table-responsive">
    <thead class="thead-light">
        <tr>
            <th class="align-top">#</th>
            <th class="align-top bk-min-w-150 w-25">{{ __('_field.pass') }}</th>
            <th class="align-top bk-min-w-150 w-25">{{ __('_field.period_action') }}</th>
            <th class="align-top bk-min-w-150 w-25">{{ __('_field.member') }}</th>
            <th class="align-top bk-min-w-150 w-25">{{ __('_field.group') }}</th>
        </tr>
    </thead>
    <tbody>
    @foreach($passes as $index => $pass)
        <tr>
            <td>{{ ++$index }}</td>
            <td>{{ __('_field.pass') . ' №' . $pass->id }}</td>
            <td>{{ @getDMY($pass->from) . '-' . @getDMY($pass->till) }}</td>
            <td>{{ @full_fio('member', $pass->member->id) }}</td>
            <td>
                {{ $pass->member->group->title->name }}
                @if($pass->member->group->category_id != 4)
                {{ @tip($pass->member->group->category->name) }}
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
