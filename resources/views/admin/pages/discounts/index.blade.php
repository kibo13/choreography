@extends('admin.index')
@section('title-admin', __('_section.discounts'))
@section('content-admin')
    <section id="discounts-index" class="overflow-auto">
        <h3>{{ __('_section.discounts') }}</h3>

        @if(@is_access('discount_full'))
        <div class="my-2 btn-group">
            <a class="btn btn-primary" href="{{ route('admin.discounts.create') }}">
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
                    <th class="w-25 bk-min-w-100">{{ __('_field.size') }}</th>
                    <th class="w-50 bk-min-w-250 no-sort">{{ __('_field.note') }}</th>
                    @if(@is_access('discount_full'))
                    <th class="no-sort">{{ __('_action.this') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
            @foreach($discounts as $index => $discount)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ $discount->name }}</td>
                    <td>{{ $discount->size }} {{ @tip('%') }}</td>
                    <td>{{ $discount->note }}</td>
                    @if(@is_access('discount_full'))
                    <td>
                        <div class="bk-btn-actions">
                            <a class="bk-btn-action bk-btn-action--edit btn btn-warning"
                               href="{{ route('admin.discounts.edit', $discount) }}"
                               data-tip="{{ __('_action.edit') }}" ></a>
                            <a class="bk-btn-action bk-btn-action--delete btn btn-danger"
                               href="javascript:void(0)"
                               data-id="{{ $discount->id }}"
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
