<div class="my-2 bk-callout">
    <p class="m-0">
        Наведите мышкой на колонки для отображения подсказок
    </p>
</div>

@if(session()->has('warning'))
<div class="my-2 alert alert-warning alert-limit" role="alert">
    {{ session()->get('warning') }}
</div>
@endif

<table class="dataTables table table-bordered table-hover table-responsive">
    <thead class="thead-light">
        <tr>
            <th rowspan="2" class="align-top">#</th>
            <th rowspan="2" class="align-top bk-min-w-150 w-25">{{ __('_field.pass') }}</th>
            <th colspan="4" class="text-center bk-min-w-150">{{ __('_field.lessons') }}</th>
            <th rowspan="2" class="align-top bk-min-w-250 w-25">{{ __('_field.period_action') }}</th>
            <th rowspan="2" class="align-top bk-min-w-150 w-25">{{ __('_field.cost') }}</th>
            <th rowspan="2" class="align-top bk-min-w-150 w-25">{{ __('_field.payment') }}</th>
            @if(@is_access('help_full'))
            <th rowspan="2" class="align-top">{{ __('_action.this') }}</th>
            @endif
        </tr>
        <tr class="text-center">
            <th class="text-success" title="Кол-во посещений">
                {{ @fa('fa-check') }}
            </th>
            <th class="text-danger" title="Кол-во пропусков">
                {{ @fa('fa-times') }}
            </th>
            <th class="text-warning" title="Кол-во пропусков по уважительной причине">
                {{ @fa('fa-circle-o') }}
            </th>
            <th title="Кол-во занятий в абонемент">
                Л
            </th>
        </tr>
    </thead>
    <tbody>
    @foreach($passes->where('is_active', '<', 2) as $index => $pass)
        <tr>
            <td>{{ ++$index }}</td>
            <td>{{ 'Абонемент №' . $pass->id }}</td>
            <td class="text-center text-success">
                {{ @getVisitsByType($pass->member, $pass->month, $pass->year, [1]) }}
            </td>
            <td class="text-center text-danger">
                {{ @getVisitsByType($pass->member, $pass->month, $pass->year, [0]) }}
            </td>
            <td class="text-center text-warning">
                {{ @getVisitsByType($pass->member, $pass->month, $pass->year, [2]) }}
            </td>
            <td class="text-center">
                {{ $pass->lessons }}
            </td>
            <td title="До окончания срока действия абонемента осталось {{ @diffDays($pass->till) }} дн.">
                <span>{{ @getDMY($pass->from) . ' - ' }}</span>
                <span class="{{ @diffDays($pass->till) < 5 ? 'text-danger' : null }}">
                    {{ @getDMY($pass->till) }}
                </span>
                @if(@diffDays($pass->till) < 5)
                <span style="cursor: pointer;">
                    {{ '(' . @diffDays($pass->till) . ' дн)' }}
                </span>
                @endif
            </td>
            <td>
                {{ @double($pass->cost, 0) . ' ₽' }}
            </td>
            <td>
                <ul class="bk-btn-info">
                    <li>
                        <strong>статус </strong>
                        <span class="{{ $pass->status ? 'text-success' : 'text-danger' }}">
                            {{ $pass->status ? 'оплачено' : 'не оплачено' }}
                        </span>
                    </li>
                    <li>
                        <strong>дата </strong>
                        <span>{{ $pass->pay_date ? @getDMY($pass->pay_date) : '-' }}</span>
                    </li>
                    {{ @fa('fa fa-eye bk-btn-info--fa') }}
                </ul>
            </td>
            @if(@is_access('help_full'))
            <td>
                @if($pass->lessons - @getVisitsByType($pass->member, $pass->month, $pass->year, [0, 1]) > 0)
                <div class="bk-btn-actions">
                    <a class="bk-btn-action bk-btn-action--agree btn btn-primary"
                       href="{{ route('admin.support.create', ['pass' => $pass->id]) }}"
                       title="Заявка на возврат денежных средств"></a>
                </div>
                @endif
            </td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
