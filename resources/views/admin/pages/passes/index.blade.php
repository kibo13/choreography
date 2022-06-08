@extends('admin.index')
@section('title-admin', __('_section.passes'))
@section('content-admin')
    <section id="passes-index" class="overflow-auto">
        <h3>{{ __('_section.passes') }}</h3>

        @if(@is_access('pass_full'))
        <div class="my-2 btn-group">
            <a class="btn btn-primary" href="{{ route('admin.passes.create') }}">
                {{ __('_record.new') }}
            </a>
        </div>
        @endif

        @if(session()->has('success'))
        <div class="my-2 alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
        @endif

        <table id="is-datatable"
               class="dataTables table table-bordered table-hover table-responsive">
            <thead class="thead-light">
                <tr>
                    <th class="align-top">#</th>
                    <th class="align-top w-25 bk-min-w-150">{{ __('_field.pass') }}</th>
                    <th class="align-top w-25 bk-min-w-150 no-sort">{{ __('_field.action_from') }}</th>
                    <th class="align-top w-25 bk-min-w-150 no-sort">{{ __('_field.action_till') }}</th>
                    <th class="align-top w-25 bk-min-w-150 no-sort">{{ __('_field.cost') }}</th>
                    <th class="align-top bk-min-w-150 no-sort">{{ __('_field.lessons') }}</th>
                    <th class="align-top bk-min-w-150 no-sort">{{ __('_field.status') }}</th>
                    <th class="align-top bk-min-w-150 no-sort">{{ __('_field.pay_date') }}</th>
                    <th class="align-top bk-min-w-150 no-sort">{{ __('_field.pay_file') }}</th>
                    <th class="align-top no-sort">{{ __('_action.this') }}</th>
                </tr>
            </thead>
            <tbody>
            @foreach($passes as $index => $pass)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>
                        <ul>
                            <li>
                                {{ @full_fio('member', $pass->member->id) }}
                            </li>
                            <li>
                                <strong class="text-uppercase">
                                    {{ $pass->member->group->title->name }}
                                </strong>
                            </li>
                            <li>
                                {{ $pass->member->group->category->name . ' группа' }}
                            </li>
                        </ul>
                    </td>
                    <td>{{ @getDMY($pass->from) }}</td>
                    <td>{{ @getDMY($pass->till) }}</td>
                    <td>{{ @double($pass->cost, 0) . ' ₽' }}</td>
                    <td>{{ $pass->lessons }}</td>
                    <td>{{ @is_pay($pass->status) }}</td>
                    <td>{{ $pass->pay_date ? @getDMY($pass->pay_date) : '-' }}</td>
                    <td>
                        @if($pass->pay_file)
                        <a class="text-primary"
                           href="{{ asset('assets/' . $pass->pay_file ) }}"
                           target="_blank">
                            {{ __('_action.look') }}
                        </a>
                        @else
                        -
                        @endif
                    </td>
                    <td>
                        <div class="bk-btn-actions">
                            <a class="bk-btn-action bk-btn-action--bill btn btn-primary"
                               href="{{ route('admin.passes.bill', $pass) }}"
                               data-tip="{{ __('_field.check') }}" ></a>
                            <a class="bk-btn-action bk-btn-action--agree btn btn-primary"
                               href="{{ route('admin.passes.show', $pass) }}"
                               data-tip="{{ __('_field.pass') }}" ></a>
                            @if(@is_access('pass_full'))
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
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection
