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
            <th>#</th>
            <th class="bk-min-w-150 w-25">{{ __('_field.member') }}</th>
            <th class="bk-min-w-200 w-25">{{ __('_field.group') }}</th>
            <th class="bk-min-w-150 w-25">{{ __('_field.pass') }}</th>
            <th class="bk-min-w-200 w-25">{{ __('_field.period_action') }}</th>
            <th class="bk-min-w-150 w-25">{{ __('_field.cost') }}</th>
            <th class="bk-min-w-150 w-25">{{ __('_field.lessons') }}</th>
            <th class="bk-min-w-200 w-25">{{ __('_field.payment') }}</th>
            <th>{{ __('_action.this') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($members as $index => $member)
        <tr>
            <th>{{ ++$index }}</th>
            <td>{{ @full_fio('member', $member->id) }}</td>
            <td>
                {{ $member->group->title->name }}
                @if($member->group->category_id != 4)
                {{ @tip($member->group->category->name) }}
                @endif
            </td>
            @if(@getActivePass($member))
            <td>
                {{ __('_field.pass') }}
                {{ ' №' . @getActivePass($member)->id }}
            </td>
            <td title="До окончания срока действия абонемента осталось {{ @diffDays(@getActivePass($member)->till) }} дн.">
                <span>
                    {{ @getDMY(@getActivePass($member)->from) }}
                </span>
                <span>
                    {{ ' - ' }}
                </span>
                <span class="{{ @diffDays(@getActivePass($member)->till) < 5 ? 'text-danger' : null }}">
                    {{ @getDMY(@getActivePass($member)->till) }}
                </span>
                @if(@diffDays(@getActivePass($member)->till) < 5)
                <span style="cursor: pointer" >
                    {{ '(' . @diffDays(@getActivePass($member)->till) . ' дн)' }}
                </span>
                @endif
            </td>
            <td>
                {{ @getActivePass($member)->cost . ' ₽' }}
            </td>
            <td>
                {{ @checkPass($member) }}
                /
                {{ @getActivePass($member)->lessons }}
            </td>
            @if(@checkPass($member) >= @getActivePass($member)->lessons)
            <td colspan="2">
                <span class="text-danger">
                    Абонемент закончился.
                </span>
                @if(@is_access('pass_full') && Auth::user()->role_id == 3)
                <a class="text-primary" href="{{ route('admin.passes.prolong', $member->passes->where('is_active', 1)->first()) }}">
                    Создать новый
                </a>
                @endif
            </td>
            @else
            <td>
                <ul class="bk-btn-info">
                    <li>
                        <strong>статус </strong>
                        <span class="{{ @getActivePass($member)->status ? 'text-success' : 'text-danger' }}">
                            {{ @getActivePass($member)->status ? 'оплачено' : 'не оплачено' }}
                        </span>
                    </li>
                    <li>
                        <strong>дата </strong>
                        <span>
                            @if(@getActivePass($member)->pay_date)
                            {{ @getDMY(@getActivePass($member)->pay_date) }}
                            @else
                            -
                            @endif
                        </span>
                    </li>
                    <li>
                        <strong>квитанция </strong>
                        <span>
                            @if(@getActivePass($member)->pay_file)
                            <a class="text-primary"
                               href="{{ asset('assets/' . @getActivePass($member)->pay_file) }}"
                               target="_blank">
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
                       href="{{ route('admin.passes.bill', @getActivePass($member)) }}"
                       data-tip="{{ __('_field.check') }}" ></a>
                    <a class="bk-btn-action bk-btn-action--agree btn btn-primary"
                       href="{{ route('admin.passes.show', @getActivePass($member)) }}"
                       data-tip="{{ __('_field.pass') }}" ></a>
                    @if(@is_access('pass_full') && Auth::user()->role_id == 3)
                    <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
                       href="{{ route('admin.passes.edit', @getActivePass($member)) }}"
                       data-tip="{{ __('_action.edit') }}" ></a>
                    <a class="bk-btn-action bk-btn-action--delete btn btn-danger"
                       href="javascript:void(0)"
                       data-id="{{ @getActivePass($member)->id }}"
                       data-toggle="modal"
                       data-target="#bk-delete-modal"
                       data-tip="{{ __('_action.delete') }}" ></a>
                    @endif
                </div>
            </td>
            @endif
            @else
            <td colspan="6">
                @if(@is_access('pass_full'))
                <a class="text-primary"
                   href="{{ route('admin.passes.create', ['member_id' => $member->id]) }}">
                    Создать абонемент
                </a>
                @else
                <span class="text-info">
                    {{ __('_record.no') }}
                </span>
                @endif
            </td>
            @endif
        </tr>
        @endforeach
    </tbody>
</table>
