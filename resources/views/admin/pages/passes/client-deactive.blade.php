<table class="dataTables table table-bordered table-hover table-responsive">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th class="w-25 bk-min-w-150">{{ __('_field.pass') }}</th>
            <th class="w-25 bk-min-w-200">{{ __('_field.period_action') }}</th>
            <th class="w-25 bk-min-w-150">{{ __('_field.lessons') }}</th>
            <th class="w-25 bk-min-w-150">{{ __('_field.cost') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($passes->where('is_active', 2) as $index => $pass)
        <tr>
            <td>{{ ++$index }}</td>
            <td>{{ __('_field.pass') . ' №' . $pass->id }}</td>
            <td>{{ @getDMY($pass->from) . ' - ' . @getDMY($pass->till) }}</td>
            <td>{{ $pass->lessons }}</td>
            <td>{{ $pass->cost . ' ₽' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
