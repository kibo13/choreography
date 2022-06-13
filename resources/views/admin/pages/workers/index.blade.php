@extends('admin.index')
@section('title-admin', __('_section.workers'))
@section('content-admin')
    <section id="workers-index" class="overflow-auto">
        <h3>{{ __('_section.workers') }}</h3>

        @if(@is_access('worker_full'))
        <div class="my-2 btn-group">
            <a class="btn btn-primary" href="{{ route('admin.workers.create') }}">
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
                    <th class="w-25 bk-min-w-150">{{ __('_field.fio') }}</th>
                    <th class="w-25 bk-min-w-150">{{ __('_field.position') }}</th>
                    <th class="w-25 bk-min-w-250 no-sort">{{ __('_field.specialty') }}</th>
                    <th class="w-25 bk-min-w-250 no-sort">{{ __('_field.groups') }}</th>
                    @if(@is_access('worker_full'))
                    <th class="no-sort">{{ __('_action.this') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @foreach($workers as $index => $worker)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ @full_fio('worker', $worker->id) }}</td>
                    <td>{{ $worker->user->role->name }}</td>
                    <td>
                        <ul class="bk-btn-info">
                            @foreach($worker->specialties as $specialty)
                            <li>
                                {{ $specialty->name }}
                            </li>
                            @endforeach
                            {{ $worker->specialties->count() > 1 ? @fa('fa fa-eye bk-btn-info--fa') : null }}
                        </ul>
                    </td>
                    <td>
                        <ul class="bk-btn-info">
                            @foreach($titles as $title)
                            <li>
                                @if($worker->groups->where('title_id', $title->id)->count())
                                <strong>{{ $title->name }}</strong>
                                @endif
                                @foreach($worker->groups as $group)
                                @if($group->title_id == $title->id)
                                <span class="text-uppercase">
                                {{ @tip($group->category->sign) }}
                                </span>
                                @endif
                                @endforeach
                            </li>
                            @endforeach
                        </ul>
                    </td>
                    @if(@is_access('worker_full'))
                    <td>
                        <div class="bk-btn-actions">
                            <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
                               href="{{ route('admin.workers.edit', $worker) }}"
                               data-tip="{{ __('_action.edit') }}" ></a>
                            <a class="bk-btn-action bk-btn-action--delete btn btn-danger"
                               href="javascript:void(0)"
                               data-id="{{ $worker->id }}"
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
