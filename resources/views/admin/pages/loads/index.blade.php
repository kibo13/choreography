@extends('admin.index')
@section('title-admin', __('_section.loads'))
@section('content-admin')
    <section id="loads-index" class="overflow-auto">
        <h3>{{ __('_section.loads') }}</h3>

        @if(session()->has('success'))
        <div class="my-2 alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
        @endif

        @if(session()->has('warning'))
        <div class="my-2 alert alert-warning alert-limit" role="alert">
            {{ session()->get('warning') }}
        </div>
        @endif

        <table class="dataTables table table-bordered table-hover table-responsive">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th class="bk-min-w-250 w-100">{{ __('_field.group') }}</th>
                    <th class="text-center bk-min-w-100">{{ __('_field.category') }}</th>
                    <th class="text-center bk-min-w-100" title="{{ __('_field.hours_per_month') }}">
                        {{ __('_field.month') }} {{ @fa('fa-info-circle') }}
                    </th>
                    <th class="text-center bk-min-w-100" title="{{ __('_field.hours_per_week') }}">
                        {{ __('_field.week') }} {{ @fa('fa-info-circle') }}
                    </th>
                    @foreach($daysOfWeek as $day)
                    <th class="text-center bk-min-w-100">{{ $day['shortname'] }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
            @foreach($titles as $index => $title)
                <tr>
                    <td rowspan="4">{{ ++$index }}</td>
                    <td rowspan="4">
                        <h5 class="text-uppercase">
                            {{ $title->name }}
                        </h5>
                        <p class="m-0 font-weight-bold">
                            {{ $title->specialty->name }}
                        </p>
                        <p class="m-0 text-info">
                            {{ $title->is_paid ? __('_field.paid_group') : __('_field.free_group')  }}
                        </p>
                    </td>
                </tr>
                @foreach($title->groups as $group)
                <tr>
                    <td class="align-middle text-center">
                        {{ $group->category->name }}
                    </td>
                    <td class="align-middle text-center">
                        @if($group->workload)
                        {{ $group->workload }}
                        {{ @tip('ч') }}
                        @else
                        {{ @tip('-') }}
                        @endif
                    </td>
                    <td class="align-middle text-center">
                        @if($group->workload)
                        {{ $group->workload / 4 }}
                        {{ @tip('ч') }}
                        @else
                        {{ @tip('-') }}
                        @endif
                    </td>
                    @foreach($daysOfWeek as $day)
                    <td class="align-middle text-center">
                        @if(@is_access('load_full'))
                        @if(@load($group, $day['id']))
                        <button class="text-secondary font-weight-bold"
                                data-load="set"
                                data-action="update"
                                data-group="{{ $group->id }}"
                                data-dow="{{ $day['id'] }}"
                                data-start="{{ @load($group, $day['id'], 'start') }}"
                                data-duration="{{ @load($group, $day['id'], 'duration') }}"
                                title="{{ __('_action.edit') }}">
                            {{ @load($group, $day['id'], 'duration') . ' ч' }}
                        </button>
                        {{ '/' }}
                        <button class="bk-btn-action--delete text-danger"
                                data-id="{{ @load($group, $day['id'], 'id') }}"
                                data-toggle="modal"
                                data-target="#bk-delete-modal"
                                title="{{ __('_action.reset') }}">
                            ✖
                        </button>
                        @else
                        <button class="text-primary"
                                data-load="set"
                                data-action="create"
                                data-group="{{ $group->id }}"
                                data-dow="{{ $day['id'] }}">
                            {{ __('_action.set') }}
                        </button>
                        @endif
                        @else
                        @if(@load($group, $day['id']))
                        <span class="text-secondary font-weight-bold">
                            {{ @load($group, $day['id'], 'duration') . ' ч' }}
                        </span>
                        @else
                        {{ @tip('-') }}
                        @endif
                        @endif
                    </td>
                    @endforeach
                </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </section>
@endsection


