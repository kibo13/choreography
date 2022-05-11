@extends('admin.index')
@section('title-admin', __('_section.events'))
@section('content-admin')
    <section id="events-index" class="overflow-auto">
        <h3>{{ __('_section.events') }}</h3>

        @if(@is_access('event_full'))
        <div class="my-2 btn-group">
            <a class="btn btn-primary" href="{{ route('admin.events.create') }}">
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
                    <th class="w-25 bk-min-w-250">{{ __('_field.name') }}</th>
                    <th class="w-25 bk-min-w-150">{{ __('_field.type') }}</th>
                    <th class="w-25 bk-min-w-150 no-sort">{{ __('_field.period_event') }}</th>
                    <th class="w-25 bk-min-w-200 no-sort">{{ __('_field.place') }}</th>
                    <th class="bk-min-w-300 no-sort">{{ __('_field.groups') }}</th>
                    @if(@is_access('event_full'))
                    <th class="no-sort">{{ __('_action.this') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @foreach($events as $index => $event)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ $event->name }}</td>
                    <td>{{ $event->type ? __('_field.international') : __('_field.local') }}</td>
                    <td>
                        {{ @getDMY($event->from) }}
                        {{ $event->till ? ' - ' . @getDMY($event->till) : null }}
                    </td>
                    <td>{{ $event->place }}</td>
                    <td>
                        <ul>
                            @foreach($titles as $title)
                            <li>
                                @if($event->groups->where('title_id', $title->id)->count())
                                <strong>{{ $title->name }}</strong>
                                @endif
                                @foreach($event->groups as $group)
                                @if($group->title_id == $title->id)
                                {{ @tip($group->category->name) }}
                                @endif
                                @endforeach
                            </li>
                            @endforeach
                        </ul>
                    </td>
                    @if(@is_access('event_full'))
                    <td>
                        <div class="bk-btn-actions">
                            <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
                               href="{{ route('admin.events.edit', $event) }}"
                               data-tip="{{ __('_action.edit') }}" ></a>
                            <a class="bk-btn-action bk-btn-action--delete btn btn-danger"
                               href="javascript:void(0)"
                               data-id="{{ $event->id }}"
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
