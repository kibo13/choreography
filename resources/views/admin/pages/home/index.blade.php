@extends('admin.index')
@section('title-admin', __('_section.home'))
@section('content-admin')
    <section id="home-index" class="overflow-auto">
        <h3>{{ __('_section.home') }}</h3>

        <input type="hidden" id="is_director" value="{{ $is_director }}">
        <div id="events"></div>
    </section>
@endsection
