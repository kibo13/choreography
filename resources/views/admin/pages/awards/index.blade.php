@extends('admin.index')
@section('title-admin', __('_section.awards'))
@section('content-admin')
    <section id="awards-index" class="overflow-auto">
        <h3>Регистрация дипломов и грамот участников клубных формирований</h3>

        @if(@is_access('award_full'))
        <div class="my-2 btn-group">
            <a class="btn btn-primary" href="{{ route('admin.awards.create') }}">
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
                    <th>#</th>
                    <th class="bk-min-w-150 w-25">Номер регистрации</th>
                    <th class="bk-min-w-150 w-25">Дата регистрации</th>
                    <th class="bk-min-w-200 w-25">Дата выдачи документа</th>
                    <th class="bk-min-w-200 w-25 no-sort">Название документа</th>
                    <th class="bk-min-w-200 no-sort">Краткое содержание</th>
                    <th class="bk-min-w-150 no-sort">Кем выдан</th>
                    <th class="bk-min-w-150 no-sort">Примечание</th>
                    @if(@is_access('award_full'))
                    <th class="no-sort">{{ __('_action.this') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @foreach($awards as $index => $award)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ '№' . $award->num }}</td>
                    <td>{{ @getDMY($award->date_reg) }}</td>
                    <td>{{ @getDMY($award->date_doc) }}</td>
                    <td>{{ $award->name_doc }}</td>
                    <td>
                        <ul>
                            <li>
                                {{ 'Выдан коллективу' }}
                            </li>
                            <li>
                                {{ '"' . $award->group->title->name . ' / ' . $award->group->category->name . '"' }}
                            </li>
                            <li>
                                {{ '(' . $award->totalSeats() . ' чел.)' }}
                            </li>
                        </ul>
                    </td>
                    <td>{{ $award->orgkomitet->name }}</td>
                    <td>{{ $award->note }}</td>
                    @if(@is_access('award_full'))
                    <td>
                        <div class="bk-btn-actions">
                            <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
                               href="{{ route('admin.awards.edit', $award) }}"
                               data-tip="{{ __('_action.edit') }}" ></a>
                            <a class="bk-btn-action bk-btn-action--delete btn btn-danger"
                               href="javascript:void(0)"
                               data-id="{{ $award->id }}"
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
    </section>
@endsection
