@extends('admin.index')
@section('title-admin', __('section.customers'))
@section('content-admin')
    <section id="customers-index" class="overflow-auto">
        <h3>{{ __('section.customers') }}</h3>

        @if(@is_access('member_full'))
        <div class="my-2 btn-group">
            <a class="btn btn-primary" href="{{ route('admin.customers.create') }}">
                {{ __('record.new') }}
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
                <th class="w-25 bk-min-w-150">{{ __('person.fio') }}</th>
                <th class="w-25 bk-min-w-150">{{ __('person.age') }}</th>
                <th class="w-25 no-sort bk-min-w-150">{{ __('person.phone') }}</th>
                <th class="w-25 no-sort bk-min-w-150">{{ __('person.address') }}</th>
                <th class="no-sort">{{ __('base.action') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $index => $user)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ @full_fio($user->id) }}</td>
                    <td>{{ $user->age }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->address_fact }}</td>
                    <td>
                        <div class="bk-btn-actions">
                            <a class="bk-btn-action bk-btn-action--info btn btn-info"
                               href="{{ route('admin.customers.show', $user) }}"
                               data-tip="{{ __('base.info') }}" ></a>
                            @if(@is_access('member_full'))
                            <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
                               href="{{ route('admin.customers.edit', $user) }}"
                               data-tip="{{ __('operation.edit') }}" ></a>
                            <a class="bk-btn-action bk-btn-action--delete btn btn-danger"
                               href="javascript:void(0)"
                               data-id="{{ $user->id }}"
                               data-toggle="modal"
                               data-target="#bk-delete-modal"
                               data-tip="{{ __('operation.delete') }}" ></a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>
@endsection
