@extends('front.layouts.main')

@section('content')
    {{ Menu::events() }}

    <h1>Recent events</h1>

    @include('front.events.partials.list')
@endsection