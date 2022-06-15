<div class="mt-1 mb-2 bk-callout">
    <h5 class="m-0">
        Контроль замен
        <span class="text-info align-text-top">{{ $monthName }}</span>
    </h5>
</div>

<table id="is-datatable" class="dataTables table table-bordered table-responsive">
    <thead class="thead-light">
        <tr>
            <th>#</th>
            <th class="w-25 bk-min-w-150">{{ __('_field.date') }}</th>
            <th class="w-25 bk-min-w-150">{{ __('_field.time_lesson') }}</th>
            <th class="w-25 bk-min-w-150">{{ __('_field.teacher') }}</th>
            <th class="w-25 bk-min-w-150">{{ __('_field.note') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($subteachers as $index => $subteacher)
        <tr>
            <td>{{ ++$index }}</td>
            <td>{{ @getDMY($subteacher->from) }}</td>
            <td>{{ @getHI($subteacher->from) . ' - ' . @getHI($subteacher->till) }}</td>
            <td>{{ @full_fio('worker', $subteacher->worker_id) }}</td>
            <td>{{ $subteacher->note }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
