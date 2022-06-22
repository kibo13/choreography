<div class="my-2 bk-callout">
    <p class="m-0">
        Наведите мышкой на колонки для отображения подсказок
    </p>
</div>

@if(session()->has('success'))
<div class="my-2 alert alert-success" role="alert">
    {{ session()->get('success') }}
</div>
@endif

@if(session()->has('warning'))
<div class="my-2 alert alert-warning" role="alert">
    {{ session()->get('warning') }}
</div>
@endif

<table class="dataTables table table-bordered table-hover table-responsive">
    <thead class="thead-light">
        <tr>
            <th rowspan="2" class="align-top">#</th>
            <th rowspan="2" class="align-top bk-min-w-150 w-25">{{ __('_field.member') }}</th>
            <th rowspan="2" class="align-top bk-min-w-150 w-25">{{ __('_field.group') }}</th>
            <th rowspan="2" class="align-top bk-min-w-150 w-25">{{ __('_field.pass') }}</th>
            <th rowspan="2" class="align-top bk-min-w-250 w-25">{{ __('_field.period_action') }}</th>
            <th rowspan="2" class="align-top bk-min-w-100 w-25">{{ __('_field.cost') }}</th>
            <th colspan="4" class="text-center bk-min-w-150 w-25">{{ __('_field.lessons') }}</th>
            <th rowspan="2" class="align-top bk-min-w-150 w-25">{{ __('_field.payment') }}</th>
            <th rowspan="2" class="align-top">{{ __('_action.this') }}</th>
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
            <td>{{ @full_fio('member', $pass->member->id) }}</td>
            <td>
                {{ $pass->member->group->title->name }}
                @if($pass->member->group->category_id != 4)
                {{ @tip($pass->member->group->category->name) }}
                @endif
            </td>
            <td>{{ 'Абонемент №' . $pass->id }}</td>
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
                    <li>
                        <strong>квитанция </strong>
                        <span>
                            @if($pass->pay_file)
                            <a class="text-primary" href="{{ asset('assets/' . $pass->pay_file) }}" target="_blank">
                            скачать
                            </a>
                            @else
                            -
                            @endif
                        </span>
                    </li>
                    {{ @fa('fa fa-eye bk-btn-info--fa') }}
                </ul>
            </td>
            <td>
                <div class="bk-btn-actions">
                    <a class="bk-btn-action bk-btn-action--bill btn btn-primary"
                       href="{{ route('admin.passes.bill', $pass) }}"
                       data-tip="{{ __('_field.check') }}" ></a>
                    <a class="bk-btn-action bk-btn-action--agree btn btn-primary"
                       href="{{ route('admin.passes.show', $pass) }}"
                       data-tip="{{ __('_field.pass') }}" ></a>
                    @if(@is_access('pass_full') && Auth::user()->role_id == 3)
                    @if($pass->lessons == @getVisitsByType($pass->member, $pass->month, $pass->year, [0, 1, 2]))
                    <a class="bk-btn-action bk-btn-action--archive btn btn-secondary"
                       href="{{ route('admin.passes.archive', $pass) }}"
                       data-tip="{{ __('_action.zip') }}" ></a>
                    @else
                    <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
                       href="{{ route('admin.passes.edit', $pass) }}"
                       data-tip="{{ __('_action.edit') }}" ></a>
                    <a class="bk-btn-action bk-btn-action--delete btn btn-danger"
                       href="javascript:void(0)"
                       data-id="{{ $pass->id }}"
                       data-toggle="modal"
                       data-target="#bk-delete-modal"
                       data-tip="{{ __('_action.delete') }}" ></a>
                    @endif
                    @endif
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
