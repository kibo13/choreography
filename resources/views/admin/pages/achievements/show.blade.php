@extends('admin.index')
@section('title-admin', __('_section.achievements'))
@section('content-admin')
    <section id="achievements-show" class="overflow-auto">
        <h3>{{ __('_section.info') }}</h3>

        @if(session()->has('success'))
        <div class="my-2 alert alert-success" role="alert">
            {{ session()->get('success') }}
        </div>
        @endif

        <div class="bk-form">
            <div class="bk-form__wrapper">

                <!-- event -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.event') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $achievement->event->name }}
                    </div>
                </div>

                <!-- group -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.group') }}
                    </label>
                    <div class="bk-form__text">
                        {{ $achievement->event->group->title->name }}
                        @if($achievement->event->group->category_id != 4)
                        {{ @tip($achievement->event->group->category->name) }}
                        @endif
                    </div>
                </div>

                <!-- result -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.result') }}
                    </label>
                    <ul class="bk-form__text">
                        <li>{{ $achievement->name }}</li>
                        <li>{{ $achievement->num }}</li>
                        <li>{{ $achievement->note }}</li>
                    </ul>
                </div>

                <!-- members -->
                <div class="bk-form__field">
                    <label class="bk-form__label">
                        {{ __('_field.members') }}
                    </label>
                    <table class="dataTables table table-bordered table-hover table-responsive">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th class="w-50 bk-min-w-200">{{ __('_field.member') }}</th>
                                <th class="w-25 bk-min-w-100">{{ __('_field.age') }}</th>
                                <th class="w-25 bk-min-w-100">{{ __('_field.achievement') }}</th>
                                @if(@is_access('achievement_full'))
                                <th>{{ __('_action.this') }}</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($achievement->event->members as $index => $member)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ @full_fio('member', $member->id) }}</td>
                                <td>{{ $member->age . ' лет' }}</td>
                                <td>
                                    @if(@diplom($achievement, $member))
                                    <a class="text-primary"
                                       href="{{ asset('assets/' . @diplom($achievement, $member)->file) }}"
                                       target="_blank">
                                        {{ __('_action.look') }}
                                    </a>
                                    @else
                                    @if(@is_access('achievement_full'))
                                    <form action="{{ route('admin.diploms.store') }}"
                                          method="POST"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="achievement_id" value="{{ $achievement->id }}">
                                        <input type="hidden" name="member_id" value="{{ $member->id }}">
                                        <label class="m-0 text-primary" for="{{ $member->id }}">
                                            {{ __('_action.download') }}
                                        </label>
                                        <input class="d-none"
                                               type="file"
                                               id="{{ $member->id }}"
                                               data-file="store"
                                               name="file"
                                               accept="image/*">
                                    </form>
                                    @else
                                    <span class="text-info">{{ __('_record.no') }}</span>
                                    @endif
                                    @endif
                                </td>
                                @if(@is_access('achievement_full'))
                                <td>
                                    @if(@diplom($achievement, $member))
                                    <button class="text-danger"
                                            data-id="{{ @diplom($achievement, $member)->id }}"
                                            data-file="destroy"
                                            data-toggle="modal"
                                            data-target="#bk-delete-modal">
                                        {{ __('_action.delete') }}
                                    </button>
                                    @endif
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-1 mb-0 form-group">
                    <a class="btn btn-outline-secondary" href="{{ route('admin.achievements.index') }}">
                        {{ __('_action.back') }}
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
