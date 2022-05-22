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
                    <th class="bk-min-w-250 w-25">{{ __('_field.event') }}</th>
                    <th class="bk-min-w-150 w-25">{{ __('_field.type') }}</th>
                    <th class="bk-min-w-150">{{ __('_field.date_from') }}</th>
                    <th class="bk-min-w-150">{{ __('_field.date_till') }}</th>
                    <th class="bk-min-w-150 w-25">{{ __('_field.place') }}</th>
                    <th class="bk-min-w-250 no-sort">{{ __('_field.concert_title') }}</th>
                    <th class="bk-min-w-150 no-sort">{{ __('_field.group') }}</th>
                    <th class="bk-min-w-150 no-sort">{{ __('_field.members') }}</th>
                    @if(@is_access('event_full'))
                    <th class=" text-center no-sort">{{ __('_action.this') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @foreach($events as $index => $event)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ $event->name }}</td>
                    <td>
                        {{ $event->type ? __('_field.international') : __('_field.town') }}
                    </td>
                    <td>{{ @getDMY($event->from) }}</td>
                    <td>{{ @getDMY($event->till) }}</td>
                    <td>{{ $event->place }}</td>
                    <td>
                        <div class="bk-btn-info">
                            {{ $event->description }}
                            {{ $event->description ? @fa('fa fa-eye bk-btn-info--fa') : null }}
                        </div>
                    </td>
                    <td>
                        <strong>{{ $event->group->title->name }}</strong>
                        @if($event->group->category_id != 4)
                        <small>{{ $event->group->category->name }}</small>
                        @endif
                    </td>
                    <td>
                        <ul class="bk-btn-info">
                            @foreach($event->members as $member)
                            <li>
                                {{ @full_fio('member', $member->id) }}
                            </li>
                            @endforeach
                            {{ $event->members->count() ? @fa('fa fa-eye bk-btn-info--fa') : null }}
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
