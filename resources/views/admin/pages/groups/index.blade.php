@extends('admin.index')
@section('title-admin', __('_section.groups'))
@section('content-admin')
    <section id="groups-index" class="overflow-auto">
        <h3>{{ __('_section.groups') }}</h3>

        @if(@is_access('group_full') || @is_access('title_read'))
        <div class="my-2 btn-group">
            @if(@is_access('group_full'))
            <a class="btn btn-primary" href="{{ route('admin.groups.create') }}">
                {{ __('_record.new') }}
            </a>
            @endif
            @if(@is_access('title_read'))
            <a class="btn btn-secondary" href="{{ route('admin.titles.index') }}">
                {{ __('_section.titles') }}
            </a>
            @endif
        </div>
        @endif

        @if(session()->has('success'))
        <div class="my-2 alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
        @endif

        <table class="dataTables table table-bordered table-responsive">
            <thead class="thead-light">
                <tr>
                    <th rowspan="2" class="align-middle">#</th>
                    <th rowspan="2" class="align-middle w-50 bk-min-w-250">{{ __('_field.name') }}</th>
                    <th colspan="3" class="text-center">{{ __('_field.category') }}</th>
                    <th colspan="2" class="text-center">{{ __('_field.age') }}</th>
                    <th rowspan="2" class="align-middle w-25 text-center bk-min-w-100">{{ __('_field.price') }}</th>
                    <th rowspan="2" class="align-middle w-25 text-center bk-min-w-100">{{ __('_field.lessons') }}</th>
                    @if(@is_access('group_full'))
                    <th rowspan="2" class="align-middle text-center">{{ __('_action.this') }}</th>
                    @endif
                </tr>
                <tr>
                    <th class="text-center bk-min-w-100" title="{{ __('_field.group') }}">
                        Гр {{ @fa('fa-info-circle') }}
                    </th>
                    <th class="text-center bk-min-w-100" title="{{ __('_field.free_seats') }}">
                        БМ {{ @fa('fa-info-circle') }}
                    </th>
                    <th class="text-center bk-min-w-100" title="{{ __('_field.paid_seats') }}">
                        ПМ {{ @fa('fa-info-circle') }}
                    </th>
                    <th class="text-center bk-min-w-100">
                        от
                    </th>
                    <th class="text-center bk-min-w-100">
                        до
                    </th>
                </tr>
            </thead>
            <tbody>
            @if($groups)
                @include('admin.pages.groups.certain-groups')
            @else
                @include('admin.pages.groups.all-groups')
            @endif
            </tbody>
        </table>
    </section>
@endsection
