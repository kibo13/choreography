@extends('admin.index')
@section('title-admin', __('_section.reps'))
@section('content-admin')
    <section id="reps-index" class="overflow-auto">
        <h3>{{ __('_section.reps') }}</h3>

        @if(session()->has('success'))
        <div class="my-2 alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
        @endif

        <table id="is-datatable" class="dataTables table table-bordered table-hover table-responsive">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th class="w-25 bk-min-w-150">Родитель</th>
                    <th class="w-25 bk-min-w-150">Тип документа</th>
                    <th class="w-25 bk-min-w-150 no-sort">Участники</th>
                    <th class="w-25 bk-min-w-150 no-sort">Примечание</th>
                    @if(@is_access('rep_full'))
                    <th class="no-sort">{{ __('_action.this') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach($reps as $index => $rep)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ @full_fio('rep', $rep->id) }}</td>
                    <td>{{ $rep->doc->name }}</td>
                    <td>
                        <ul class="bk-btn-info">
                            @foreach($rep->members as $member)
                            <li>
                                {{ @full_fio('member', $member->id) }}
                            </li>
                            @endforeach
                            {{ $rep->members->count() > 1 ? @fa('fa fa-eye bk-btn-info--fa') : null }}
                        </ul>
                    </td>
                    <td>
                        {{ $rep->note }}
                    </td>
                    @if(@is_access('rep_full'))
                    <td>
                        <div class="bk-btn-actions">
                            <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
                               href="{{ route('admin.reps.edit', $rep) }}"
                               data-tip="{{ __('_action.edit') }}" ></a>
                        </div>
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </section>
@endsection
